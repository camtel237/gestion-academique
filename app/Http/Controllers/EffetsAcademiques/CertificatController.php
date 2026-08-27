<?php
// app/Http/Controllers/EffetsAcademiques/CertificatController.php

namespace App\Http\Controllers\EffetsAcademiques;

use App\Http\Controllers\Controller;
use App\Models\EffetNumero;
use App\Models\Inscription;
use Barryvdh\DomPDF\Facade\Pdf;

class CertificatController extends Controller
{
    /**
     * Liste des inscriptions validées pour lesquelles un certificat peut être généré.
     */
    public function index()
    {
        $inscriptions = Inscription::where('statut', 'validee')
            ->with(['etudiant', 'anneeAcademique', 'departement', 'specialite', 'niveau'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('effets.certificats.index', compact('inscriptions'));
    }

    /**
     * Aperçu à l'écran.
     */
    public function show($id)
    {
        $inscription = Inscription::with([
            'etudiant', 'anneeAcademique', 'departement', 'specialite', 'niveau',
        ])->findOrFail($id);

        if ($inscription->statut !== 'validee') {
            return redirect()->route('certificats.index')
                ->with('error', "Cette inscription n'est pas validée.");
        }

        return view('effets.certificats.show', compact('inscription'));
    }

    /**
     * Flux PDF affiché inline dans l'iframe d'aperçu (numéro non réservé définitivement).
     */
    public function preview($id)
    {
        $inscription = Inscription::with([
            'etudiant', 'anneeAcademique', 'departement', 'specialite', 'niveau',
        ])->findOrFail($id);

        // Utiliser la méthode statique du modèle
        $numero = EffetNumero::previewNextNumber('certificat');

        $pdf = Pdf::loadView('effets.certificats.pdf', compact('inscription', 'numero'));
        $pdf->setPaper('a4', 'portrait');

        return $pdf->stream('apercu_certificat.pdf');
    }

    /**
     * Télécharger le certificat en PDF (réserve définitivement le numéro).
     */
    public function download($id)
    {
        $inscription = Inscription::with([
            'etudiant', 'anneeAcademique', 'departement', 'specialite', 'niveau',
        ])->findOrFail($id);

        if ($inscription->statut !== 'validee') {
            return redirect()->route('certificats.index')
                ->with('error', "Cette inscription n'est pas validée.");
        }

        // Réserver le numéro définitivement
        $numero = EffetNumero::next('certificat', $inscription->id);

        $pdf = Pdf::loadView('effets.certificats.pdf', compact('inscription', 'numero'));
        $pdf->setPaper('a4', 'portrait');

        return $pdf->download('certificat_scolarite_' . $inscription->etudiant->matricule . '.pdf');
    }

    /**
     * Numéro "provisoire" affiché à l'aperçu (n'est pas encore réservé en base).
     * @deprecated Utiliser EffetNumero::previewNextNumber() à la place
     */
    private function previewNumero(): int
    {
        return EffetNumero::previewNextNumber('certificat');
    }
}