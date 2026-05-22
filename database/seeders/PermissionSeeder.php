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

        // Cria a role super-admin e atribui todas as permissões
        $role = Role::firstOrCreate(['name' => 'super-admin']);
        $role->syncPermissions(Permission::all());

        // Atribui a role para o usuário desejado (ajuste o email conforme necessário)
        $user = \App\Models\User::where('email', 'leogobalbi@gmail.com')->first();
        if ($user) {
            $user->assignRole('super-admin');
        }
    }
}
