<?php
// app/Http/Controllers/EtudiantController.php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEtudiantRequest;
use App\Http\Requests\UpdateEtudiantRequest;
use App\Models\Etudiant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Exports\EtudiantsExport;
use App\Imports\EtudiantsImport;
use Maatwebsite\Excel\Facades\Excel;



class EtudiantController extends Controller
{

 public function export()
{
    return Excel::download(new EtudiantsExport, 'etudiants_' . now()->format('Y-m-d') . '.xlsx');
}

public function import(Request $request)
{
    $request->validate([
        'fichier' => ['required', 'file', 'mimes:xlsx,xls,csv', 'max:5120'],
    ]);

    $import = new EtudiantsImport;
    Excel::import($import, $request->file('fichier'));

    $erreurs = $import->failures();

    if ($erreurs->isNotEmpty()) {
        $messages = $erreurs->map(fn ($f) => "Ligne {$f->row()} : " . implode(', ', $f->errors()))->take(10);
        return back()->with('warning', $erreurs->count() . ' ligne(s) ignorée(s) : ' . $messages->implode(' | '));
    }

    return back()->with('success', 'Étudiants importés avec succès.');
}
    public function index(Request $request)
    {
        $query = Etudiant::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nom', 'like', "%$search%")
                ->orWhere('prenom', 'like', "%$search%")
                ->orWhere('matricule', 'like', "%$search%");
        }

        $etudiants = $query->orderBy('nom')->paginate(15);
        $search = $request->get('search');
        return view('etudiants.index', compact('etudiants', 'search'));
    }

    public function create()
    {
        return view('etudiants.create');
    }

    public function store(StoreEtudiantRequest $request)
    {
        $data = $request->validated();
        
        // Générer le matricule automatiquement
        $year = date('Y');
        $last = Etudiant::where('matricule', 'like', "{$year}%")->count();
        $number = str_pad($last + 1, 4, '0', STR_PAD_LEFT);
        $data['matricule'] = "{$year}{$number}";

               if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('etudiants/photos', 'public');
        }

        Etudiant::create($data);

        return redirect()->route('etudiants.index')
            ->with('success', 'Étudiant ajouté avec succès. Matricule: ' . $data['matricule']);
    }

    public function show(Etudiant $etudiant)
    {
        $etudiant->load('inscriptions');
        return view('etudiants.show', compact('etudiant'));
    }

    public function edit(Etudiant $etudiant)
    {
        return view('etudiants.edit', compact('etudiant'));
    }

    public function update(UpdateEtudiantRequest $request, Etudiant $etudiant)
    {
        $data = $request->validated();
 
        if ($request->hasFile('photo')) {
            // Supprimer l'ancienne photo si elle existe
            if ($etudiant->photo) {
                Storage::disk('public')->delete($etudiant->photo);
            }
            $data['photo'] = $request->file('photo')->store('etudiants/photos', 'public');
        }
 
        $etudiant->update($data);
 
        return redirect()->route('etudiants.index')
            ->with('success', 'Étudiant mis à jour avec succès.');
    }

    public function destroy(Etudiant $etudiant)
    {
        
        if ($etudiant->photo) {
            Storage::disk('public')->delete($etudiant->photo);
        }
 
        $etudiant->delete();

        return redirect()->route('etudiants.index')
            ->with('success', 'Étudiant supprimé avec succès.');
    }

    public function toggleStatus(Etudiant $etudiant)
    {
        $etudiant->update(['est_actif' => !$etudiant->est_actif]);

        $status = $etudiant->est_actif ? 'activé' : 'désactivé';

        return redirect()->route('etudiants.index')
            ->with('success', "Étudiant {$status} avec succès.");
    }
}