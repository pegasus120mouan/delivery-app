<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PointLivreur extends Model
{
    //
    protected $table = 'points_livreurs';
    protected $fillable = 
    [
        'utilisateur_id', 
        'recettes', 
        'depenses', 
        'gain_jour', 
        'date_jour'
    ];
     // Relation avec le modèle Utilisateur
        public function utilisateur()
        {
            return $this->belongsTo(Utilisateur::class, 'utilisateur_id', 'id');
        }


         // Désactiver les colonnes created_at et updated_at
    public $timestamps = false;
}
