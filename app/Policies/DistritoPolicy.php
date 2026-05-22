<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Distrito;

class DistritoPolicy
{
    public function viewAny(User $user)
    {
        return $user->can('viewAnyDistrito');
    }

    public function view(User $user, Distrito $distrito)
    {
        return $user->can('viewDistrito');
    }

    public function create(User $user)
    {
        return $user->can('createDistrito');
    }

    public function update(User $user, Distrito $distrito)
    {
        return $user->can('updateDistrito');
    }

    public function delete(User $user, Distrito $distrito)
    {
        return $user->can('deleteDistrito');
    }

    public function destroy(User $user, Distrito $distrito)
    {
        return $user->can('destroyDistrito');
    }
}
