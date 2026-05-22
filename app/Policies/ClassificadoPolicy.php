<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Matricula;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClassificadoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any matriculas.
     */
    public function viewAny(User $user)
    {
        return $user->hasRole('super-admin')
            || $user->hasRole('admin_edu');
    }

    /**
     * Determine whether the user can view the matricula.
     */
    public function view(User $user, Matricula $matricula)
    {
        return $user->hasRole('super-admin')
            || $user->hasRole('admin_edu');
    }

    /**
     * Determine whether the user can create matriculas.
     */
    public function create(User $user)
    {
        return $user->hasRole('super-admin')
            || $user->hasRole('admin_edu');
    }

    /**
     * Determine whether the user can update the matricula.
     */
    public function update(User $user, Matricula $matricula)
    {
        return $user->hasRole('super-admin')
            || $user->hasRole('admin_edu');
    }

    /**
     * Determine whether the user can delete the matricula.
     */
    public function delete(User $user, Matricula $matricula)
    {
        return $user->hasRole('super-admin')
            || $user->hasRole('admin_edu');
    }
}
