<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Vérifie si l'utilisateur est admin
     */
    public function isAdmin(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Exemple : seuls les admins peuvent voir la liste des utilisateurs
     */
    public function viewAny(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Exemple : seuls les admins peuvent créer un utilisateur
     */
    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Exemple : seuls les admins peuvent mettre à jour un utilisateur
     */
    public function update(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Exemple : seuls les admins peuvent supprimer un utilisateur
     */
    public function delete(User $user): bool
    {
        return $user->role === 'admin';
    }
}
