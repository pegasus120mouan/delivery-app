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
}
