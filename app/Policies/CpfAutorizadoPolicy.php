<?php

namespace App\Policies;

use App\Models\CpfAutorizado;
use App\Models\User;

class CpfAutorizadoPolicy
{
    private function allowed(User $user, string $permission): bool
    {
        return $user->hasAnyRole(['super-admin', 'admin', 'admin_edu'])
            || $user->can($permission);
    }

    public function viewAny(User $user): bool
    {
        return $this->allowed($user, 'viewAnyCpfAutorizado');
    }

    public function view(User $user, CpfAutorizado $cpfAutorizado): bool
    {
        return $this->allowed($user, 'viewCpfAutorizado');
    }

    public function create(User $user): bool
    {
        return $this->allowed($user, 'createCpfAutorizado');
    }

    public function update(User $user, CpfAutorizado $cpfAutorizado): bool
    {
        return $this->allowed($user, 'updateCpfAutorizado');
    }

    public function delete(User $user, CpfAutorizado $cpfAutorizado): bool
    {
        return $this->allowed($user, 'deleteCpfAutorizado');
    }

    public function destroy(User $user, CpfAutorizado $cpfAutorizado): bool
    {
        return $this->allowed($user, 'destroyCpfAutorizado');
    }
}
