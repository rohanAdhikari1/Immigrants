<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Household;
use Illuminate\Auth\Access\HandlesAuthorization;

class HouseholdPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_household');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Household $household): bool
    {
        return $user->can('view_household');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_household');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Household $household): bool
    {
        return $user->can('update_household');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Household $household): bool
    {
        return $user->can('delete_household');
    }

    /**
     * Determine whether the user can bulk delete.
     */
    public function deleteAny(User $user): bool
    {
        return $user->can('delete_any_household');
    }

    /**
     * Determine whether the user can permanently delete.
     */
    public function forceDelete(User $user, Household $household): bool
    {
        return $user->can('force_delete_household');
    }

    /**
     * Determine whether the user can permanently bulk delete.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->can('force_delete_any_household');
    }

    /**
     * Determine whether the user can restore.
     */
    public function restore(User $user, Household $household): bool
    {
        return $user->can('restore_household');
    }

    /**
     * Determine whether the user can bulk restore.
     */
    public function restoreAny(User $user): bool
    {
        return $user->can('restore_any_household');
    }

    /**
     * Determine whether the user can replicate.
     */
    public function replicate(User $user, Household $household): bool
    {
        return $user->can('replicate_household');
    }

    /**
     * Determine whether the user can reorder.
     */
    public function reorder(User $user): bool
    {
        return $user->can('reorder_household');
    }
}
