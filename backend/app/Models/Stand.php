<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stand extends Model
{
    /** @use HasFactory<\Database\Factories\StandFactory> */
    use HasFactory;

    public function entrepreneur()
{
    return $this->belongsTo(User::class, 'entrepreneur_id', 'user_id');
}

public function evenement()
{
    return $this->belongsTo(Evenement::class, 'evenement_id', 'evenement_id');
}

public function isPendingAdmin()
{
    return $this->statut === 'en_attente';
}

public function isPendingCreator()
{
    return $this->statut === 'pre_approve';
}


}
