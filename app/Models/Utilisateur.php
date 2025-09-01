<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
        'code',
        'email',
        'login',
        'password',
        'email_verification_token',
        'email_verified',
        'avatar',
        'delivery_service_id',
    ];

    protected $hidden = [
        'password',
        'email_verification_token',
    ];

    protected $casts = [
        'email_verified' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (!$user->code) {
                $user->code = self::generateUserCode($user->role);
            }
        });
    }

    public static function generateUserCode($role)
    {
        $year = substr(date('Y'), -2); // Get last 2 digits of year
        
        // Define prefix based on role
        $prefix = match($role) {
            'client' => 'CL',
            'livreur' => 'LV',
            'gerant' => 'GE',
            default => 'US', // Default prefix for other roles
        };

        // Get the last sequence number for this role and year
        $lastUser = self::where('role', $role)
                       ->where('code', 'like', "{$prefix}{$year}-%")
                       ->orderBy('code', 'desc')
                       ->first();

        if ($lastUser) {
            $lastSequence = (int) substr($lastUser->code, -3);
            $sequence = str_pad($lastSequence + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $sequence = '001';
        }

        return "{$prefix}{$year}-{$sequence}";
    }

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

    public function boutiques()
    {
        return $this->belongsToMany(Boutique::class, 'boutique_utilisateur', 'utilisateur_id', 'boutique_id');
    }


    
}
