<?php

namespace App\Policies;

use App\Models\User;
use App\Models\TipoDeficiencia;

class TipoDeficienciaPolicy
{
    public function viewAny(User $user)
    {
        return $user->can('viewAnyTipoDeficiencia');
    }

    public function view(User $user, TipoDeficiencia $tipoDeficiencia)
    {
        return $user->can('viewTipoDeficiencia');
    }

    public function create(User $user)
    {
        return $user->can('createTipoDeficiencia');
    }

    public function update(User $user, TipoDeficiencia $tipoDeficiencia)
    {
        return $user->can('updateTipoDeficiencia');
    }

    public function delete(User $user, TipoDeficiencia $tipoDeficiencia)
    {
        return $user->can('deleteTipoDeficiencia');
    }

    public function destroy(User $user, TipoDeficiencia $tipoDeficiencia)
    {
        return $user->can('destroyTipoDeficiencia');
    }
}
