<?php
// app/Http/Controllers/Notes/NoteController.php

namespace App\Http\Controllers\Notes;

use App\Http\Controllers\Controller;
use App\Http\Requests\Notes\StoreNoteRequest;
use App\Http\Requests\Notes\UpdateNoteRequest;
use App\Models\Etablissement\AnneeAcademique;
use App\Models\Etablissement\Matiere;
use App\Models\Etablissement\Semestre;
use App\Models\Etablissement\Specialite;
use App\Models\Etudiant;
use App\Models\Inscription;
use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
public function index(Request $request)
{
    $anneeId = $request->filled('annee_academique_id')
        ? $request->annee_academique_id
        : AnneeAcademique::where('est_active', true)->value('id');

    $annees = AnneeAcademique::orderBy('libelle', 'desc')->get();

    $specialites = $anneeId
        ? Specialite::where('est_actif', true)->orderBy('libelle')->get()
        : collect();

    $semestres = collect();
    if ($request->filled('specialite_id') && $anneeId) {
        $semestres = $this->semestresDe($request->specialite_id, $anneeId);
    }

    $matieres = collect();
    if ($request->filled('semestre_id')) {
        $matieres = Matiere::where('semestre_id', $request->semestre_id)
            ->where('est_actif', true)
            ->orderBy('libelle')
            ->get();
    }

    $pretAAfficher = $anneeId
        && $request->filled('specialite_id')
        && $request->filled('semestre_id')
        && $request->filled('matiere_id');

    $notes = $pretAAfficher
        ? $this->etudiantsAvecNotes($request, $anneeId)
        : Etudiant::query()->whereRaw('1 = 0')->paginate(20)->withQueryString();

    $specialiteSansSemestre = $request->filled('specialite_id') && $anneeId && $semestres->isEmpty();

    // ✅ Nouveau : même logique pour un semestre sans matière
    $semestreSansMatiere = $request->filled('semestre_id') && $matieres->isEmpty();

    return view('notes.index', compact(
        'notes', 'annees', 'specialites', 'semestres', 'matieres',
        'anneeId', 'pretAAfficher', 'specialiteSansSemestre', 'semestreSansMatiere'
    ));
}

/**
 * Semestres d'une spécialité pour une année donnée, avec leur niveau
 * déjà chargé (évite le N+1 dans la vue : $semestre->niveau->libelle).
 */
private function semestresDe(int $specialiteId, int $anneeId)
{
    return Semestre::whereHas('niveau', function ($q) use ($specialiteId, $anneeId) {
            $q->where('specialite_id', $specialiteId)
              ->where('annee_academique_id', $anneeId);
        })
        ->with('niveau')
        ->orderBy('libelle')
        ->get();
}

/**
 * TOUS les étudiants inscrits/validés du niveau de la matière choisie,
 * avec leur note (existante ou null -> affichée "-" côté vue), pas
 * uniquement ceux qui ont déjà une note.
 */
