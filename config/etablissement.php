<?php
// config/etablissement.php
// Informations utilisées sur les documents officiels (certificat, relevé, carte).
// Modifiables directement dans le .env, sans toucher au code.
 
return [
    'nom' => env('ETABLISSEMENT_NOM', 'Institut des Beaux Arts (IBA)'),
    'universite' => env('ETABLISSEMENT_UNIVERSITE', 'Université de Douala'),
    'ville' => env('ETABLISSEMENT_VILLE', 'Nkongsamba'),
    'code' => env('ETABLISSEMENT_CODE', 'IBA'),
 
    'directeur' => [
        'titre' => env('DIRECTEUR_TITRE', 'Pr'),
        'nom' => env('DIRECTEUR_NOM', 'NOM DU DIRECTEUR'),
        'genre' => env('DIRECTEUR_GENRE', 'M'), // 'M' ou 'F' -> "soussigné" / "soussignée"
    ],
 
    'verification_email' => env('ETABLISSEMENT_VERIFICATION_EMAIL', 'infos.iba@univ-douala.com'),
];
 