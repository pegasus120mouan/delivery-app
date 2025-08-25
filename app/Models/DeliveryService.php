<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class DeliveryService extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nom',
        'email',
        'telephone',
        'adresse',
        'email_verification_token',
        'email_verified',
        'logo',
    ];

    protected $casts = [
        'email_verified' => 'boolean',
    ];

    /**
     * Relation : les gérants liés au service via la table pivot
     */
    public function gerants(): BelongsToMany
    {
        return $this->belongsToMany(
            Utilisateur::class,
            'delivery_service_utilisateur', // table pivot
            'delivery_service_id',          // clé étrangère de DeliveryService
            'utilisateur_id'                // clé étrangère de Utilisateur
        )->where('role', 'gerant');
    }

    /**
     * Relation : les livreurs liés au service via la table pivot
     */
    public function livreurs(): BelongsToMany
    {
        return $this->belongsToMany(
            Utilisateur::class,
            'delivery_service_utilisateur',
            'delivery_service_id',
            'utilisateur_id'
        )->where('role', 'livreur');
    }

    /**
     * Relation : les clients liés au service via la table pivot
     */
    public function clients(): BelongsToMany
    {
        return $this->belongsToMany(
            Utilisateur::class,
            'delivery_service_utilisateur',
            'delivery_service_id',
            'utilisateur_id'
        )->where('role', 'client');
    }

    public function utilisateurs()
    {
        return $this->belongsToMany(Utilisateur::class, 'delivery_service_utilisateur');
    }
    
}
