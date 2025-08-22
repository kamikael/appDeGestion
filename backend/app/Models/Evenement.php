<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evenement extends Model
{
    /** @use HasFactory<\Database\Factories\EvenementFactory> */
    use HasFactory;

    public function createur()
{
    return $this->belongsTo(User::class, 'createur_id', 'user_id');
}

   
}
