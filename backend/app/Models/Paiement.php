<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    /** @use HasFactory<\Database\Factories\PaiementFactory> */
    use HasFactory;

     use SoftDeletes;

    protected $primaryKey = 'paiement_id';
    protected $fillable = [
        'user_id','montant','methode','provider','reference','currency','statut','meta','refunded_at','montant_refund'
    ];
    protected $casts = ['meta' => 'array', 'refunded_at' => 'datetime'];

    public function user()
{
    return $this->belongsTo(User::class, 'user_id', 'user_id');
}

public function ticket()
{
    return $this->hasOne(Ticket::class, 'paiement_id', 'paiement_id');
}

}
