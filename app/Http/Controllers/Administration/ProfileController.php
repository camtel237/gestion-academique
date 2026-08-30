<?php
// app/Http/Controllers/Administration/ProfileController.php

namespace App\Http\Controllers\Administration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Met à jour les informations personnelles de l'utilisateur connecté
     * (nom, email, et optionnellement le mot de passe).
     *
     * Utilise un bag d'erreurs nommé "profile" pour ne pas se mélanger
     * avec les erreurs du formulaire "Informations de l'établissement"
     * présent sur la même page.
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $data = $request->validateWithBag('profile', [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            // Le mot de passe actuel n'est requis que si on tente de le changer.
            'current_password' => ['nullable', 'required_with:password', 'current_password'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.current_password' => 'Le mot de passe actuel saisi est incorrect.',
        ]);

        $user->name = $data['name'];
        $user->email = $data['email'];

        // Le cast 'hashed' du modèle User se charge du hachage automatiquement.
        if (!empty($data['password'])) {
            $user->password = $data['password'];
        }

        $user->save();

        return back()->with('success_profile', 'Profil mis à jour avec succès.');
    }
}