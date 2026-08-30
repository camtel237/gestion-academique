<?php
// app/Http/Controllers/Dashboard/DashboardController.php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Etablissement\AnneeAcademique;
use App\Models\Etablissement\Departement;
use App\Models\Etablissement\Personnel;
use App\Models\Etudiant;
use App\Models\Inscription;
use App\Models\Note;

class DashboardController extends Controller
{
    public function index()
    {
        $anneeActive = AnneeAcademique::where('est_active', true)->first();

        $stats = [
            'etudiants'     => $anneeActive
                ? Inscription::where('annee_academique_id', $anneeActive->id)->where('statut', 'validee')->count()
                : 0,
            'personnels'    => Personnel::where('est_actif', true)->count(),
            'departements'  => Departement::where('est_actif', true)->count(),
            'taux_reussite' => $this->tauxReussite($anneeActive),
        ];

        $activites = $this->dernieresActivites();
        $inscriptionsParMois = $this->inscriptionsParMois($anneeActive);

        // Nouveaux graphiques
        $etudiantsParDepartement   = $this->etudiantsParDepartement($anneeActive);
        $tauxReussiteParDepartement = $this->tauxReussiteParDepartement($anneeActive);
        $evolutionTauxReussite     = $this->evolutionTauxReussite();
        $repartitionParPays        = $this->repartitionParPays($anneeActive);
        $repartitionParSexe        = $this->repartitionParSexe($anneeActive);

        return view('dashboard.index', compact(
            'stats', 'activites', 'inscriptionsParMois', 'anneeActive',
            'etudiantsParDepartement', 'tauxReussiteParDepartement',
            'evolutionTauxReussite', 'repartitionParPays', 'repartitionParSexe'
        ));
    }

    private function tauxReussite(?AnneeAcademique $annee): int
    {
        if (!$annee) return 0;

        $total = Note::whereHas('inscription', fn($q) => $q->where('annee_academique_id', $annee->id))->count();
        if ($total === 0) return 0;

        $reussies = Note::whereHas('inscription', fn($q) => $q->where('annee_academique_id', $annee->id))
            ->where('moyenne', '>=', 10)
            ->count();

        return (int) round($reussies / $total * 100);
    }

    private function dernieresActivites()
    {
        $inscriptions = Inscription::with('etudiant')
            ->latest()->take(5)->get()
            ->map(fn($i) => (object) [
                'icon'  => 'fa-user-plus',
                'color' => 'green',
                'texte' => 'Nouvelle inscription : ' . ($i->etudiant->nom_complet ?? $i->etudiant->prenom . ' ' . $i->etudiant->nom ?? '-'),
                'date'  => $i->created_at,
            ]);

        $notes = Note::with('etudiant')
            ->latest()->take(5)->get()
            ->map(fn($n) => (object) [
                'icon'  => 'fa-file-circle-check',
                'color' => 'blue',
                'texte' => 'Note saisie pour ' . ($n->etudiant->nom_complet ?? $n->etudiant->prenom . ' ' . $n->etudiant->nom ?? '-'),
                'date'  => $n->created_at,
            ]);

        return $inscriptions->concat($notes)
            ->sortByDesc('date')
            ->take(6)
            ->values();
    }

    private function inscriptionsParMois(?AnneeAcademique $annee): array
    {
        if (!$annee) {
            return array_fill(0, 12, 0);
        }

        $parMois = Inscription::where('annee_academique_id', $annee->id)
            ->selectRaw('MONTH(created_at) as mois, COUNT(*) as total')
            ->groupBy('mois')
            ->pluck('total', 'mois');

        return collect(range(1, 12))
            ->map(fn($m) => $parMois[$m] ?? 0)
            ->values()
            ->toArray();
    }

