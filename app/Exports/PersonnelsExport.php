<?php


namespace App\Exports;

use App\Models\Personnel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PersonnelsExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    public function collection()
    {
        return Personnel::orderBy('nom')->get();
    }

    public function headings(): array
    {
        return [ 'Matricule', 'Nom', 'Prénom', 'Sexe', 'Date de naissance','fonction','Email', 'Téléphone', 'Statut'];
    }

    public function map($personnel): array
    {
        return [
           
            $personnel->matricule,
            $personnel->nom,
            $personnel->prenom,
            $personnel->sexe,
            optional($personnel->date_naissance)->format('d/m/Y'),
            $personnel->fonction,
            $personnel->email,
            $personnel->telephone,
            $personnel->est_actif ? 'Actif' : 'Inactif',

        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [1 => ['font' => ['bold' => true]]];
    }
}