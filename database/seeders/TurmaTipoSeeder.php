<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TurmaTipoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('turma_tipos')->updateOrInsert(
            ['id' => 1],
            ['tipo_descricao' => 'Infantil', 'created_at' => now(), 'updated_at' => now()]
        );
    }
}
