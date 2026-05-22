<?php

namespace App\Policies;

use App\Models\User;
use App\Models\VagasXpPlus;

class VagasXpPlusPolicy
{
    public function viewAny(User $user)
    {
        return $user->can('viewAnyVagasXpPlus');
    }

    public function view(User $user, VagasXpPlus $vagasXpPlus)
    {
        return $user->can('viewVagasXpPlus');
    }

    public function create(User $user)
    {
        return $user->can('createVagasXpPlus');
    }

    public function update(User $user, VagasXpPlus $vagasXpPlus)
    {
        return $user->can('updateVagasXpPlus');
    }

    public function delete(User $user, VagasXpPlus $vagasXpPlus)
    {
        return $user->can('deleteVagasXpPlus');
    }

    public function destroy(User $user, VagasXpPlus $vagasXpPlus)
    {
        return $user->can('destroyVagasXpPlus');
    }
}
