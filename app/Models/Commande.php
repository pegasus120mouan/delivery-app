<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    protected $fillable = [
        'communes',
        'cout_global',
        'cout_livraison',
        'cout_reel',
        'date_reception',
        'statut',
        'boutique_id',
        'livreur_id',
        'utilisateur_id',
    ];

    // Désactiver created_at et updated_at
    public $timestamps = false;

    public function boutique()
    {
        return $this->belongsTo(Boutique::class);
    }

    public function livreur()
    {
        return $this->belongsTo(Utilisateur::class, 'livreur_id');
    }
    
    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'utilisateur_id');
    }
    
}


