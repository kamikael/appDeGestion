<?php

// app/Services/Payments/MobileMoneyService.php
namespace App\Services\Payments;

use App\Models\Paiement;

class MobileMoneyService implements PaymentProvider
{
    public function __construct(private ?string $secret = null) {}

    public function init(Paiement $paiement): array
    {
        // Ici tu appelles MTN/Moov… et obtiens une URL de paiement ou un deeplink
        // Retour mock pour l’exemple :
        return [
            'reference'   => $paiement->reference,
            'checkoutUrl' => route('payments.mock.checkout', ['ref' => $paiement->reference]),
        ];
    }

    public function verifySignature(array $headers, string $rawBody): bool
    {
        // Vérif signature opérateur (placeholder)
        return true;
    }
}
