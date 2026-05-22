<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $user)
    {
        return $user->can('viewAnyUser');
    }

    public function view(User $user, User $model)
    {
        return $user->can('viewUser');
    }

    public function create(User $user)
    {
        return $user->can('createUser');
    }

    public function update(User $user, User $model)
    {
        return $user->can('updateUser');
    }

    public function delete(User $user, User $model)
    {
        return $user->can('deleteUser');
    }

    public function destroy(User $user, User $model)
    {
        return $user->can('destroyUser');
    }
}
