<?php
// app/Http/Controllers/EffetsAcademiques/CarteEtudiantController.php

namespace App\Http\Controllers\EffetsAcademiques;

use App\Http\Controllers\Controller;
use App\Models\Inscription;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class CarteEtudiantController extends Controller
{
    /**
     * Afficher la liste des inscriptions validées pour générer des cartes
     */
    public function index()
    {
        $inscriptions = Inscription::where('statut', 'validee')
            ->with(['etudiant', 'anneeAcademique', 'departement', 'specialite', 'niveau'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('effets.cartes.index', compact('inscriptions'));
    }

    /**
     * Afficher la carte d'un étudiant
     */
    public function show($id)
    {
        $inscription = Inscription::with([
            'etudiant',
            'anneeAcademique',
            'departement',
            'specialite',
            'niveau'
        ])->findOrFail($id);

        // Vérifier que l'inscription est validée
        if ($inscription->statut !== 'validee') {
            return redirect()->route('cartes.index')
                ->with('error', 'Cette inscription n\'est pas validée.');
        }

        return view('effets.cartes.carte-etudiant', compact('inscription'));
    }

    /**
     * Télécharger la carte en PDF
     */
 
public function download($id)
{
    $inscription = Inscription::with([
        'etudiant', 'anneeAcademique', 'departement', 'specialite', 'niveau'
    ])->findOrFail($id);

    if ($inscription->statut !== 'validee') {
        return redirect()->route('cartes.index')
            ->with('error', 'Cette inscription n\'est pas validée.');
    }

    $pdf = Pdf::loadView('effets.cartes.carte-etudiant-pdf', compact('inscription'));

    // Format personnalisé en points (pt), pas A4 : largeur x hauteur
    // 383 x 216 pt ≈ 135 x 76 mm, calé sur la taille réelle de la carte (450x230px + marge)
    $pdf->setPaper([0, 0, 383, 216]);

    return $pdf->download('carte_etudiant_' . $inscription->etudiant->matricule . '.pdf');
}

    /**
     * Générer plusieurs cartes à la fois (optionnel)
     */
    public function generateMultiple(Request $request)
    {
        $ids = $request->ids ?? [];
        
        if (empty($ids)) {
            return redirect()->route('cartes.index')
                ->with('error', 'Veuillez sélectionner au moins un étudiant.');
        }

        $inscriptions = Inscription::whereIn('id', $ids)
            ->where('statut', 'validee')
            ->with(['etudiant', 'anneeAcademique', 'departement', 'specialite', 'niveau'])
            ->get();

        $pdf = Pdf::loadView('effets.cartes.multiple', compact('inscriptions'));
        $pdf->setPaper('a4', 'portrait');

        return $pdf->download('cartes_etudiants.pdf');
    }
}