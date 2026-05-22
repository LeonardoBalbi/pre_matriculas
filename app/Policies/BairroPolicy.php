<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Bairro;

class BairroPolicy
{
    public function viewAny(User $user)
    {
        return $user->can('viewAnyBairro');
    }

    public function view(User $user, Bairro $bairro)
    {
        return $user->can('viewBairro');
    }

    public function create(User $user)
    {
        return $user->can('createBairro');
    }

    public function update(User $user, Bairro $bairro)
    {
        return $user->can('updateBairro');
    }

    public function delete(User $user, Bairro $bairro)
    {
        return $user->can('deleteBairro');
    }

    public function destroy(User $user, Bairro $bairro)
    {
        return $user->can('destroyBairro');
    }
}
