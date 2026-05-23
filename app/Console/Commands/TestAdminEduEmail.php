<?php

namespace App\Console\Commands;

use App\Models\Matricula;
use App\Models\User;
use App\Notifications\MatriculaCriadaNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestAdminEduEmail extends Command
{
    protected $signature = 'notify:test {email?} {--raw} {--database} {--show}';

    protected $description = 'Envia e-mail de teste para usuarios admin_edu. Opcional: email especifico, --raw, --database';

    public function handle(): int
    {
        $emailArg = $this->argument('email');
        $useRaw = $this->option('raw');
        $useDatabase = $this->option('database');
        $showOnly = $this->option('show');

        if (! $useRaw && ! $useDatabase) {
            $useRaw = true;
        }

        $users = collect();

        if ($emailArg) {
            $needle = strtolower(trim($emailArg));
            $user = User::whereRaw('LOWER(email) = ?', [$needle])->first();

            if (! $user) {
                $user = User::where('email', 'like', "%{$needle}%")->first();
            }

            if ($user) {
                if (! $user->hasRole('admin_edu')) {
                    $this->warn("Usuario {$emailArg} nao possui role admin_edu. Enviarei mesmo assim para teste.");
                }

                if (! empty($user->email)) {
                    $this->info("Usuario localizado: ID {$user->id}, e-mail {$user->email}");
                    $users = collect([$user]);
                }
            } else {
                $this->warn("Usuario {$emailArg} nao encontrado no sistema. Tentando envio direto para o e-mail informado.");
            }
        }

        if ($users->isEmpty() && ! $emailArg) {
            $users = User::role('admin_edu')->get()->filter(fn ($user) => ! empty($user->email));
        }

        if ($showOnly) {
            if ($emailArg) {
                $this->info('Busca por e-mail: '.$emailArg);
            }

            if ($users->isEmpty()) {
                $this->warn('Nenhum usuario encontrado no criterio informado.');
            } else {
                foreach ($users as $user) {
                    $this->line('ID '.$user->id.' | '.$user->email.' | roles: '.implode(',', $user->getRoleNames()->toArray()));
                }
            }

            return Command::SUCCESS;
        }

        if ($users->isEmpty() && $emailArg && $useRaw) {
            try {
                Mail::raw("Teste de e-mail do sistema de pre-matricula.\n", function ($message) use ($emailArg): void {
                    $message->to($emailArg)->subject('Teste de e-mail - Pre-matricula');
                });

                $this->info("Enviado diretamente para {$emailArg} (sem usuario).");

                return Command::SUCCESS;
            } catch (\Throwable $e) {
                $this->error("Falha ao enviar diretamente para {$emailArg}: {$e->getMessage()}");

                return Command::FAILURE;
            }
        }

        if ($users->isEmpty()) {
            $this->error('Nenhum usuario admin_edu com e-mail encontrado para enviar.');

            return Command::FAILURE;
        }

        $matricula = Matricula::latest()->first();
        $sent = [];
        $failed = [];

        foreach ($users as $user) {
            try {
                if ($useRaw) {
                    $encodedId = $matricula ? base64_encode((string) $matricula->id) : null;
                    $downloadUrl = $encodedId ? url("/matricula/comprovante/{$encodedId}/d") : null;
                    $printUrl = $encodedId ? url("/matricula/comprovante/{$encodedId}/p") : null;
                    $adminUrl = $matricula ? url("/admin/matriculas/{$matricula->id}") : null;
                    $text = "Teste de e-mail do sistema de pre-matricula.\n";

                    if ($matricula) {
                        $text .= "Matricula exemplo: {$matricula->id}\n";
                        $text .= "Ver Matricula: {$adminUrl}\n";
                        $text .= "Baixar comprovante: {$downloadUrl}\n";
                        $text .= "Imprimir comprovante: {$printUrl}\n";
                    }

                    Mail::raw($text, function ($message) use ($user): void {
                        $message->to($user->email)->subject('Teste de e-mail - Pre-matricula');
                    });
                }

                if ($useDatabase && $matricula) {
                    $user->notify(new MatriculaCriadaNotification($matricula));
                }

                $sent[] = $user->email;
            } catch (\Throwable $e) {
                $failed[] = ['email' => $user->email, 'error' => $e->getMessage()];
            }
        }

        $this->info('Enviados: '.implode(', ', $sent));

        foreach ($failed as $failure) {
            $this->error("Falha: {$failure['email']} => {$failure['error']}");
        }

        return Command::SUCCESS;
    }
}
