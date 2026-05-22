<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\CpfAutorizado;
use App\Models\Matricula;

return new class extends Migration
{
    public function up(): void
    {
        // Limpa a tabela para reiniciar a lógica
        DB::table('cpf_autorizados')->truncate();

        // Pega todos os CPFs de matrículas ativas
        $matriculas = DB::table('matriculas')
            ->whereNull('deleted_at')
            ->select('cpf_candidato')
            ->distinct()
            ->get();

        foreach ($matriculas as $m) {
            $cpf = preg_replace('/\D+/', '', $m->cpf_candidato);
            
            if ($cpf) {
                // Usa insertOrIgnore para evitar erros de duplicidade se o banco estiver sujo
                DB::table('cpf_autorizados')->insertOrIgnore([
                    'cpf' => $cpf,
                    'motivo' => 'Importado de matrícula existente',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    public function down(): void
    {
        DB::table('cpf_autorizados')->truncate();
    }
};
