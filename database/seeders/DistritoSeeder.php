<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistritoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('distritos')->updateOrInsert(
            ['id' => 1],
            ['distrito' => 'Distrito Central', 'created_at' => now(), 'updated_at' => now()]
        );
    }
}
