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
    public function gerants()
    {
        return $this->belongsToMany(
            Utilisateur::class,
            'delivery_service_utilisateur',
            'delivery_service_id',
            'utilisateur_id'
        );
    }

    /**
     * Relation : tous les utilisateurs liés au service via la table pivot
     */
    public function utilisateurs(): BelongsToMany
    {
        return $this->belongsToMany(
            Utilisateur::class,
            'delivery_service_utilisateur',
            'delivery_service_id',
            'utilisateur_id'
        );
    }

    /**
     * Relation : les livreurs liés au service via la table pivot
     */
    public function livreurs()
    {
        return $this->belongsToMany(
            Utilisateur::class,
            'delivery_service_utilisateur',
            'delivery_service_id',
            'utilisateur_id'
        );
    }

    /**
     * Relation : les clients liés au service via la table pivot
     */
    public function clients()
    {
        return $this->belongsToMany(
            Utilisateur::class,
            'delivery_service_utilisateur',
            'delivery_service_id',
            'utilisateur_id'
        );
    }

    /**
     * Relation : les boutiques liées au service via la table pivot
     */
    public function boutiques()
    {
        return $this->belongsToMany(Boutique::class, 'boutique_delivery_service')
                   ->withTimestamps();
    }
}
