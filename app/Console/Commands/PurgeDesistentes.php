<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Matricula;
use App\Models\MatriculaDeletedLog;

class PurgeDesistentes extends Command
{
    protected $signature = 'matriculas:purge-desistentes';
    protected $description = 'Remove automaticamente matrículas com status Desistente após período definido';

    public function handle(): int
    {
        $days = (int) (env('DESISTENTE_PURGE_DAYS', 30));
        $cutoff = Carbon::now()->subDays($days);

        $desistenteId = DB::table('status_matriculas')
            ->whereRaw('LOWER(status_matricula) = ?', ['desistente'])
            ->value('id');

        $idsConsiderados = [];
        if ($desistenteId) {
            $idsConsiderados[] = (int) $desistenteId;
        }
        $idsConsiderados[] = 12;

        $query = Matricula::whereIn('situacao_matricula', $idsConsiderados)
            ->where('updated_at', '<=', $cutoff)
            ->whereNull('deleted_at')
            ->orderBy('id');

        $total = $query->count();
        if ($total === 0) {
            $this->info("Nenhuma matrícula elegível para exclusão automática.");
            return Command::SUCCESS;
        }

        $this->info("Excluindo {$total} matrículas com status Desistente e atualização anterior a {$days} dias...");

        $query->chunkById(200, function ($matriculas) {
            foreach ($matriculas as $matricula) {
                MatriculaDeletedLog::create([
                    'matricula_id'    => $matricula->id,
                    'deleted_by'      => null,
                    'deleted_by_name' => 'sistema',
                    'motivo_exclusao' => 'Exclusão automática (desistente)',
                    'dados_matricula' => $matricula->toArray(),
                ]);
                $matricula->delete();
            }
        });

        $this->info("Concluído.");
        return Command::SUCCESS;
    }
}

