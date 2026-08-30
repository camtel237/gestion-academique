<?php
// app/Http/Controllers/Administration/SettingController.php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Les champs gérés par cette page. Ajoutez-en simplement une ligne ici
     * pour en exposer un nouveau dans le formulaire.
     */
    private array $champs = [
        'nom_etablissement' => "Nom de l'établissement",
        'code_etablissement' => 'Code établissement (ex: UDS, UY1...)',
        'ville' => 'Ville',
        'adresse' => 'Adresse',
        'telephone' => 'Téléphone',
        'email' => 'Email de contact',
    ];

    public function index()
    {
        $valeurs = collect($this->champs)->keys()
            ->mapWithKeys(fn ($key) => [$key => Setting::get($key, '')]);

        return view('administration.settings', [
            'champs' => $this->champs,
            'valeurs' => $valeurs,
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'email' => ['nullable', 'email'],
        ]);

        foreach (array_keys($this->champs) as $key) {
            Setting::set($key, $request->input($key));
        }

        return back()->with('success', 'Paramètres mis à jour avec succès.');
    }
}
//https://each-formation.com/