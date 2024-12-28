<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Prisoner;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class PrisonerPolicy
{
    /**
     * Perform pre-authorization checks
     */
    public function before(User $user): ?bool
    {
        // First check if user is logged in
        if (!Auth::check()) {
            return false;
        }

        // Superadmins can do everything
        if ($user->role === 'superadmin') {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the user can view any prisoners
     */
    public function viewAny(User $user): bool
    {
        // Must be logged in to view the list of prisoners
        if (!Auth::check()) {
            return false;
        }

        // All authenticated users can view the list of prisoners
        return true;
    }

    /**
     * Determine whether the user can view the prisoner
     */
    public function view(User $user, Prisoner $prisoner): bool
    {
        // Must be logged in to view prisoner details
        if (!Auth::check()) {
            return false;
        }

        // All authenticated users can view individual prisoner details
        return true;
    }

    /**
     * Determine whether the user can create prisoners
     */
    public function create(User $user): bool
    {
        // Must be logged in
        if (!Auth::check()) {
            return false;
        }

        // Only admins and superadmins can create
        return $user->role === 'admin' || $user->role === 'employee';
    }

    /**
     * Determine whether the user can update the prisoner
     */
    public function update(User $user, Prisoner $prisoner): Response
    {
        // Must be logged in
        if (!Auth::check()) {
            return Response::deny('You must be logged in to update prisoner records.');
        }

        // Only admins and superadmin can update
        if ($user->role === 'admin' || $user->role === 'employee') {
            return Response::allow();
        }

        return Response::deny('You are not authorized to update prisoner records.');
    }

    /**
     * Determine whether the user can delete the prisoner
     */
    public function delete(User $user, Prisoner $prisoner): Response
    {
        // Must be logged in
        if (!Auth::check()) {
            return Response::deny('You must be logged in to delete prisoner records.');
        }

        // Only superadmins can delete (handled by before method)
        return Response::deny('You are not authorized to delete prisoner records.');
    }

    /**
     * Determine whether the user can restore the prisoner
     */
    public function restore(User $user, Prisoner $prisoner): bool
    {
        // Must be logged in
        if (!Auth::check()) {
            return false;
        }

        // Only superadmins can restore (handled by before method)
        return false;
    }

    /**
     * Determine whether the user can permanently delete the prisoner
     */
    public function forceDelete(User $user, Prisoner $prisoner): bool
    {
        // Must be logged in
        if (!Auth::check()) {
            return false;
        }

        // Only superadmins can force delete (handled by before method)
        return false;
    }
}
