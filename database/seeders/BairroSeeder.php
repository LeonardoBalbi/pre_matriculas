<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BairroSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('bairros')->updateOrInsert(
            ['id' => 1],
            ['descricao' => 'Centro', 'distrito_id' => 1, 'created_at' => now(), 'updated_at' => now()]
        );
        DB::table('bairros')->updateOrInsert(
            ['id' => 2],
            ['descricao' => 'Jardim das Flores', 'distrito_id' => 1, 'created_at' => now(), 'updated_at' => now()]
        );
    }
}
