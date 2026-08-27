<?php
// app/Models/Etablissement/Niveau.php

namespace App\Models\Etablissement;

use Illuminate\Database\Eloquent\Model;

class Niveau extends Model
{
    protected $table = 'niveaux';

    protected $fillable = [
        'libelle',
        'departement_id',
        'specialite_id',
        'annee_academique_id',
        'est_actif',
    ];

    protected $casts = [
        'est_actif' => 'boolean',
    ];

    public function departement()
    {
        return $this->belongsTo(Departement::class);
    }

    public function specialite()
    {
        return $this->belongsTo(Specialite::class);
    }

    public function anneeAcademique()
    {
        return $this->belongsTo(AnneeAcademique::class);
    }

    /**
     * Les UE ne sont plus rattachées directement au niveau (colonne niveau_id supprimée),
     * elles le sont via le semestre. On passe donc par hasManyThrough en utilisant
     * 'semestres' comme table intermédiaire.
     */
    public function unitesEnseignement()
    {
        return $this->hasManyThrough(
            UniteEnseignement::class,
            Semestre::class,
            'niveau_id',   // clé étrangère sur semestres
            'semestre_id', // clé étrangère sur unites_enseignement
            'id',          // clé locale sur niveaux
            'id'           // clé locale sur semestres
        );
    }

    public function matieres()
    {
        return $this->hasMany(Matiere::class);
    }

    public function semestres()
    {
        return $this->hasMany(Semestre::class);
    }

    public function scopeActif($query)
    {
        return $query->where('est_actif', true);
    }
}