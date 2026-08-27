<?php
// app/Exports/EtudiantsExport.php

namespace App\Exports;

use App\Models\Etudiant;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EtudiantsExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    public function collection()
    {
        return Etudiant::orderBy('nom')->get();
    }

    public function headings(): array
    {
        return ['Matricule', 'Nom', 'Prénom', 'Sexe', 'Date de naissance', 'Email', 'Téléphone', 'Statut'];
    }

    public function map($etudiant): array
    {
        return [
            $etudiant->matricule,
            $etudiant->nom,
            $etudiant->prenom,
            $etudiant->sexe,
            optional($etudiant->date_naissance)->format('d/m/Y'),
            $etudiant->email,
            $etudiant->telephone,
            $etudiant->est_actif ? 'Actif' : 'Inactif',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [1 => ['font' => ['bold' => true]]];
    }
}