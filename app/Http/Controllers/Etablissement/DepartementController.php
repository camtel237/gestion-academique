<?php
// app/Http/Controllers/Etablissement/DepartementController.php

namespace App\Http\Controllers\Etablissement;

use App\Http\Controllers\Controller;
use App\Http\Requests\Etablissement\StoreDepartementRequest;
use App\Http\Requests\Etablissement\UpdateDepartementRequest;
use App\Models\Etablissement\Departement;
use App\Models\Etablissement\Personnel;
use Illuminate\Http\Request;

class DepartementController extends Controller
{
    public function index(Request $request)
    {
        $query = Departement::with(['chefDepartement', 'specialites'])
            ->orderBy('libelle');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('libelle', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
            });
        }

        $departements = $query->paginate(10)->withQueryString();

        return view('etablissement.departements.index', compact('departements'));
    }

    public function create()
    {
            $personnels = Personnel::select(
                'id',
                'matricule',
                'nom',
                'prenom'
            )
            ->where('est_actif', true)
            ->orderBy('nom')
            ->orderBy('prenom')
            ->get();

        return view('etablissement.departements.create', compact('personnels'));
    }

        public function store(StoreDepartementRequest $request)
        {
            $data = $request->validated();
            $data['code'] = $this->genererCodeDepuisLibelle($data['libelle'], \App\Models\Etablissement\Departement::class);

            \App\Models\Etablissement\Departement::create($data);

            return redirect()->route('departements.index')
                ->with('success', 'Département créé avec succès. Code : ' . $data['code']);
        }

        private function genererCodeDepuisLibelle(string $libelle, string $modelClass): string
        {
            $base = strtoupper(substr(preg_replace('/[^A-Za-z]/', '', $libelle), 0, 4));
            $base = $base ?: 'DPT';
            $code = $base;
            $i = 1;
            while ($modelClass::where('code', $code)->exists()) {
                $code = $base . $i;
                $i++;
            }
            return $code;
        }
    public function show(Departement $departement)
    {
        $departement->load(['chefDepartement', 'specialites', 'niveaux']);
        return view('etablissement.departements.show', compact('departement'));
    }

    public function edit(Departement $departement)
    {
            $personnels = Personnel::select(
                'id',
                'matricule',
                'nom',
                'prenom'
            )
            ->where('est_actif', true)
            ->orderBy('nom')
            ->orderBy('prenom')
            ->get();

        return view('etablissement.departements.edit', compact('departement', 'personnels'));
    }

    public function update(UpdateDepartementRequest $request, Departement $departement)
    {
        $departement->update($request->validated());

        return redirect()->route('departements.index')
            ->with('success', 'Département mis à jour avec succès.');
    }

    public function destroy(Departement $departement)
    {
            if (
                $departement->specialites()->exists()
                || $departement->niveaux()->exists()
            ) {

            return back()->with(
                'error',
                'Impossible de supprimer ce département car il est utilisé.'
    );
}

        $departement->delete();

        return redirect()->route('departements.index')
            ->with('success', 'Département supprimé avec succès.');
    }

    public function toggleStatus(Departement $departement)
    {
        $departement->update(['est_actif' => !$departement->est_actif]);

        return redirect()->route('departements.index')
            ->with('success', 'Statut du département modifié avec succès.');
    }

  public function nommerChef(Request $request, Departement $departement)
{
    $data = $request->validate([

        'personnel_id' => [

            'required',

            Rule::exists('personnels', 'id')
                ->where(fn ($query) => $query->where('est_actif', true))

        ]

    ]);

    $departement->update([
        'chef_departement_id' => $data['personnel_id']
    ]);

    return redirect()
        ->route('departements.show', $departement)
        ->with('success', 'Chef de département nommé avec succès.');
}

    public function retirerChef(Departement $departement)
    {
        $departement->update(['chef_departement_id' => null]);

        return redirect()->route('departements.show', $departement)
            ->with('success', 'Chef de département retiré avec succès.');
    }
}