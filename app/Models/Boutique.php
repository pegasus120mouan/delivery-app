<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Boutique extends Model
{
    protected $fillable = [
        'nom_boutique',
        'code',
        'adresse',
        'commune',
        'telephone',
        'email',
        'statut',
        'logo',
        'responsable_id',
        'pin_code',
        'email_verified_at',
    ];

    public function responsable()
    {
        return $this->belongsTo(Utilisateur::class, 'responsable_id')
                   ->where('role', 'client');
    }

    public function clients()
    {
        return $this->belongsToMany(Utilisateur::class, 'boutique_utilisateur', 'boutique_id', 'utilisateur_id');
    }

    /**
     * Les services de livraison associés à cette boutique
     */
    public function deliveryServices()
    {
        return $this->belongsToMany(DeliveryService::class, 'boutique_delivery_service')
                   ->withTimestamps();
    }
}
