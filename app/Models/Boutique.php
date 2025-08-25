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
        'responsable',
        'statut',
    ];
}
