<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * La clé primaire personnalisée
     */
    protected $primaryKey = 'user_id';

    /**
     * Attributs remplissables en masse
     */
    protected $fillable = [
        'nom',
        'email',
        'mot_de_passe_hash',
        'role',
        'telephone',
        'statut',
    ];

    /**
     * Attributs cachés lors de la sérialisation
     */
    protected $hidden = [
        'mot_de_passe_hash',
        'remember_token',
    ];

    /**
     * Casts automatiques
     */
    protected function casts(): array
    {
        return [
            'mot_de_passe_hash' => 'hashed',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }
}
