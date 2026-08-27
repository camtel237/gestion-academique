<?php
// app/Http/Controllers/Etablissement/NiveauController.php

namespace App\Http\Controllers\Etablissement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Etablissement\StoreNiveauRequest;
use App\Http\Requests\Etablissement\UpdateNiveauRequest;
use App\Models\Etablissement\AnneeAcademique;
use App\Models\Etablissement\Departement;
use App\Models\Etablissement\Niveau;
use App\Models\Etablissement\Specialite;
use Illuminate\Http\Request;

class NiveauController extends Controller
{
    public function index(Request $request)
{
    $query = Niveau::with(['specialite', 'departement'])
        ->join('specialites', 'niveaux.specialite_id', '=', 'specialites.id')
        ->select('niveaux.*');

    if ($request->filled('search')) {
        $search = $request->search;
        $query->where('niveaux.libelle', 'like', "%{$search}%");
    }

    if ($request->filled('departement_id')) {
        $query->where('niveaux.departement_id', $request->departement_id);
    }

    if ($request->filled('specialite_id')) {
        $query->where('niveaux.specialite_id', $request->specialite_id);
    }

    // ✅ Tri par spécialité d'abord, puis par niveau
    $niveaux = $query->orderBy('specialites.libelle')
        ->orderBy('niveaux.libelle')
        ->paginate(10)
        ->withQueryString();

    $departements = Departement::where('est_actif', true)->orderBy('libelle')->get();
    $specialitesQuery = Specialite::where('est_actif', true);
    if ($request->filled('departement_id')) {
        $specialitesQuery->where('departement_id', $request->departement_id);
    }
    $specialites = $specialitesQuery->orderBy('libelle')->get();
    $anneesAcademiques = AnneeAcademique::where('est_active', true)->orderBy('libelle', 'desc')->get();

    return view('etablissement.niveaux.index', compact('niveaux', 'departements', 'specialites', 'anneesAcademiques'));
}

    public function create(Request $request)
    {
        // Récupérer tous les départements actifs
        $departements = Departement::where('est_actif', true)->orderBy('libelle')->get();
        
        // Récupérer toutes les spécialités actives
        $specialites = Specialite::where('est_actif', true)->orderBy('libelle')->get();
        
        // Récupérer les années académiques actives
        $anneesAcademiques = AnneeAcademique::where('est_active', true)->orderBy('libelle', 'desc')->get();
        
        // Si un département est passé en paramètre, filtrer les spécialités
        $selectedDepartement = $request->query('departement_id');
        if ($selectedDepartement) {
            $specialites = Specialite::where('departement_id', $selectedDepartement)
                ->where('est_actif', true)
                ->orderBy('libelle')
                ->get();
        }

        return view('etablissement.niveaux.create', compact('departements', 'specialites', 'anneesAcademiques', 'selectedDepartement'));
    }

   public function store(StoreNiveauRequest $request)
{
    // ✅ Validation supplémentaire : vérifier que la spécialité appartient au département
    $specialite = Specialite::find($request->specialite_id);
    if ($specialite->departement_id != $request->departement_id) {
        return back()
            ->withInput()
            ->withErrors(['specialite_id' => 'La spécialité sélectionnée n\'appartient pas au département choisi.']);
    }

    Niveau::create($request->validated());

    return redirect()->route('niveaux.index')
        ->with('success', 'Niveau créé avec succès.');
}

    public function show(Niveau $niveau)
    {
        $niveau->load(['departement', 'specialite', 'anneeAcademique', 'unitesEnseignement', 'matieres', 'semestres']);
        return view('etablissement.niveaux.show', compact('niveau'));
    }

    public function edit(Niveau $niveau)
    {
        $departements = Departement::where('est_actif', true)->orderBy('libelle')->get();
        $anneesAcademiques = AnneeAcademique::where('est_active', true)->orderBy('libelle', 'desc')->get();
        
        // Récupérer toutes les spécialités actives
        $specialites = Specialite::where('est_actif', true)->orderBy('libelle')->get();
        
        // Si le niveau a un département, filtrer les spécialités par ce département
        if ($niveau->departement_id) {
            $specialites = Specialite::where('departement_id', $niveau->departement_id)
                ->where('est_actif', true)
                ->orderBy('libelle')
                ->get();
        }

        return view('etablissement.niveaux.edit', compact('niveau', 'departements', 'specialites', 'anneesAcademiques'));
    }

    public function update(UpdateNiveauRequest $request, Niveau $niveau)
    {
        $niveau->update($request->validated());

        return redirect()->route('niveaux.index')
            ->with('success', 'Niveau mis à jour avec succès.');
    }

    public function destroy(Niveau $niveau)
    {
        if ($niveau->unitesEnseignement()->exists()) {
            return back()->with('error', 'Impossible de supprimer ce niveau car il contient des unités d\'enseignement.');
        }

        if ($niveau->matieres()->exists()) {
            return back()->with('error', 'Impossible de supprimer ce niveau car il contient des matières.');
        }

        $niveau->delete();

        return redirect()->route('niveaux.index')
            ->with('success', 'Niveau supprimé avec succès.');
    }

    public function toggleStatus(Niveau $niveau)
    {
        $niveau->update(['est_actif' => !$niveau->est_actif]);

        $status = $niveau->est_actif ? 'activé' : 'désactivé';

        return redirect()->route('niveaux.index')
            ->with('success', "Niveau {$status} avec succès.");
    }

    public function getSpecialites(Request $request)
    {
        $specialites = Specialite::where('departement_id', $request->departement_id)
            ->where('est_actif', true)
            ->orderBy('libelle')
            ->get(['id', 'libelle', 'code']);

        return response()->json($specialites);
    }
}