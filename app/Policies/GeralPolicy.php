<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Geral;

class GeralPolicy
{
    public function viewAny(User $user)
    {
        return $user->can('viewAnyGeral');
    }

    public function view(User $user, Geral $geral)
    {
        return $user->can('viewGeral');
    }

    public function create(User $user)
    {
        return $user->can('createGeral');
    }

    public function update(User $user, Geral $geral)
    {
        return $user->can('updateGeral');
    }

    public function delete(User $user, Geral $geral)
    {
        return $user->can('deleteGeral');
    }

    public function destroy(User $user, Geral $geral)
    {
        return $user->can('destroyGeral');
    }
}
