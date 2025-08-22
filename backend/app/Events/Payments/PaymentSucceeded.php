<?php

// app/Events/Payments/PaymentSucceeded.php
namespace App\Events\Payments;

use App\Models\{Paiement, Ticket};
use Illuminate\Foundation\Events\Dispatchable;

class PaymentSucceeded {
    use Dispatchable;
    public function __construct(public Paiement $paiement, public Ticket $ticket) {}
}
