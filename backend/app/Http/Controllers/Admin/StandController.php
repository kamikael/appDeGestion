<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stand;
use Illuminate\Http\Request;

class StandController extends Controller
{
    public function pending()
    {
        return response()->json(Stand::where('statut', 'en_attente')->get());
    }

    public function preApprove($id)
{
    $stand = Stand::findOrFail($id);

    if ($stand->statut !== 'en_attente') {
        return response()->json(['message' => 'Stand déjà traité'], 400);
    }

    $stand->update(['statut' => 'pre_approve']);

    // Notifier le créateur de l’événement
    $stand->evenement->createur->notify(new \App\Notifications\StandPendingCreatorValidation($stand));

    return response()->json([
        'message' => 'Stand pré-approuvé par admin. En attente de validation du créateur.',
        'data' => $stand
    ]);
}


    public function reject($id, Request $request)
    {
        $stand = Stand::findOrFail($id);
        $stand->update(['statut' => 'refuse']);
        $stand->entrepreneur->notify(new \App\Notifications\StandRejectedNotification($stand, $request->reason));
        return response()->json(['message' => 'Stand refusé', 'data' => $stand]);
    }
}
