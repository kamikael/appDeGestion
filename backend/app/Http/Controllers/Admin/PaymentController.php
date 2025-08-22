<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Ticket, Paiement};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Voir tous les tickets payés (optionnellement filtrés par événement)
     */
    public function index(Request $request)
    {
        $query = Ticket::with(['paiement', 'evenement'])
            ->whereHas('paiement', function($q) {
                $q->where('statut', 'reussi');
            });

        if ($request->has('evenement_id')) {
            $query->where('evenement_id', $request->evenement_id);
        }

        return response()->json($query->get());
    }


    // Liste des tickets payés (filtre par event)
    public function tickets(Request $request)
    {
        $q = Ticket::with(['paiement','evenement'])
            ->whereHas('paiement', fn($x)=>$x->where('statut','reussi'));

        if ($request->evenement_id) $q->where('evenement_id', $request->evenement_id);

        return response()->json($q->orderByDesc('ticket_id')->paginate(50));
    }

    // Stats agrégées pour Dashboard
    public function stats(Request $request)
    {
        $base = Ticket::select(
                'evenement_id',
                DB::raw("COUNT(*) as tickets_vendus"),
                DB::raw("SUM(prix) as revenus")
            )
            ->whereHas('paiement', fn($x)=>$x->where('statut','reussi'))
            ->when($request->evenement_id, fn($qq)=>$qq->where('evenement_id',$request->evenement_id))
            ->groupBy('evenement_id')
            ->get();

        $parType = Ticket::select(
                'evenement_id','type_ticket',
                DB::raw("COUNT(*) as qty"), DB::raw("SUM(prix) as total")
            )
            ->whereHas('paiement', fn($x)=>$x->where('statut','reussi'))
            ->when($request->evenement_id, fn($qq)=>$qq->where('evenement_id',$request->evenement_id))
            ->groupBy('evenement_id','type_ticket')
            ->get();

        return response()->json(compact('base','parType'));
    }

    // Remboursement (logique métier + appel provider à brancher)
    public function refund($paiement_id, Request $request)
    {
        $paiement = Paiement::with('ticket')->findOrFail($paiement_id);
        if ($paiement->statut !== 'reussi') {
            return response()->json(['message'=>'Paiement non remboursable'], 422);
        }

        // TODO: appeler le provider pour rembourser réellement
        $montant = $request->input('montant', $paiement->montant);

        DB::transaction(function () use ($paiement, $montant) {
            $paiement->update([
                'statut' => 'refund',
                'montant_refund' => $montant,
                'refunded_at' => now(),
            ]);
            if ($paiement->ticket) {
                $paiement->ticket->update(['statut' => 'annule']);
            }
        });

        // Optionnel: notifier l’utilisateur
        // $paiement->user->notify(new \App\Notifications\RefundProcessedNotification($paiement));

        return response()->json(['message'=>'Remboursement enregistré', 'paiement'=>$paiement]);
    }
}
