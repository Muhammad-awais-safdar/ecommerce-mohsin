<?php

namespace App\Policies;

use App\Models\Ad;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AdPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // Only allow specific user to manage ads
        return strtolower($user->name) === strtolower('Awais Safdar') && $user->email === 'awais@gmail.com';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Ad $ad): bool
    {
        return $this->viewAny($user);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $this->viewAny($user);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Ad $ad): bool
    {
        return $this->viewAny($user);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Ad $ad): bool
    {
        return $this->viewAny($user);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Ad $ad): bool
    {
        return $this->viewAny($user);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Ad $ad): bool
    {
        return $this->viewAny($user);
    }

    /**
     * Determine whether the user can reset ad statistics.
     */
    public function resetStats(User $user, Ad $ad): bool
    {
        return $this->viewAny($user);
    }

    /**
     * Determine whether the user can view ad analytics.
     */
    public function viewAnalytics(User $user, Ad $ad): bool
    {
        return $this->viewAny($user);
    }
}