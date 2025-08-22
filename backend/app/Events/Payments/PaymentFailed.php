<?php

// app/Events/Payments/PaymentFailed.php
namespace App\Events\Payments;

use App\Models\Paiement;
use Illuminate\Foundation\Events\Dispatchable;

class PaymentFailed {
    use Dispatchable;
    public function __construct(public Paiement $paiement) {}
}
