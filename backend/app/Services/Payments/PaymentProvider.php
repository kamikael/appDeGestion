<?php

// app/Services/Payments/PaymentProvider.php
namespace App\Services\Payments;

use App\Models\Paiement;

interface PaymentProvider {
    /** Lance un paiement et retourne des infos (checkout url, deeplink, etc.) */
    public function init(Paiement $paiement): array;

    /** Vérifie la signature d’un webhook (si applicable) */
    public function verifySignature(array $headers, string $rawBody): bool;
}
