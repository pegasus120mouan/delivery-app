<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Utilisateur extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'nom',
        'prenoms',
        'contact',
        'whatsapp',
        'lieu_habitation',
        'role',
        'email',
        'login',
        'password',
        'email_verification_token',
        'email_verified',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'email_verification_token',
    ];

    protected $casts = [
        'email_verified' => 'boolean',
    ];  

    public function deliveryService(): BelongsTo
    {
        return $this->belongsTo(DeliveryService::class, 'delivery_service_id');
    }

    /**
     * Relation pour les CLIENTS : appartient à PLUSIEURS services
     * via la table pivot delivery_service_utilisateur
     */
    public function deliveryServices(): BelongsToMany
    {
        return $this->belongsToMany(
            DeliveryService::class,           // Modèle cible
            'delivery_service_utilisateur',   // Nom de la table pivot
            'utilisateur_id',                 // Clé étrangère pour ce modèle
            'delivery_service_id'             // Clé étrangère pour l'autre modèle
        )->withTimestamps();                  // Inclut les timestamps de la pivot
    }

    /**
     * Scope pour filtrer les clients
     */
    public function scopeClients($query)
    {
        return $query->where('role', 'client');
    }

    /**
     * Scope pour filtrer les livreurs
     */
    public function scopeLivreurs($query)
    {
        return $query->where('role', 'livreur');
    }
    
}
