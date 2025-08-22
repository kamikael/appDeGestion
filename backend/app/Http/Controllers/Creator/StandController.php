<?php
namespace App\Http\Controllers\Creator;

use App\Http\Controllers\Controller;
use App\Models\Stand;
use Illuminate\Http\Request;

class StandController extends Controller
{
    public function approve($id)
    {
        $stand = Stand::findOrFail($id);

        // Vérifier que l’utilisateur connecté est bien le créateur de l’événement
        if ($stand->evenement->createur_id !== auth()->id()) {
            return response()->json(['message' => 'Non autorisé'], 403);
        }

        if ($stand->statut !== 'pre_approve') {
            return response()->json(['message' => 'Le stand doit être pré-approuvé par un admin avant.'], 400);
        }

        $stand->update(['statut' => 'approuve']);

        // Notifier l’entrepreneur
        $stand->entrepreneur->notify(new \App\Notifications\StandApprovedNotification($stand));

        return response()->json([
            'message' => 'Stand validé par le créateur',
            'data' => $stand
        ]);
    }

    public function reject($id, Request $request)
    {
        $stand = Stand::findOrFail($id);

        if ($stand->evenement->createur_id !== auth()->id()) {
            return response()->json(['message' => 'Non autorisé'], 403);
        }

        if (!in_array($stand->statut, ['pre_approve', 'en_attente'])) {
            return response()->json(['message' => 'Stand déjà traité'], 400);
        }

        $stand->update(['statut' => 'refuse']);

        // Notifier l’entrepreneur
        $stand->entrepreneur->notify(new \App\Notifications\StandRejectedNotification($stand, $request->reason));

        return response()->json([
            'message' => 'Stand refusé par le créateur',
            'data' => $stand
        ]);
    }
}
