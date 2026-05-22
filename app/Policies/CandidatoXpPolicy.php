<?php

namespace App\Policies;

use App\Models\User;
use App\Models\CandidatoXp;

class CandidatoXpPolicy
{
    public function viewAny(User $user)
    {
        return $user->can('viewAnyCandidatoXp');
    }

    public function view(User $user, CandidatoXp $candidatoXp)
    {
        return $user->can('viewCandidatoXp');
    }

    public function create(User $user)
    {
        return $user->can('createCandidatoXp');
    }

    public function update(User $user, CandidatoXp $candidatoXp)
    {
        return $user->can('updateCandidatoXp');
    }

    public function delete(User $user, CandidatoXp $candidatoXp)
    {
        return $user->can('deleteCandidatoXp');
    }

    public function destroy(User $user, CandidatoXp $candidatoXp)
    {
        return $user->can('destroyCandidatoXp');
    }
}
