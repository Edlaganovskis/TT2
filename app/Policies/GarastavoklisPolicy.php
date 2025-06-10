<?php

namespace App\Policies;

use App\Models\Garastavoklis;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class GarastavoklisPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Garastavoklis $garastavoklis): bool
    {
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }
    public function update(User $user, Garastavoklis $garastavoklis): bool
    {
        // True, ja ir reģistra īpašnieks, vai administrators
        return $user->role_id == 2 || $user->id === $garastavoklis->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Garastavoklis $garastavoklis): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Garastavoklis $garastavoklis): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Garastavoklis $garastavoklis): bool
    {
        return false;
    }
}
