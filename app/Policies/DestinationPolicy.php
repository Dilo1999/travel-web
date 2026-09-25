<?php

namespace App\Policies;

use App\Models\Destination;
use App\Models\User;

/**
 * Admins and editors manage destinations (including translating them with Claude); viewers can only list them.
 */
class DestinationPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->canAccessFilament();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isEditor();
    }

    public function update(User $user, Destination $destination): bool
    {
        return $user->isAdmin() || $user->isEditor();
    }

    public function delete(User $user, Destination $destination): bool
    {
        return $user->isAdmin() || $user->isEditor();
    }

    public function deleteAny(User $user): bool
    {
        return $user->isAdmin() || $user->isEditor();
    }

    public function reorder(User $user): bool
    {
        return $user->isAdmin() || $user->isEditor();
    }
}
