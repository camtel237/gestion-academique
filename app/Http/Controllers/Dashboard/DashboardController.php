<?php
// app/Http/Controllers/Dashboard/DashboardController.php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Etablissement\AnneeAcademique;
use App\Models\Etablissement\Departement;
use App\Models\Etablissement\Personnel;
use App\Models\Etudiant;
use App\Models\Inscription;
use App\Models\Note;

class DashboardController extends Controller
{
    public function index()
    {
        $anneeActive = AnneeAcademique::where('est_active', true)->first();

            $stats = [
            'etudiants'     => $anneeActive
                ? Inscription::where('annee_academique_id', $anneeActive->id)->where('statut', 'validee')->count()
                : 0,
            'personnels'    => Personnel::where('est_actif', true)->count(),
            'departements'  => Departement::where('est_actif', true)->count(),
            'taux_reussite' => $this->tauxReussite($anneeActive),
        ];

        $activites = $this->dernieresActivites();
        $inscriptionsParMois = $this->inscriptionsParMois($anneeActive);

        return view('dashboard.index', compact('stats', 'activites', 'inscriptionsParMois', 'anneeActive'));
    }

    private function tauxReussite(?AnneeAcademique $annee): int
    {
        if (!$annee) return 0;

        $total = Note::whereHas('inscription', fn($q) => $q->where('annee_academique_id', $annee->id))->count();
        if ($total === 0) return 0;

        $reussies = Note::whereHas('inscription', fn($q) => $q->where('annee_academique_id', $annee->id))
            ->where('moyenne', '>=', 10)
            ->count();

        return (int) round($reussies / $total * 100);
    }

    private function dernieresActivites()
    {
        $inscriptions = Inscription::with('etudiant')
            ->latest()->take(5)->get()
            ->map(fn($i) => (object) [
                'icon'  => 'fa-user-plus',
                'color' => 'green',
                'texte' => 'Nouvelle inscription : ' . ($i->etudiant->nom_complet ?? $i->etudiant->prenom . ' ' . $i->etudiant->nom ?? '-'),
                'date'  => $i->created_at,
            ]);

        $notes = Note::with('etudiant')
            ->latest()->take(5)->get()
            ->map(fn($n) => (object) [
                'icon'  => 'fa-file-circle-check',
                'color' => 'blue',
                'texte' => 'Note saisie pour ' . ($n->etudiant->nom_complet ?? $n->etudiant->prenom . ' ' . $n->etudiant->nom ?? '-'),
                'date'  => $n->created_at,
            ]);

        return $inscriptions->concat($notes)
            ->sortByDesc('date')
            ->take(6)
            ->values();
    }

    private function inscriptionsParMois(?AnneeAcademique $annee): array
    {
        if (!$annee) {
            return array_fill(0, 12, 0);
        }

        $parMois = Inscription::where('annee_academique_id', $annee->id)
            ->selectRaw('MONTH(created_at) as mois, COUNT(*) as total')
            ->groupBy('mois')
            ->pluck('total', 'mois');

        return collect(range(1, 12))
            ->map(fn($m) => $parMois[$m] ?? 0)
            ->values()
            ->toArray();
    }
}