<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TurmaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('turmas')->updateOrInsert(
            ['turma_escola_id' => 1, 'turma_descricao' => 'Turma Infantil A'],
            [
                'turma_tipo_id' => 1,
                'matricula_id' => null,
                'turma_qtd_vagas' => 20,
                'turma_qtd_vagas_especiais' => 2,
                'turma_ano_letivo' => 2025,
                'turma_idade_minima' => 4,
                'turma_idade_maxima' => 5,
                'turma_idade_anos' => 4,
                'turma_status' => 'ativa',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        DB::table('turmas')->updateOrInsert(
            ['turma_escola_id' => 1, 'turma_descricao' => 'Turma Infantil B'],
            [
                'turma_tipo_id' => 1,
                'matricula_id' => null,
                'turma_qtd_vagas' => 18,
                'turma_qtd_vagas_especiais' => 1,
                'turma_ano_letivo' => 2025,
                'turma_idade_minima' => 5,
                'turma_idade_maxima' => 6,
                'turma_idade_anos' => 5,
                'turma_status' => 'ativa',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
