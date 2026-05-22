<?php

namespace App\Policies;

use App\Models\User;
use App\Models\TurmaTipo;

class TurmaTipoPolicy
{
    public function viewAny(User $user)
    {
        return $user->can('viewAnyTurmaTipo');
    }

    public function view(User $user, TurmaTipo $turmaTipo)
    {
        return $user->can('viewTurmaTipo');
    }

    public function create(User $user)
    {
        return $user->can('createTurmaTipo');
    }

    public function update(User $user, TurmaTipo $turmaTipo)
    {
        return $user->can('updateTurmaTipo');
    }

    public function delete(User $user, TurmaTipo $turmaTipo)
    {
        return $user->can('deleteTurmaTipo');
    }

    public function destroy(User $user, TurmaTipo $turmaTipo)
    {
        return $user->can('destroyTurmaTipo');
    }
}
