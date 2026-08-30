<?php
// app/Http/Controllers/Etablissement/MatiereController.php

namespace App\Http\Controllers\Etablissement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Etablissement\StoreMatiereRequest;
use App\Http\Requests\Etablissement\UpdateMatiereRequest;
use App\Models\Etablissement\Departement;
use App\Models\Etablissement\Matiere;
use App\Models\Etablissement\Niveau;
use App\Models\Etablissement\Personnel;
use App\Models\Etablissement\Semestre;
use App\Models\Etablissement\UniteEnseignement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MatiereController extends Controller
{
    public function index(Request $request)
{
    $query = Matiere::with(['departement', 'uniteEnseignement', 'semestre.niveau', 'niveau', 'personnel']);

    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('code', 'like', "%{$search}%")
              ->orWhere('libelle', 'like', "%{$search}%");
        });
    }

    // ✅ Filtre par spécialité (via le niveau de la matière)
    if ($request->filled('specialite_id')) {
        $query->whereHas('niveau', function ($q) use ($request) {
            $q->where('specialite_id', $request->specialite_id);
        });
    }

    // ✅ "Niveau" du filtre = en réalité un semestre précis (le libellé affiché
    // combine niveau + semestre, ex: "L1 (S1)"), donc on filtre sur semestre_id
    if ($request->filled('semestre_id')) {
        $query->where('semestre_id', $request->semestre_id);
    }

    $matieres = $query->orderBy('code')->paginate(10)->withQueryString();

    $specialites = \App\Models\Etablissement\Specialite::where('est_actif', true)
        ->orderBy('libelle')
        ->get();

    $semestres = collect();
    if ($request->filled('specialite_id')) {
        $semestres = Semestre::whereHas('niveau', function ($q) use ($request) {
                $q->where('specialite_id', $request->specialite_id);
            })
            ->with('niveau')
            ->orderBy('libelle')
            ->get();
    }

    return view('etablissement.matieres.index', compact('matieres', 'specialites', 'semestres'));
}

    public function create(Request $request)
    {
        $departements = Departement::where('est_actif', true)->orderBy('libelle')->get();
        $personnels   = Personnel::where('est_actif', true)->orderBy('nom')->get();

        // Variables pour la vue (vides, remplies par AJAX)
        $ues = collect();
        $semestres = Semestre::orderBy('libelle')->get();
        $niveaux = collect();

        $selectedUE       = $request->query('unite_enseignement_id');
        $selectedSemestre = $request->query('semestre_id');
        $selectedNiveau   = $request->query('niveau_id');

        return view('etablissement.matieres.create', compact(
            'departements', 'personnels', 'ues', 'semestres', 'niveaux',
            'selectedUE', 'selectedSemestre', 'selectedNiveau'
        ));
    }

    public function store(StoreMatiereRequest $request)
    {
        $data = $request->validated();
        $data['code'] = \App\Support\CodeGenerator::generate('MAT', Matiere::class);

        Matiere::create($data);

        return redirect()->route('matieres.index')
            ->with('success', 'Matière créée avec succès. Code : ' . $data['code']);
    }

    public function show(Matiere $matiere)
    {
        $matiere->load(['departement', 'uniteEnseignement', 'semestre', 'niveau', 'personnel']);
        return view('etablissement.matieres.show', compact('matiere'));
    }

    public function edit(Matiere $matiere)
{
    $departements = Departement::where('est_actif', true)->orderBy('libelle')->get();
    $personnels   = Personnel::where('est_actif', true)->orderBy('nom')->get();

    $matiere->load('niveau', 'uniteEnseignement', 'semestre');

    // Récupérer les niveaux du département de la matière
    $niveaux = Niveau::where('departement_id', $matiere->departement_id)
        ->where('est_actif', true)
        ->with('specialite')
        ->orderBy('libelle')
        ->get()
        ->map(function ($niveau) {
            $niveau->display_name = $niveau->libelle . ' (' . ($niveau->specialite->libelle ?? 'Sans spécialité') . ')';
            return $niveau;
        });

    // Récupérer les semestres du niveau actuel
    $semestres = Semestre::where('niveau_id', $matiere->niveau_id)
        ->orderBy('libelle')
        ->get();

    // Récupérer les UE du semestre actuel
    $ues = UniteEnseignement::where('semestre_id', $matiere->semestre_id)
        ->orderBy('libelle')
        ->get();

    return view('etablissement.matieres.edit', compact(
        'matiere',
        'departements',
        'personnels',
        'niveaux',
        'semestres',
        'ues'
    ));
}

    public function update(UpdateMatiereRequest $request, Matiere $matiere)
    {
        $matiere->update($request->validated());

        return redirect()->route('matieres.index')
            ->with('success', 'Matière mise à jour avec succès.');
    }

    public function destroy(Matiere $matiere)
    {
        $matiere->delete();

        return redirect()->route('matieres.index')
            ->with('success', 'Matière supprimée avec succès.');
    }

    public function toggleStatus(Matiere $matiere)
    {
        $matiere->update(['est_actif' => !$matiere->est_actif]);

        $status = $matiere->est_actif ? 'activée' : 'désactivée';

        return redirect()->route('matieres.index')
            ->with('success', "Matière {$status} avec succès.");
    }

    // ═══════════════════════════════════════════════
    // ROUTES AJAX — cascade departement → niveau → semestre/UE
    // ═══════════════════════════════════════════════

    /**
     * Niveaux d'un département
     */
