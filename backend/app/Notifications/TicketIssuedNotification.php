<?php

// app/Notifications/TicketIssuedNotification.php
namespace App\Notifications;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class TicketIssuedNotification extends Notification
{
    use Queueable;
    public function __construct(public Ticket $ticket) {}

    public function via($notifiable) { return ['mail','database']; }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Votre ticket est confirmé 🎟️')
            ->line("Événement : {$this->ticket->evenement->nom}")
            ->line("Type : {$this->ticket->type_ticket} | Prix : {$this->ticket->prix}")
            ->line("Code : {$this->ticket->ticket_code}");
    }

    public function toArray($notifiable)
    {
        return [
            'ticket_id' => $this->ticket->ticket_id,
            'evenement_id' => $this->ticket->evenement_id,
            'ticket_code' => $this->ticket->ticket_code,
        ];
    }
}