private function etudiantsAvecNotes(Request $request, int $anneeId)
{
    $matiere = Matiere::find($request->matiere_id);
    if (!$matiere) {
        return Etudiant::query()->whereRaw('1 = 0')->paginate(20)->withQueryString();
    }

    $paginator = Etudiant::query()
        ->whereHas('inscriptions', function ($q) use ($anneeId, $matiere) {
            $q->where('annee_academique_id', $anneeId)
              ->where('niveau_id', $matiere->niveau_id)
              ->where('statut', 'validee');
        })
        ->with(['inscriptions' => function ($q) use ($anneeId, $matiere) {
            $q->where('annee_academique_id', $anneeId)
              ->where('niveau_id', $matiere->niveau_id)
              ->where('statut', 'validee');
        }])
        ->when($request->filled('search'), function ($q) use ($request) {
            $search = $request->search;
            $q->where(function ($qq) use ($search) {
                $qq->where('nom', 'like', "%{$search}%")
                   ->orWhere('prenom', 'like', "%{$search}%")
                   ->orWhere('matricule', 'like', "%{$search}%");
            });
        })
        ->orderBy('nom')
        ->paginate(20)
        ->withQueryString();

    // On attache la note existante (ou null) de chaque étudiant pour cette matière
    $inscriptionIds = $paginator->getCollection()
        ->pluck('inscriptions')
        ->flatten()
        ->pluck('id')
        ->filter();

    $notesExistantes = Note::where('matiere_id', $matiere->id)
        ->whereIn('inscription_id', $inscriptionIds)
        ->get()
        ->keyBy('inscription_id');

    $paginator->getCollection()->transform(function ($etudiant) use ($notesExistantes) {
        $inscription = $etudiant->inscriptions->first();
        $etudiant->inscription_courante_id = $inscription?->id;
        $etudiant->note_courante = $inscription ? $notesExistantes->get($inscription->id) : null;
        return $etudiant;
    });

    return $paginator;
}

    public function create(Request $request)
    {
        $anneeActive = AnneeAcademique::where('est_active', true)->first();

        $specialites = $anneeActive
            ? Specialite::where('est_actif', true)->with('departement')->orderBy('libelle')->get()
            : collect();

        $semestres = collect();
        if ($request->filled('specialite_id') && $anneeActive) {
            $semestres = $this->semestresDe($request->specialite_id, $anneeActive->id);
        }

        $matieres = collect();
        if ($request->filled('semestre_id')) {
            $matieres = Matiere::where('semestre_id', $request->semestre_id)
                ->where('est_actif', true)
                ->orderBy('libelle')
                ->get();
        }

        $etudiants = collect();
        if ($request->filled('matiere_id') && $anneeActive) {
            $matiere = Matiere::find($request->matiere_id);
            if ($matiere) {
                $etudiants = Etudiant::whereHas('inscriptions', function ($q) use ($anneeActive, $matiere) {
                    $q->where('annee_academique_id', $anneeActive->id)
                        ->where('niveau_id', $matiere->niveau_id)
                        ->where('statut', 'validee');
                })->orderBy('nom')->get();
            }
        }

        return view('notes.create', [
            'anneeActive' => $anneeActive,
            'specialites' => $specialites,
            'semestres' => $semestres,
            'matieres' => $matieres,
            'etudiants' => $etudiants,
            'selectedSpecialite' => $request->query('specialite_id'),
            'selectedSemestre' => $request->query('semestre_id'),
            'selectedMatiere' => $request->query('matiere_id'),
        ]);
    }

    public function getSemestresBySpecialite(Request $request)
    {
        $request->validate([
            'specialite_id' => ['required', 'exists:specialites,id'],
            'annee_academique_id' => ['required', 'exists:annees_academiques,id'],
        ]);

        $semestres = $this->semestresDe($request->specialite_id, $request->annee_academique_id)
            ->map(fn ($s) => [
                'id' => $s->id,
                'libelle' => $s->libelle . ' (' . ($s->niveau->libelle ?? '') . ')',
            ]);

        return response()->json($semestres);
    }

    public function store(StoreNoteRequest $request)
    {
        $moyenne = Note::calculateMoyenne($request->note_cc, $request->note_examen);
        $matiere = Matiere::find($request->matiere_id);

        $note = Note::updateOrCreate(
            [
                'etudiant_id' => $request->etudiant_id,
                'matiere_id' => $request->matiere_id,
                'inscription_id' => $request->inscription_id,
            ],
            [
                'semestre_id' => $request->semestre_id,
                'note_cc' => $request->note_cc,
                'note_examen' => $request->note_examen,
                'moyenne' => $moyenne,
                'credit' => $matiere->credit ?? 0,
            ]
        );

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'note' => $note,
                'message' => 'Note enregistrée avec succès. Moyenne : ' . number_format($moyenne, 2),
            ]);
        }

        return redirect()->route('notes.index')
            ->with('success', 'Note enregistrée avec succès. Moyenne: ' . number_format($moyenne, 2));
    }

    public function storeBulk(Request $request)
    {
        $request->validate([
            'matiere_id' => ['required', 'exists:matieres,id'],
            'semestre_id' => ['required', 'exists:semestres,id'],
            'notes' => ['required', 'array', 'min:1'],
            'notes.*.etudiant_id' => ['required', 'exists:etudiants,id'],
            'notes.*.inscription_id' => ['required', 'exists:inscriptions,id'],
            'notes.*.note_cc' => ['required', 'numeric', 'min:0', 'max:20'],
            'notes.*.note_examen' => ['required', 'numeric', 'min:0', 'max:20'],
        ]);

        $matiere = Matiere::find($request->matiere_id);
        $enregistrees = 0;

        foreach ($request->notes as $ligne) {
            Note::updateOrCreate(
                [
                    'etudiant_id' => $ligne['etudiant_id'],
                    'matiere_id' => $request->matiere_id,
                    'inscription_id' => $ligne['inscription_id'],
                ],
                [
                    'semestre_id' => $request->semestre_id,
                    'note_cc' => $ligne['note_cc'],
                    'note_examen' => $ligne['note_examen'],
                    'moyenne' => Note::calculateMoyenne($ligne['note_cc'], $ligne['note_examen']),
                    'credit' => $matiere->credit ?? 0,
                ]
            );
            $enregistrees++;
        }

        return response()->json([
            'success' => true,
            'message' => $enregistrees . ' note(s) enregistrée(s) avec succès.',
        ]);
    }

    public function show(Note $note)
    {
        $note->load(['etudiant', 'matiere', 'inscription', 'semestre']);
        return view('notes.show', compact('note'));
    }

    public function edit(Note $note)
    {
        return view('notes.edit', compact('note'));
    }

    public function update(UpdateNoteRequest $request, Note $note)
    {
        $moyenne = Note::calculateMoyenne($request->note_cc, $request->note_examen);

        $note->update([
            'note_cc' => $request->note_cc,
            'note_examen' => $request->note_examen,
            'moyenne' => $moyenne,
        ]);

        return redirect()->route('notes.index')->with('success', 'Note mise à jour avec succès.');
    }

    public function destroy(Note $note)
    {
        $note->delete();
        return redirect()->route('notes.index')->with('success', 'Note supprimée avec succès.');
    }

    public function getEtudiantsByMatiere(Request $request)
    {
        $request->validate([
            'matiere_id' => ['required', 'exists:matieres,id'],
            'annee_academique_id' => ['required', 'exists:annees_academiques,id'],
        ]);

        $matiere = Matiere::find($request->matiere_id);
        if (!$matiere) {
            return response()->json([]);
        }

        $etudiants = Etudiant::whereHas('inscriptions', function ($q) use ($request, $matiere) {
                $q->where('annee_academique_id', $request->annee_academique_id)
                    ->where('niveau_id', $matiere->niveau_id)
                    ->where('statut', 'validee');
            })
            ->with(['inscriptions' => function ($q) use ($request, $matiere) {
                $q->where('annee_academique_id', $request->annee_academique_id)
                    ->where('niveau_id', $matiere->niveau_id)
                    ->where('statut', 'validee');
            }])
            ->orderBy('nom')
            ->get(['id', 'nom', 'prenom', 'matricule']);

        $notesExistantes = Note::where('matiere_id', $matiere->id)
            ->whereIn('etudiant_id', $etudiants->pluck('id'))
            ->get()
            ->keyBy('etudiant_id');

        $resultat = $etudiants->map(function ($etudiant) use ($notesExistantes) {
            $inscription = $etudiant->inscriptions->first();
            $note = $notesExistantes->get($etudiant->id);

            return [
                'id' => $etudiant->id,
                'nom_complet' => $etudiant->nom_complet,
                'matricule' => $etudiant->matricule,
                'inscription_id' => $inscription?->id,
                'note_cc' => $note?->note_cc,
                'note_examen' => $note?->note_examen,
                'moyenne' => $note?->moyenne,
            ];
        })->filter(fn ($e) => $e['inscription_id'] !== null)->values();

        return response()->json($resultat);
    }

    public function getInscription(Request $request)
    {
        $inscription = Inscription::where('etudiant_id', $request->etudiant_id)
            ->where('annee_academique_id', $request->annee_academique_id)
            ->where('statut', 'validee')
            ->first();

        return response()->json($inscription);
    }
}