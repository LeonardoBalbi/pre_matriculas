<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\Escola;

class ColegioRoleSeeder extends Seeder
{
    public function run(): void
    {
        $role = Role::firstOrCreate(['name' => 'colegio', 'guard_name' => 'web']);

        $viewAnyEscola = Permission::firstOrCreate(['name' => 'viewAnyEscola', 'guard_name' => 'web']);
        $viewEscola = Permission::firstOrCreate(['name' => 'viewEscola', 'guard_name' => 'web']);

        if ($role->hasPermissionTo('viewAnyEscola')) {
            $role->revokePermissionTo('viewAnyEscola');
        }
        if ($role->hasPermissionTo('viewEscola')) {
            $role->revokePermissionTo('viewEscola');
        }

        $user = User::first();
        if ($user && !$user->hasRole('colegio')) {
            $user->assignRole($role);
        }

        if ($user && empty($user->current_team_id)) {
            $escola = Escola::query()->select('id')->first();
            if ($escola) {
                $user->current_team_id = $escola->id;
                $user->save();
            }
        }
    }
}
