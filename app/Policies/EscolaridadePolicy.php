<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Escolaridade;

class EscolaridadePolicy
{
    public function viewAny(User $user)
    {
        return $user->can('viewAnyEscolaridade');
    }

    public function view(User $user, Escolaridade $escolaridade)
    {
        return $user->can('viewEscolaridade');
    }

    public function create(User $user)
    {
        return $user->can('createEscolaridade');
    }

    public function update(User $user, Escolaridade $escolaridade)
    {
        return $user->can('updateEscolaridade');
    }

    public function delete(User $user, Escolaridade $escolaridade)
    {
        return $user->can('deleteEscolaridade');
    }

    public function destroy(User $user, Escolaridade $escolaridade)
    {
        return $user->can('destroyEscolaridade');
    }
}
