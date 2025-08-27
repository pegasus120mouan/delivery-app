<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Boutique extends Model
{
    protected $fillable = [
        'nom_boutique',
        'adresse',
        'commune',
        'telephone',
        'email',
        'statut',
        'logo',
        'responsable_id',
    ];

     public function responsable()
        {
            return $this->belongsTo(Utilisateur::class, 'responsable_id')
                        ->where('role', 'client'); // optionnel : on filtre sur les clients
        }
    public function clients()
        {
            return $this->belongsToMany(Utilisateur::class, 'boutique_utilisateur', 'boutique_id', 'utilisateur_id');
        }
}
