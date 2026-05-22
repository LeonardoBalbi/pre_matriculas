<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Vagas;

class VagasPolicy
{
    public function viewAny(User $user)
    {
        return $user->can('viewAnyVagas');
    }

    public function view(User $user, Vagas $vagas)
    {
        return $user->can('viewVagas');
    }

    public function create(User $user)
    {
        return $user->can('createVagas');
    }

    public function update(User $user, Vagas $vagas)
    {
        return $user->can('updateVagas');
    }

    public function delete(User $user, Vagas $vagas)
    {
        return $user->can('deleteVagas');
    }

    public function destroy(User $user, Vagas $vagas)
    {
        return $user->can('destroyVagas');
    }
}
