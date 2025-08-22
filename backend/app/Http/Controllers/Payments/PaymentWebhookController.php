<?php

// app/Http/Controllers/Payments/PaymentWebhookController.php
namespace App\Http\Controllers\Payments;

use App\Http\Controllers\Controller;
use App\Models\{Paiement, Ticket, Participant, Evenement};
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Events\Payments\PaymentSucceeded;
use App\Events\Payments\PaymentFailed;

class PaymentWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $rawBody = $request->getContent();
        // TODO: vérif signature si nécessaire

        $reference = $request->input('reference');
        $status    = $request->input('status'); // 'SUCCESS' | 'FAILED'
        $meta      = $request->input('meta', []);

        $paiement = Paiement::where('reference', $reference)->lockForUpdate()->firstOrFail();

        // Idempotence: si déjà traité on sort
        if (in_array($paiement->statut, ['reussi','echoue','refund'])) {
            return response()->json(['message' => 'Déjà traité'], 200);
        }

        if ($status === 'SUCCESS') {
            DB::transaction(function () use ($paiement, $meta) {
                $paiement->update([
                    'statut' => 'reussi',
                    'meta'   => array_merge($paiement->meta ?? [], ['callback_meta' => $meta])
                ]);

                // Crée le ticket lié
                $evenementId = $paiement->meta['evenement_id'];
                $typeTicket  = $paiement->meta['type_ticket'];

                // Trouver participant (user_id + event)
                $participantId = \App\Models\Participant::where('user_id', $paiement->user_id)
                    ->where('evenement_id', $evenementId)
                    ->value('participant_id');

                $ticket = Ticket::create([
                    'participant_id' => $participantId,
                    'evenement_id'   => $evenementId,
                    'type_ticket'    => $typeTicket,
                    'prix'           => $paiement->montant,
                    'paiement_id'    => $paiement->paiement_id,
                    'ticket_code'    => strtoupper(Str::random(10)),
                    'statut'         => 'valide',
                ]);

                event(new PaymentSucceeded($paiement, $ticket));
            });

            return response()->json(['message' => 'OK'], 200);
        }

        // FAILED
        $paiement->update(['statut' => 'echoue']);
        event(new PaymentFailed($paiement));
        return response()->json(['message' => 'KO'], 200);
    }
}