public function getNiveauxByDepartement(Request $request)
{
    try {
        $request->validate([
            'departement_id' => ['nullable', 'integer', 'exists:departements,id'],
        ]);

        $departementId = $request->input('departement_id');

        if (!$departementId) {
            return response()->json([]);
        }

        $niveaux = Niveau::where('departement_id', $departementId)
            ->where('est_actif', true)
            ->with('specialite')
            ->orderBy('libelle')
            ->get()
            ->map(fn($niveau) => [
                'id' => $niveau->id,
                'libelle' => $niveau->libelle,
                'display_name' => $niveau->libelle . ' (' . ($niveau->specialite?->libelle ?? 'Sans spécialité') . ')',
                'specialite_id' => $niveau->specialite_id,
                'annee_academique_id' => $niveau->annee_academique_id,
            ]);

        return response()->json($niveaux);
    } catch (\Throwable $e) {
        Log::error('Erreur getNiveauxByDepartement', ['exception' => $e]);

        return response()->json([
            'message' => 'Erreur lors du chargement des niveaux',
        ], 500);
    }
}

/**
 * Récupère les semestres d'un niveau
 */
public function getSemestresByNiveau(Request $request)
{
    try {
        $request->validate([
            'niveau_id' => ['nullable', 'integer', 'exists:niveaux,id'],
        ]);

        $niveauId = $request->input('niveau_id');

        if (!$niveauId) {
            return response()->json([]);
        }

        $semestres = Semestre::where('niveau_id', $niveauId)
            ->orderBy('libelle')
            ->get(['id', 'libelle']);

        return response()->json($semestres);
    } catch (\Throwable $e) {
        Log::error('Erreur getSemestresByNiveau', ['exception' => $e]);

        return response()->json([
            'message' => 'Erreur lors du chargement des semestres',
        ], 500);
    }
}

/**
 * UE du niveau choisi
 */
public function getUesByNiveau(Request $request)
{
    try {
        $request->validate([
            'niveau_id' => ['nullable', 'integer', 'exists:niveaux,id'],
            'semestre_id' => ['nullable', 'integer', 'exists:semestres,id'],
        ]);

        $semestreId = $request->input('semestre_id');

        if (!$semestreId) {
            return response()->json([]);
        }

        $ues = UniteEnseignement::where('semestre_id', $semestreId)
            ->orderBy('libelle')
            ->get(['id', 'libelle', 'total_credit']);

        return response()->json($ues);
    } catch (\Throwable $e) {
        Log::error('Erreur getUesByNiveau', ['exception' => $e]);

        return response()->json([
            'message' => 'Erreur lors du chargement des UE',
        ], 500);
    }
}

}