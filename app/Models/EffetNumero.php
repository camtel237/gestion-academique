<?php
// app/Models/EffetNumero.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EffetNumero extends Model
{
    // Spécifiez le nom exact de la table (au pluriel)
    protected $table = 'effets_numeros';
    
    protected $fillable = ['type', 'annee', 'numero', 'inscription_id'];

    /**
     * Réserve et retourne le prochain numéro séquentiel pour un type de document donné,
     * pour l'année en cours. Garantit qu'aucun numéro n'est jamais réutilisé.
     */
    public static function next(string $type, ?int $inscriptionId = null): int
    {
        $annee = (int) date('Y');

        $dernier = static::where('type', $type)
            ->where('annee', $annee)
            ->max('numero');

        $numero = ($dernier ?? 0) + 1;

        static::create([
            'type' => $type,
            'annee' => $annee,
            'numero' => $numero,
            'inscription_id' => $inscriptionId,
        ]);

        return $numero;
    }

    /**
     * Récupère le prochain numéro sans l'enregistrer (pour l'aperçu)
     */
    public static function previewNextNumber(string $type, ?int $inscriptionId = null): int
    {
        $annee = (int) date('Y');

        $dernier = static::where('type', $type)
            ->where('annee', $annee)
            ->max('numero');

        return ($dernier ?? 0) + 1;
    }

    /**
     * Vérifie si un numéro existe déjà pour ce type et cette année
     */
    public static function exists(string $type, int $numero, int $annee = null): bool
    {
        $annee = $annee ?? (int) date('Y');
        
        return static::where('type', $type)
            ->where('annee', $annee)
            ->where('numero', $numero)
            ->exists();
    }
}