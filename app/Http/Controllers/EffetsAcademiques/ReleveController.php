<?php
// app/Http/Controllers/EffetsAcademiques/ReleveController.php

namespace App\Http\Controllers\EffetsAcademiques;

use App\Http\Controllers\Controller;
use App\Models\EffetNumero;
use App\Models\Etablissement\UniteEnseignement;
use App\Models\Inscription;
use App\Models\Note;
use Barryvdh\DomPDF\Facade\Pdf;

class ReleveController extends Controller
{
    /**
     * Liste des inscriptions validées pour lesquelles un relevé peut être généré.
     */
    public function index()
    {
        $inscriptions = Inscription::where('statut', 'validee')
            ->with(['etudiant', 'anneeAcademique', 'departement', 'specialite', 'niveau'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('effets.releves.index', compact('inscriptions'));
    }

    public function show($id)
    {
        $inscription = Inscription::with([
            'etudiant', 'anneeAcademique', 'departement', 'specialite', 'niveau',
        ])->findOrFail($id);

        if ($inscription->statut !== 'validee') {
            return redirect()->route('releves.index')
                ->with('error', "Cette inscription n'est pas validée.");
        }

        return view('effets.releves.show', compact('inscription'));
    }

    public function preview($id)
    {
        return $this->genererPdf($id, apercu: true)->stream('apercu_releve.pdf');
    }

    public function download($id)
    {
        $inscription = Inscription::with('etudiant')->findOrFail($id);

        return $this->genererPdf($id, apercu: false)
            ->download('releve_notes_' . $inscription->etudiant->matricule . '.pdf');
    }

    private function genererPdf(int $id, bool $apercu)
    {
        $inscription = Inscription::with([
            'etudiant', 'anneeAcademique', 'departement', 'specialite', 'niveau',
        ])->findOrFail($id);

        $ues = $this->construireReleve($inscription);
        $synthese = $this->calculerSynthese($ues);

        $numero = $apercu
            ? EffetNumero::where('type', 'releve')->max('numero') + 1
            : EffetNumero::next('releve', $inscription->id);

        $pdf = Pdf::loadView('effets.releves.pdf', compact('inscription', 'ues', 'synthese', 'numero'));
        $pdf->setPaper('a4', 'portrait');

        return $pdf;
    }

    /**
     * Construit la structure du relevé : liste des UE du niveau de l'étudiant
     * (pour l'année académique de l'inscription), chacune avec ses matières (EC)
     * et la note obtenue par l'étudiant pour chacune.
     */
    private function construireReleve(Inscription $inscription)
    {
        $ues = UniteEnseignement::whereHas('semestre', function ($q) use ($inscription) {
                $q->where('niveau_id', $inscription->niveau_id)
                  ->where('annee_academique_id', $inscription->annee_academique_id);
            })
            ->with(['matieres' => function ($q) use ($inscription) {
                $q->where('niveau_id', $inscription->niveau_id)->orderBy('libelle');
            }])
            ->orderBy('position_releve')
            ->orderBy('code')
            ->get();

        // Toutes les notes de l'étudiant, indexées par matiere_id pour un accès rapide
        $notes = Note::where('etudiant_id', $inscription->etudiant_id)
            ->where('inscription_id', $inscription->id)
            ->get()
            ->keyBy('matiere_id');

        return $ues->map(function ($ue) use ($notes) {
            $matieresAvecNote = $ue->matieres->map(function ($matiere) use ($notes) {
                $note = $notes->get($matiere->id);

                return (object) [
                    'code' => $matiere->code,
                    'libelle' => $matiere->libelle,
                    'credit' => $matiere->credit,
                    'moyenne' => $note?->moyenne,
                    'grade' => $this->lettreGrade($note?->moyenne),
                    'decision' => $this->decision($note?->moyenne),
                    'a_note' => $note !== null,
                ];
            });

            $creditTotal = $matieresAvecNote->sum('credit');
            $creditNotes = $matieresAvecNote->where('a_note', true)->sum('credit');

            // Moyenne de l'UE = moyenne pondérée par les crédits des EC notés
            $moyenneUe = $creditNotes > 0
                ? $matieresAvecNote->where('a_note', true)->sum(fn ($m) => $m->moyenne * $m->credit) / $creditNotes
                : null;

            return (object) [
                'code' => $ue->code,
                'libelle' => $ue->libelle,
                'credit' => $ue->total_credit ?? $creditTotal,
                'moyenne' => $moyenneUe,
                'grade' => $this->lettreGrade($moyenneUe),
                'decision' => $this->decision($moyenneUe),
                'matieres' => $matieresAvecNote,
                'complete' => $matieresAvecNote->every(fn ($m) => $m->a_note),
            ];
        });
    }

    /**
     * Synthèse générale de l'année : UE/EC acquis, crédits, moyenne générale, mention, décision.
     */
    private function calculerSynthese($ues)
    {
        $toutesMatieres = $ues->flatMap(fn ($ue) => $ue->matieres);
        $matieresNotees = $toutesMatieres->where('a_note', true);

        $creditTotal = $toutesMatieres->sum('credit');
        $creditAcquis = $ues->where('moyenne', '>=', 10)->sum('credit');

        $moyenneGenerale = $matieresNotees->sum('credit') > 0
            ? $matieresNotees->sum(fn ($m) => $m->moyenne * $m->credit) / $matieresNotees->sum('credit')
            : null;

        $ueAcquis = $ues->where('moyenne', '>=', 10)->count();
        $ecAcquis = $matieresNotees->where('moyenne', '>=', 10)->count();

        return (object) [
            'ue_acquis' => $ueAcquis,
            'ue_total' => $ues->count(),
            'ec_acquis' => $ecAcquis,
            'ec_total' => $toutesMatieres->count(),
            'credit_acquis' => $creditAcquis,
            'credit_total' => $creditTotal,
            'taux_ue' => $ues->count() > 0 ? round($ueAcquis / $ues->count() * 100, 2) : 0,
            'taux_ec' => $toutesMatieres->count() > 0 ? round($ecAcquis / $toutesMatieres->count() * 100, 2) : 0,
            'moyenne' => $moyenneGenerale,
            'grade' => $this->lettreGrade($moyenneGenerale),
            'mention' => $this->mention($moyenneGenerale),
            'decision' => $moyenneGenerale !== null
                ? ($moyenneGenerale >= 10 ? 'Admis(e)' : 'Ajourné(e)')
                : 'En attente',
        ];
    }

    private function lettreGrade(?float $moyenne): string
    {
        if ($moyenne === null) return '-';
        if ($moyenne >= 16) return 'A';
        if ($moyenne >= 14) return 'B';
        if ($moyenne >= 12) return 'C';
        if ($moyenne >= 10) return 'D';
        return 'F';
    }

    private function decision(?float $moyenne): string
    {
        if ($moyenne === null) return '-';
        return $moyenne >= 10 ? 'VA' : 'NV';
    }

    private function mention(?float $moyenne): string
    {
        if ($moyenne === null) return '-';
        if ($moyenne >= 16) return 'Très bien';
        if ($moyenne >= 14) return 'Bien';
        if ($moyenne >= 12) return 'Assez bien';
        if ($moyenne >= 10) return 'Passable';
        return 'Insuffisant';
    }
}