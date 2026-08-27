<?php
// app/Models/Etablissement/UniteEnseignement.php

namespace App\Models\Etablissement;

use Illuminate\Database\Eloquent\Model;

class UniteEnseignement extends Model
{
    protected $table = 'unites_enseignement';

    protected $fillable = [
        'code',
        'libelle',
        'total_credit',
        'position_releve',
        'semestre_id',
    ];

   

   

    public function matieres()
    {
        return $this->hasMany(Matiere::class);
    }
    //à faire
    public function semestre()
    {
        return $this->belongsTo(Semestre::class);
    }
     // ✅ Accesseurs pratiques : $ue->niveau et $ue->anneeAcademique continuent
    // de fonctionner partout dans les vues sans rien changer ailleurs,
    // à condition d'avoir eager-loadé 'semestre.niveau' / 'semestre.anneeAcademique'.
    public function getNiveauAttribute()
    {
        return $this->semestre?->niveau;
    }

    public function getAnneeAcademiqueAttribute()
    {
        return $this->semestre?->anneeAcademique;
    }
}