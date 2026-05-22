<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Escola;

class EscolaPolicy
{
    public function viewAny(User $user)
    {
        return $user->can('viewAnyEscola');
    }

    public function view(User $user, Escola $escola)
    {
        return $user->can('viewEscola');
    }

    public function create(User $user)
    {
        return $user->can('createEscola');
    }

    public function update(User $user, Escola $escola)
    {
        return $user->can('updateEscola');
    }

    public function delete(User $user, Escola $escola)
    {
        return $user->can('deleteEscola');
    }

    public function destroy(User $user, Escola $escola)
    {
        return $user->can('destroyEscola');
    }
}
