<?php

namespace App\Policies;

use App\Models\User;
use App\Models\StatusMatricula;

class StatusMatriculaPolicy
{
    public function viewAny(User $user)
    {
        return $user->can('viewAnyStatusMatricula');
    }

    public function view(User $user, StatusMatricula $statusMatricula)
    {
        return $user->can('viewStatusMatricula');
    }

    public function create(User $user)
    {
        return $user->can('createStatusMatricula');
    }

    public function update(User $user, StatusMatricula $statusMatricula)
    {
        return $user->can('updateStatusMatricula');
    }

    public function delete(User $user, StatusMatricula $statusMatricula)
    {
        return $user->can('deleteStatusMatricula');
    }

    public function destroy(User $user, StatusMatricula $statusMatricula)
    {
        return $user->can('destroyStatusMatricula');
    }
}
