<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Evenement;
use Illuminate\Http\Request;

class EventController extends Controller
{


    /**
     * Liste des événements en attente
     */
    public function pending()
    {
        $events = Evenement::where('statut', 'en_attente')->get();
        return response()->json($events);
    }

    /**
     * Approuver un événement
     */
    public function approve($id)
    {
        $event = Evenement::findOrFail($id);
        $event->update(['statut' => 'approuve']);

        // 👉 ici tu peux déclencher une notification
        $event->createur->notify(new \App\Notifications\EventApprovedNotification($event));

        return response()->json(['message' => 'Événement approuvé', 'event' => $event]);
    }

    /**
     * Refuser un événement
     */
    public function reject($id, Request $request)
    {
        $event = Evenement::findOrFail($id);
        $event->update(['statut' => 'refuse']);

        // 👉 notifier le créateur
        $event->createur->notify(new \App\Notifications\EventRejectedNotification($event, $request->reason ?? null));

        return response()->json(['message' => 'Événement refusé', 'event' => $event]);
    }

    /**
     * Terminer un événement
     */
    public function finish($id)
    {
        $event = Evenement::findOrFail($id);
        $event->update(['statut' => 'termine']);

        return response()->json(['message' => 'Événement terminé', 'event' => $event]);
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
