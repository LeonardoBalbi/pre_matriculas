<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Candidato;

class CandidatoPolicy
{
    public function viewAny(User $user)
    {
        return $user->can('viewAnyCandidato');
    }

    public function view(User $user, Candidato $candidato)
    {
        return $user->can('viewCandidato');
    }

    public function create(User $user)
    {
        return $user->can('createCandidato');
    }

    public function update(User $user, Candidato $candidato)
    {
        return $user->can('updateCandidato');
    }

    public function delete(User $user, Candidato $candidato)
    {
        return $user->can('deleteCandidato');
    }

    public function destroy(User $user, Candidato $candidato)
    {
        return $user->can('destroyCandidato');
    }
}
