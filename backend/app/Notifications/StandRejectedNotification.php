<?php

namespace App\Notifications;

use App\Models\Stand;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class StandRejectedNotification extends Notification
{
    use Queueable;
    public $stand;
    public $reason;

    public function __construct(Stand $stand, $reason = null)
    {
        $this->stand = $stand;
        $this->reason = $reason;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        $mail = (new MailMessage)
            ->subject('Votre stand a été refusé ❌')
            ->line("Votre stand '{$this->stand->nom}' lié à l’événement '{$this->stand->evenement->nom}' a été refusé.");

        if ($this->reason) {
            $mail->line("Motif : {$this->reason}");
        }

        return $mail;
    }

    public function toArray($notifiable)
    {
        return [
            'stand_id' => $this->stand->id,
            'evenement' => $this->stand->evenement->nom,
            'message' => 'Votre stand a été refusé.',
            'reason' => $this->reason
        ];
    }
}
