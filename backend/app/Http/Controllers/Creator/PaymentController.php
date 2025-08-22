<?php

namespace App\Http\Controllers\Creator;


use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function index()
    {
        $creatorId = Auth::id();

        $tickets = Ticket::with(['paiement', 'evenement'])
            ->whereHas('paiement', function($q) {
                $q->where('statut', 'reussi');
            })
            ->whereHas('evenement', function($q) use ($creatorId) {
                $q->where('createur_id', $creatorId);
            })
            ->get();

        return response()->json($tickets);
    }

    public function tickets()
    {
        $creatorId = Auth::id();

        $q = Ticket::with(['paiement','evenement'])
            ->whereHas('paiement', fn($x)=>$x->where('statut','reussi'))
            ->whereHas('evenement', fn($e)=>$e->where('createur_id', Auth::user()->user_id));

        return response()->json($q->orderByDesc('ticket_id')->paginate(50));
    }

    public function stats()
    {
        $creatorId = Auth::user()->user_id;

        $base = Ticket::select(
                'evenement_id',
                DB::raw("COUNT(*) as tickets_vendus"),
                DB::raw("SUM(prix) as revenus")
            )
            ->whereHas('paiement', fn($x)=>$x->where('statut','reussi'))
            ->whereHas('evenement', fn($e)=>$e->where('createur_id', $creatorId))
            ->groupBy('evenement_id')
            ->get();

        $parType = Ticket::select(
                'evenement_id','type_ticket',
                DB::raw("COUNT(*) as qty"), DB::raw("SUM(prix) as total")
            )
            ->whereHas('paiement', fn($x)=>$x->where('statut','reussi'))
            ->whereHas('evenement', fn($e)=>$e->where('createur_id', $creatorId))
            ->groupBy('evenement_id','type_ticket')
            ->get();

        return response()->json(compact('base','parType'));
    }
}
