<?php

// app/Http/Controllers/Tickets/TicketPurchaseController.php
namespace App\Http\Controllers\Tickets;

use App\Http\Controllers\Controller;
use App\Models\{Paiement, Ticket, Evenement, Participant};
use App\Services\Payments\MobileMoneyService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class TicketPurchaseController extends Controller
{
    public function __construct(private MobileMoneyService $payments) {}

    public function buy(Request $request)
    {
        $validated = $request->validate([
            'evenement_id' => 'required|exists:evenements,evenement_id',
            'type_ticket'  => 'required|in:standard,premium,VIP',
            'montant'      => 'required|numeric|min:0',
            'methode'      => 'required|in:mobile_money,carte,bank',
        ]);

        // Vérifier que l’événement est approuvé et non terminé
        $event = Evenement::where('evenement_id', $validated['evenement_id'])
                  ->where('statut', 'approuve')->firstOrFail();

        // Récupérer/Créer le participant lié au user
        $participant = Participant::firstOrCreate(
            ['user_id' => auth()->user()->user_id, 'evenement_id' => $event->evenement_id],
            []
        );

        // Création paiement en attente
        $paiement = Paiement::create([
            'user_id'  => auth()->user()->user_id,
            'montant'  => $validated['montant'],
            'methode'  => $validated['methode'],
            'provider' => $validated['methode']==='mobile_money' ? 'mtn' : 'carte',
            'reference'=> (string) Str::uuid(),
            'statut'   => 'en_attente',
            'meta'     => ['evenement_id' => $event->evenement_id, 'type_ticket' => $validated['type_ticket']],
        ]);

        // Init provider
        $init = $this->payments->init($paiement);

        return response()->json([
            'message' => 'Paiement initié',
            'payment' => $paiement,
            'init'    => $init
        ], 201);
    }
}
