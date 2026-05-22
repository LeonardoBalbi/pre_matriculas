<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class EscolaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('escolas')->updateOrInsert(
            ['escola_nome' => 'Escola Municipal Modelo'],
            [
                'escola_endereco' => 'Rua das Flores, 123',
                'escola_bairro_id' => 1,
                'escola_distrito_id' => 1,
                'escola_vagas' => 40,
                'escola_vagas_especiais' => 5,
                'escola_ano_leitivo' => 2025,
                'escola_status' => 'ativa',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        DB::table('escolas')->updateOrInsert(
            ['escola_nome' => 'Centro Educacional Nova Geração'],
            [
                'escola_endereco' => 'Avenida Central, 456',
                'escola_bairro_id' => 2,
                'escola_distrito_id' => 1,
                'escola_vagas' => 30,
                'escola_vagas_especiais' => 3,
                'escola_ano_leitivo' => 2025,
                'escola_status' => 'ativa',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
