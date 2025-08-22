<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    /** @use HasFactory<\Database\Factories\TicketFactory> */
    use HasFactory;

    protected $primaryKey = 'ticket_id';
    protected $fillable = [
        'participant_id','evenement_id','type_ticket','prix','paiement_id','ticket_code','statut'
    ];

    public function paiement()
{
    return $this->belongsTo(Paiement::class, 'paiement_id', 'paiement_id');
}

public function evenement()
{
    return $this->belongsTo(Evenement::class, 'evenement_id', 'evenement_id');
}

public function participant()
{
    return $this->belongsTo(Participant::class, 'participant_id', 'participant_id');
}

}
