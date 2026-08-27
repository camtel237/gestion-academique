<?php
// app/Http/Controllers/EffetsAcademiques/EffectifController.php
//
// Interface unique "Générer effectif" : Spécialité -> Niveau -> liste des
// étudiants inscrits (validés) de ce niveau, pour l'année académique de ce
// niveau (donc jamais de mélange entre années). Chaque ligne propose ensuite
// les actions Carte / Certificat / Relevé en réutilisant la logique de
// génération déjà en place (CarteEtudiantController, CertificatController,
// ReleveController) : cette page ne fait que sélectionner l'inscription.

namespace App\Http\Controllers\EffetsAcademiques;

use App\Http\Controllers\Controller;
use App\Models\Etablissement\Specialite;
use App\Models\Etablissement\Niveau;
use App\Models\Inscription;
use Illuminate\Http\Request;

class EffectifController extends Controller
{
    public function index()
    {
        $specialites = Specialite::where('est_actif', true)
            ->orderBy('libelle')
            ->get();

        return view('effets.effectifs.index', compact('specialites'));
    }

    /**
     * AJAX : niveaux d'une spécialité (toutes années confondues pour le select,
     * le libellé précise l'année pour éviter toute confusion).
     */
    public function getNiveauxBySpecialite(Request $request)
    {
        $request->validate(['specialite_id' => ['required', 'exists:specialites,id']]);

        $niveaux = Niveau::where('specialite_id', $request->specialite_id)
            ->where('est_actif', true)
            ->with('anneeAcademique')
            ->orderByDesc('annee_academique_id')
            ->orderBy('libelle')
            ->get()
            ->map(fn ($n) => [
                'id' => $n->id,
                'libelle' => $n->libelle . ' - ' . ($n->anneeAcademique->libelle ?? ''),
            ]);

        return response()->json($niveaux);
    }

    /**
     * AJAX : étudiants (inscriptions validées) du niveau choisi, pour l'année
     * académique propre à ce niveau — jamais mélangé avec une autre année.
     */
    public function getEtudiantsByNiveau(Request $request)
    {
        $request->validate(['niveau_id' => ['required', 'exists:niveaux,id']]);

        $niveau = Niveau::with('anneeAcademique', 'specialite')->findOrFail($request->niveau_id);

        $inscriptions = Inscription::where('niveau_id', $niveau->id)
            ->where('annee_academique_id', $niveau->annee_academique_id)
            ->where('statut', 'validee')
            ->with('etudiant')
            ->get()
            ->map(fn ($i) => [
                'inscription_id' => $i->id,
                'matricule' => $i->etudiant->matricule,
                'nom_complet' => $i->etudiant->nom_complet,
            ]);

        return response()->json([
            'niveau' => $niveau->libelle,
            'specialite' => $niveau->specialite->libelle ?? '',
            'annee' => $niveau->anneeAcademique->libelle ?? '',
            'etudiants' => $inscriptions,
        ]);
    }
}