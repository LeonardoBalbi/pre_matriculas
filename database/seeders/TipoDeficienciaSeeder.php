<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoDeficienciaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tipo_deficiencias')->updateOrInsert(
            ['id' => 1],
            ['tipo_deficiencia' => 'Auditiva', 'created_at' => now(), 'updated_at' => now()]
        );
        DB::table('tipo_deficiencias')->updateOrInsert(
            ['id' => 2],
            ['tipo_deficiencia' => 'Visual', 'created_at' => now(), 'updated_at' => now()]
        );
        DB::table('tipo_deficiencias')->updateOrInsert(
            ['id' => 3],
            ['tipo_deficiencia' => 'Motora', 'created_at' => now(), 'updated_at' => now()]
        );
    }
}

