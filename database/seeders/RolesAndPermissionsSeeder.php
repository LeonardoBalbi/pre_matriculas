<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $models = [
            'Bairro',
            'Candidato',
            'CandidatoXp',
            'Distrito',
            'Escola',
            'Escolaridade',
            'Geral',
            'Matricula',
            'StatusMatricula',
            'TipoDeficiencia',
            'Turma',
            'TurmaTipo',
            'User',
            'Vagas',
            'VagasXp',
            'VagasXpPlus',
            'Classificado',
            'Colegio',
            'CpfAutorizado',


        ];

        $actions = ['viewAny', 'view', 'create', 'update', 'delete', 'destroy'];

        foreach ($models as $model) {
            foreach ($actions as $action) {
                Permission::firstOrCreate([
                    'name' => $action . $model,
                    'guard_name' => 'web',
                ], [
                    'group' => $model,
                ]);
            }
        }
        $permissions = [
            'viewRole',
            'createRole',
            'updateRole',
            'deleteRole',
            'viewPermission',
            'createPermission',
            'updatePermission',
            'deletePermission',
        ];
        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ], [
                'group' => strpos($permission, 'Role') !== false ? 'Role' : 'Permission',
            ]);
        }

        // Cria a role super-admin e atribui todas as permissões
        $role = Role::firstOrCreate(['name' => 'super-admin']);
        $role->syncPermissions(Permission::all());

        $superAdmin = Role::findByName('super-admin');

        \App\Models\User::query()->each(function (\App\Models\User $user) use ($superAdmin): void {
            if (! $user->hasRole('super-admin')) {
                $user->assignRole($superAdmin);
            }
        });
    }
}
