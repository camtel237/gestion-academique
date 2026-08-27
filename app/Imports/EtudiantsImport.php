<?php
// app/Imports/EtudiantsImport.php

namespace App\Imports;

use App\Models\Etudiant;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;


class EtudiantsImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use SkipsFailures;

    public function model(array $row)
    {
        return new Etudiant([
            'matricule' => $row['matricule'],
            'nom' => $row['nom'],
            'prenom' => $row['prenom'],
            'sexe' => $row['sexe'] ?? null,
            'date_naissance' => $row['date_de_naissance'] ?? null,
            'email' => $row['email'] ?? null,
            'telephone' => $row['telephone'] ?? null,
            'est_actif' => true,
        ]);
    }

    public function rules(): array
    {
        return [
            'matricule' => ['required', 'unique:etudiants,matricule'],
            'nom' => ['required'],
            'prenom' => ['required'],
        ];
    }

    public function customValidationMessages()
    {
        return [
            'matricule.required' => 'Le matricule est obligatoire (ligne concernée ignorée).',
            'matricule.unique' => 'Ce matricule existe déjà (ligne concernée ignorée).',
            'nom.required' => 'Le nom est obligatoire (ligne concernée ignorée).',
            'prenom.required' => 'Le prénom est obligatoire (ligne concernée ignorée).',
        ];
    }
}