    /**
     * Nombre d'étudiants (inscriptions validées de l'année active) par département.
     */
    private function etudiantsParDepartement(?AnneeAcademique $annee): array
    {
        if (!$annee) {
            return ['labels' => [], 'data' => []];
        }

        $rows = Inscription::where('inscriptions.annee_academique_id', $annee->id)
            ->where('inscriptions.statut', 'validee')
            ->join('departements', 'inscriptions.departement_id', '=', 'departements.id')
            ->selectRaw('departements.libelle as departement, COUNT(*) as total')
            ->groupBy('departements.id', 'departements.libelle')
            ->orderByDesc('total')
            ->get();

        return [
            'labels' => $rows->pluck('departement')->toArray(),
            'data'   => $rows->pluck('total')->toArray(),
        ];
    }

    /**
     * Taux de réussite (%) par département, sur l'année active.
     */
    private function tauxReussiteParDepartement(?AnneeAcademique $annee): array
    {
        if (!$annee) {
            return ['labels' => [], 'data' => []];
        }

        $rows = Note::join('inscriptions', 'notes.inscription_id', '=', 'inscriptions.id')
            ->join('departements', 'inscriptions.departement_id', '=', 'departements.id')
            ->where('inscriptions.annee_academique_id', $annee->id)
            ->selectRaw('departements.libelle as departement, COUNT(*) as total, SUM(CASE WHEN notes.moyenne >= 10 THEN 1 ELSE 0 END) as reussies')
            ->groupBy('departements.id', 'departements.libelle')
            ->get();

        return [
            'labels' => $rows->pluck('departement')->toArray(),
            'data'   => $rows->map(fn($r) => $r->total > 0 ? (int) round($r->reussies / $r->total * 100) : 0)->toArray(),
        ];
    }

    /**
     * Évolution du taux de réussite global, toutes années académiques confondues,
     * triées chronologiquement.
     */
    private function evolutionTauxReussite(): array
    {
        $annees = AnneeAcademique::orderBy('date_debut')->get();

        return [
            'labels' => $annees->pluck('libelle')->toArray(),
            'data'   => $annees->map(fn($a) => $this->tauxReussite($a))->toArray(),
        ];
    }

    /**
     * Répartition des inscriptions validées de l'année active, par pays de l'étudiant.
     */
    private function repartitionParPays(?AnneeAcademique $annee): array
    {
        if (!$annee) {
            return ['labels' => [], 'data' => []];
        }

        $rows = Inscription::where('inscriptions.annee_academique_id', $annee->id)
            ->where('inscriptions.statut', 'validee')
            ->join('etudiants', 'inscriptions.etudiant_id', '=', 'etudiants.id')
            ->selectRaw("COALESCE(NULLIF(etudiants.pays, ''), 'Non renseigné') as pays, COUNT(*) as total")
            ->groupBy('pays')
            ->orderByDesc('total')
            ->get();

        return [
            'labels' => $rows->pluck('pays')->toArray(),
            'data'   => $rows->pluck('total')->toArray(),
        ];
    }

    /**
     * Répartition des inscriptions validées de l'année active, par sexe de l'étudiant.
     */
    private function repartitionParSexe(?AnneeAcademique $annee): array
    {
        if (!$annee) {
            return ['labels' => ['Masculin', 'Féminin'], 'data' => [0, 0]];
        }

        $rows = Inscription::where('inscriptions.annee_academique_id', $annee->id)
            ->where('inscriptions.statut', 'validee')
            ->join('etudiants', 'inscriptions.etudiant_id', '=', 'etudiants.id')
            ->selectRaw("etudiants.sexe as sexe, COUNT(*) as total")
            ->groupBy('etudiants.sexe')
            ->get();

        $labels = ['M' => 'Masculin', 'F' => 'Féminin'];

        return [
            'labels' => $rows->map(fn($r) => $labels[$r->sexe] ?? ($r->sexe ?? 'Non renseigné'))->toArray(),
            'data'   => $rows->pluck('total')->toArray(),
        ];
    }
}