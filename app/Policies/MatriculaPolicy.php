<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Matricula;

class MatriculaPolicy
{
    public function viewAny(User $user)
    {
        return $user->can('viewAnyMatricula');
    }

    public function view(User $user, Matricula $matricula)
    {
    return true;
    }

    public function create(User $user)
    {
        return $user->can('createMatricula');
    }

    public function update(User $user, Matricula $matricula)
    {
        // Permite atualizar se tiver a permissão OU se for do papel "colegio"
        return $user->can('updateMatricula') || $user->hasRole('colegio');
    }

    public function delete(User $user, Matricula $matricula)
    {
        return $user->can('deleteMatricula');
    }

    public function destroy(User $user, Matricula $matricula)
    {
        return $user->can('destroyMatricula');
    }
}
