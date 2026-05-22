<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportSqlFile extends Command
{
    protected $signature = 'app:import-sql-file {file}';

    protected $description = 'Importa arquivo SQL';

    public function handle()
    {
        $file = $this->argument('file');

        if (! file_exists($file)) {
            $this->error('Arquivo não encontrado.');
            return;
        }

        $sql = file_get_contents($file);

        DB::unprepared($sql);

        $this->info('SQL importado com sucesso.');
    }
}