<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Turma;

class TurmaPolicy
{
    public function viewAny(User $user)
    {
        return $user->hasRole('super-admin') || $user->hasRole('admin') || $user->hasRole('admin_edu') ;
    }

    public function view(User $user, Turma $turma)
    {
        return $user->hasRole('super-admin') || $user->hasRole('admin') || $user->hasRole('admin_edu');
    }

    public function create(User $user)
    {
        return $user->hasRole('super-admin') || $user->hasRole('admin') || $user->hasRole('admin_edu') ;
    }

    public function update(User $user, Turma $turma)
    {
        return $user->hasRole('super-admin') || $user->hasRole('admin') || $user->hasRole('admin_edu');
    }

    public function delete(User $user, Turma $turma)
    {
        return $user->hasRole('super-admin') || $user->hasRole('admin') || $user->hasRole('admin_edu') ;
    }

    public function destroy(User $user, Turma $turma)
    {
        return $user->hasRole('super-admin') || $user->hasRole('admin') || $user->hasRole('admin_edu');
    }
}
