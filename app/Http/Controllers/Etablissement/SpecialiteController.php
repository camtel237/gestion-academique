<?php
// app/Http/Controllers/Etablissement/SpecialiteController.php

namespace App\Http\Controllers\Etablissement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Etablissement\StoreSpecialiteRequest;
use App\Http\Requests\Etablissement\UpdateSpecialiteRequest;
use App\Models\Etablissement\Departement;
use App\Models\Etablissement\Specialite;
use Illuminate\Http\Request;
use  App\Models\Etablissement\AnneeAcademique;

class SpecialiteController extends Controller
{
    public function index(Request $request)
    {
        $query = Specialite::with(['departement']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                    ->orWhere('libelle', 'like', "%{$search}%");
            });
        }

        if ($request->filled('departement_id')) {
            $query->where('departement_id', $request->departement_id);
        }

        if ($request->filled('est_actif')) {
            $query->where('est_actif', $request->boolean('est_actif'));
        }

        $specialites = $query->orderBy('libelle')->paginate(10);

        $departements = Departement::where('est_actif', true)->orderBy('libelle')->get();

        return view('etablissement.specialites.index', compact('specialites', 'departements'));
    }

    public function create()
    {
        $departements = Departement::where('est_actif', true)->orderBy('libelle')->get();
        $anneesAcademiques=AnneeAcademique::all();
        return view('etablissement.specialites.create', compact('departements','anneesAcademiques'));
    }

        public function store(StoreSpecialiteRequest $request)
        {
            $data = $request->validated();
            $data['code'] = $this->genererCodeDepuisLibelle($data['libelle'], \App\Models\Etablissement\Specialite::class);

            Specialite::create($data);

            return redirect()->route('specialites.index')
                ->with('success', 'Spécialité créée avec succès. Code : ' . $data['code']);
        }

        private function genererCodeDepuisLibelle(string $libelle, string $modelClass): string
        {
            $base = strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $libelle), 0, 4));
            $base = $base ?: 'SPE';
            $code = $base;
            $i = 1;
            while ($modelClass::where('code', $code)->exists()) {
                $code = $base . $i;
                $i++;
            }
            return $code;
        }

    public function show(Specialite $specialite)
    {
        $specialite->load(['departement', 'niveaux']);
        return view('etablissement.specialites.show', compact('specialite'));
    }

    public function edit(Specialite $specialite)
    {
        $departements = Departement::where('est_actif', true)->orderBy('libelle')->get();
        return view('etablissement.specialites.edit', compact('specialite', 'departements'));
    }

    public function update(UpdateSpecialiteRequest $request, Specialite $specialite)
    {
        $specialite->update($request->validated());

        return redirect()->route('specialites.index')
            ->with('success', 'Spécialité mise à jour avec succès.');
    }

    public function destroy(Specialite $specialite)
    {
        // Vérifier si des niveaux sont liés
        if ($specialite->niveaux()->exists()) {
            return back()->with('error', 'Impossible de supprimer cette spécialité car elle contient des niveaux.');
        }

        $specialite->delete();

        return redirect()->route('specialites.index')
            ->with('success', 'Spécialité supprimée avec succès.');
    }

    public function toggleStatus(Specialite $specialite)
    {
        $specialite->update(['est_actif' => !$specialite->est_actif]);

        $status = $specialite->est_actif ? 'activée' : 'désactivée';

        return redirect()->route('specialites.index')
            ->with('success', "Spécialité {$status} avec succès.");
    }
}