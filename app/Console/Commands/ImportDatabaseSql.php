<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportDatabaseSql extends Command
{
    protected $signature = 'app:import-database-sql';

    protected $description = 'Importa SQL no banco';

    public function handle()
    {
        $file = 'D:\\app_filament5_inicio\\app\\educacaoroot_sec_educ.sql';

        if (! file_exists($file)) {

            $this->error('Arquivo não encontrado.');

            return self::FAILURE;
        }

        $this->info('Importando banco...');

        $sql = file_get_contents($file);

        DB::unprepared($sql);

        $this->info('Banco importado com sucesso.');

        return self::SUCCESS;
    }
}