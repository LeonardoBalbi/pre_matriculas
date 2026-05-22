<?php

namespace App\Policies;

use App\Models\User;
use App\Models\VagasXp;

class VagasXpPolicy
{
    public function viewAny(User $user)
    {
        return $user->can('viewAnyVagasXp');
    }

    public function view(User $user, VagasXp $vagasXp)
    {
        return $user->can('viewVagasXp');
    }

    public function create(User $user)
    {
        return $user->can('createVagasXp');
    }

    public function update(User $user, VagasXp $vagasXp)
    {
        return $user->can('updateVagasXp');
    }

    public function delete(User $user, VagasXp $vagasXp)
    {
        return $user->can('deleteVagasXp');
    }

    public function destroy(User $user, VagasXp $vagasXp)
    {
        return $user->can('destroyVagasXp');
    }
}
