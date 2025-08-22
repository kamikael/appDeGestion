<?php

// app/Listeners/Payments/SendTicketNotification.php
namespace App\Listeners\Payments;

use App\Events\Payments\PaymentSucceeded;

class SendTicketNotification {
    public function handle(PaymentSucceeded $event): void
    {
        $event->paiement->user->notify(new \App\Notifications\TicketIssuedNotification($event->ticket));
    }
}
