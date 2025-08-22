<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
       $this->authorize('viewAny', User::class);  // pour index
       $this->authorize('create', User::class);  // pour store
       $this->authorize('update', $user);        // pour update
       $this->authorize('delete', $user);        // pour destroy

    }


    public function index()
    {
        return response()->json(User::all());
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:100',
            'email' => 'required|email|unique:users',
            'mot_de_passe_hash' => 'required|string|min:8',
            'role' => 'required|in:admin,createur,entrepreneur',
            'telephone' => 'nullable|string|max:20',
            'statut' => 'required|in:actif,inactif,banni',
        ]);

        $user = User::create($validated);

        return response()->json($user, 201);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'nom' => 'sometimes|string|max:100',
            'email' => 'sometimes|email|unique:users,email,' . $user->user_id . ',user_id',
            'mot_de_passe_hash' => 'sometimes|string|min:8',
            'role' => 'sometimes|in:admin,createur,entrepreneur',
            'telephone' => 'nullable|string|max:20',
            'statut' => 'sometimes|in:actif,inactif,banni',
        ]);

        $user->update($validated);

        return response()->json($user);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete(); // soft delete si SoftDeletes activé
        return response()->noContent();
    }
}
