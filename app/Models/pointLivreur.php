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
        'delivery_service_id', 
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

        // Relation avec le modèle DeliveryService
        public function deliveryService()
        {
            return $this->belongsTo(DeliveryService::class, 'delivery_service_id', 'id');
        }


         // Désactiver les colonnes created_at et updated_at
    public $timestamps = false;
}
