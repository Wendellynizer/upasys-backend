<?php

namespace App\Policies;

use App\Models\RentalUnit;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RentalUnitPolicy
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
    public function view(User $user, RentalUnit $rentalUnit): bool
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

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, RentalUnit $rentalUnit): Response
    {
        return $user->id === $rentalUnit->unit_owner_id
            ? Response::allow()
            : Response::deny("Not allowed.");
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, RentalUnit $rentalUnit): Response
    {
        return $user->id === $rentalUnit->unit_owner_id
            ? Response::allow()
            : Response::deny("Not allowed.");
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, RentalUnit $rentalUnit): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, RentalUnit $rentalUnit): bool
    {
        return false;
    }

    public function addTenant(User $user, RentalUnit $rentalUnit) {
        return $user->id === $rentalUnit->unit_owner_id
            ? Response::allow()
            : Response::deny("You are not the owner of the unit.");
    }
}
