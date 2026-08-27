<?php
// app/Http/Controllers/Etablissement/UEController.php

namespace App\Http\Controllers\Etablissement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Etablissement\StoreUERequest;
use App\Http\Requests\Etablissement\UpdateUERequest;
use App\Models\Etablissement\AnneeAcademique;
use App\Models\Etablissement\Niveau;
use App\Models\Etablissement\Semestre;
use App\Models\Etablissement\UniteEnseignement;
use Illuminate\Http\Request;

class UEController extends Controller
{
    public function index(Request $request)
    {
        $query = UniteEnseignement::with(['semestre.niveau.specialite', 'semestre.anneeAcademique']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(fn($q) => $q->where('code', 'like', "%{$search}%")
                ->orWhere('libelle', 'like', "%{$search}%"));
        }

        if ($request->filled('annee_academique_id')) {
            $query->whereHas('semestre', fn($q) => $q->where('annee_academique_id', $request->annee_academique_id));
        }

        if ($request->filled('niveau_id')) {
            $query->whereHas('semestre', fn($q) => $q->where('niveau_id', $request->niveau_id));
        }

        $ues = $query->orderBy('code')->paginate(10)->withQueryString();

        $anneesAcademiques = AnneeAcademique::where('est_active', true)->orderBy('libelle', 'desc')->get();
        $niveaux = $this->niveauxAvecLibelle();

        return view('etablissement.ues.index', compact('ues', 'anneesAcademiques', 'niveaux'));
    }

    public function create()
    {
        $anneesAcademiques = AnneeAcademique::where('est_active', true)->orderBy('libelle', 'desc')->get();
        return view('etablissement.ues.create', compact('anneesAcademiques'));
    }

    // ✅ Niveaux de l'ANNÉE choisie uniquement (résout ton problème de niveaux d'années inactives)
    public function getNiveauxByAnnee(Request $request)
    {
        $request->validate(['annee_academique_id' => ['required', 'exists:annees_academiques,id']]);

        $niveaux = Niveau::where('annee_academique_id', $request->annee_academique_id)
            ->where('est_actif', true)
            ->with(['specialite', 'departement'])
            ->orderBy('libelle')
            ->get()
            ->map(fn($n) => [
                'id' => $n->id,
                'display_full' => $n->libelle . ' - ' . ($n->specialite->libelle ?? 'Sans spécialité') . ' (' . ($n->departement->libelle ?? '') . ')',
            ]);

        return response()->json($niveaux);
    }

    public function getSemestresByNiveau(Request $request)
    {
        $request->validate(['niveau_id' => ['required', 'exists:niveaux,id']]);

        $semestres = Semestre::where('niveau_id', $request->niveau_id)
            ->orderBy('libelle')
            ->get(['id', 'libelle']);

        return response()->json($semestres);
    }

    public function store(StoreUERequest $request)
    {
        $data = $request->validated();
        $data['code'] = $this->genererCode();

        UniteEnseignement::create($data);

        return redirect()->route('ues.index')
            ->with('success', 'Unité d\'enseignement créée avec succès. Code : ' . $data['code']);
    }

    public function show(UniteEnseignement $ue)
    {
        $ue->load(['semestre.niveau.specialite', 'semestre.anneeAcademique', 'matieres']);
        return view('etablissement.ues.show', compact('ue'));
    }

    public function edit(UniteEnseignement $ue)
    {
        $ue->load('semestre');
        $anneesAcademiques = AnneeAcademique::where('est_active', true)->orderBy('libelle', 'desc')->get();

        // Niveaux de l'année actuelle de l'UE (via son semestre)
        $niveaux = Niveau::where('annee_academique_id', $ue->semestre->annee_academique_id)
            ->where('est_actif', true)
            ->with(['specialite', 'departement'])
            ->orderBy('libelle')
            ->get()
            ->map(function ($n) {
                $n->display_full = $n->libelle . ' - ' . ($n->specialite->libelle ?? 'Sans spécialité') . ' (' . ($n->departement->libelle ?? '') . ')';
                return $n;
            });

        $semestres = Semestre::where('niveau_id', $ue->semestre->niveau_id)->orderBy('libelle')->get();

        return view('etablissement.ues.edit', compact('ue', 'anneesAcademiques', 'niveaux', 'semestres'));
    }

    public function update(UpdateUERequest $request, UniteEnseignement $ue)
    {
        $data = $request->validated();
        unset($data['code']); // le code ne change jamais

        $ue->update($data);

        return redirect()->route('ues.index')
            ->with('success', 'Unité d\'enseignement mise à jour avec succès.');
    }

    public function destroy(UniteEnseignement $ue)
    {
        if ($ue->matieres()->exists()) {
            return back()->with('error', 'Impossible de supprimer cette UE car elle contient des matières.');
        }

        $ue->delete();

        return redirect()->route('ues.index')
            ->with('success', 'Unité d\'enseignement supprimée avec succès.');
    }

    private function niveauxAvecLibelle()
    {
        return Niveau::where('est_actif', true)
            ->with(['specialite', 'departement'])
            ->orderBy('libelle')
            ->get()
            ->map(function ($niveau) {
                $niveau->display_name = $niveau->libelle . ' (' . ($niveau->specialite->libelle ?? 'Sans spécialité') . ')';
                return $niveau;
            });
    }

    private function genererCode(): string
    {
        return \App\Support\CodeGenerator::generate('UE', UniteEnseignement::class);
    }
}