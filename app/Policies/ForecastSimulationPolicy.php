<?php

namespace App\Policies;

use App\Models\ForecastSimulation;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ForecastSimulationPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('simulation');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ForecastSimulation $forecastSimulations): bool
    {
        return $forecastSimulations->user_id === $user->id || $user->can('view_simulation');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_transaction');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ForecastSimulation $forecastSimulations): bool
    {
        return $forecastSimulations->user_id === $user->id || $user->can('update_transaction');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ForecastSimulation $forecastSimulations): bool
    {
        return $forecastSimulations->user_id === $user->id || $user->can('delete_transaction');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user): bool
    {
        return $user->can('restore_transaction');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user): bool
    {
        return $user->can('force_delete_transaction');
    }
}
