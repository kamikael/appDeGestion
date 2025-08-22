<?php

namespace App\Notifications;

use App\Models\Stand;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class StandPendingCreatorValidation extends Notification
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
            ->subject('Validation requise : Stand en attente')
            ->line("Un nouveau stand ('{$this->stand->nom}') a été pré-approuvé par l’administrateur global.")
            ->line("Il attend maintenant votre validation en tant que créateur de l’événement '{$this->stand->evenement->nom}'.")
            ->action('Valider le stand', url("/creator/stands/{$this->stand->id}"))
            ->line('Merci de confirmer ou refuser.');
    }

    public function toArray($notifiable)
    {
        return [
            'stand_id' => $this->stand->id,
            'evenement' => $this->stand->evenement->nom,
            'message' => 'Stand pré-approuvé par l’admin, en attente de validation du créateur.'
        ];
    }
}
