<?php

namespace App\Notifications;

use App\Models\Stand;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class StandApprovedNotification extends Notification
{
    use Queueable;
    public $stand;

    public function __construct(Stand $stand)
    {
        $this->stand = $stand;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Votre stand a été approuvé 🎉')
            ->line("Félicitations ! Votre stand '{$this->stand->nom}' a été validé par le créateur de l’événement.")
            ->line("Il est désormais visible dans l’événement '{$this->stand->evenement->nom}'.")
            ->action('Voir mon stand', url("/stands/{$this->stand->id}"));
    }

    public function toArray($notifiable)
    {
        return [
            'stand_id' => $this->stand->id,
            'evenement' => $this->stand->evenement->nom,
            'message' => 'Votre stand a été approuvé et est désormais en ligne.'
        ];
    }
}
