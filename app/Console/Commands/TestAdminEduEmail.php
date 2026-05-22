<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Matricula;
use App\Notifications\NovaMatriculaCriada;

class TestAdminEduEmail extends Command
{
    protected $signature = 'notify:test {email?} {--raw} {--nova} {--show}';
    protected $description = 'Envia e-mail de teste para usuários admin_edu. Opcional: email específico, --raw, --nova';

    public function handle()
    {
        $emailArg = $this->argument('email');
        $useRaw = $this->option('raw');
        $useNova = $this->option('nova');
        $showOnly = $this->option('show');
        if (!$useRaw && !$useNova) {
            $useRaw = true;
        }
        $users = collect();
        if ($emailArg) {
            $needle = strtolower(trim($emailArg));
            $u = User::whereRaw('LOWER(email) = ?', [$needle])->first();
            if (!$u) {
                $u = User::where('email', 'like', "%{$needle}%")->first();
            }
            if ($u) {
                if (!$u->hasRole('admin_edu')) {
                    $this->warn("Usuário {$emailArg} não possui role admin_edu. Enviarei mesmo assim para teste.");
                }
                if (!empty($u->email)) {
                    $this->info("Usuário localizado: ID {$u->id}, e-mail {$u->email}");
                    $users = collect([$u]);
                }
            } else {
                $this->warn("Usuário {$emailArg} não encontrado no sistema. Tentando envio direto para o e-mail informado.");
            }
        }
        if ($users->isEmpty() && !$emailArg) {
            $users = User::role('admin_edu')->get()->filter(function ($u) {
                return !empty($u->email);
            });
        }
        if ($showOnly) {
            if ($emailArg) {
                $this->info('Busca por e-mail: ' . $emailArg);
            }
            if ($users->isEmpty()) {
                $this->warn('Nenhum usuário encontrado no critério informado.');
            } else {
                foreach ($users as $u) {
                    $this->line('ID ' . $u->id . ' | ' . $u->email . ' | roles: ' . implode(',', $u->getRoleNames()->toArray()));
                }
            }
            return Command::SUCCESS;
        }
        if ($users->isEmpty() && $emailArg && $useRaw) {
            try {
                $texto = "Teste de e-mail do sistema de pré-matrícula.\n";
                Mail::raw($texto, function ($m) use ($emailArg) {
                    $m->to($emailArg)->subject('Teste de e-mail - Pré-matrícula');
                });
                $this->info("Enviado diretamente para {$emailArg} (sem usuário).");
                return Command::SUCCESS;
            } catch (\Throwable $e) {
                $this->error("Falha ao enviar diretamente para {$emailArg}: {$e->getMessage()}");
                return Command::FAILURE;
            }
        }
        if ($users->isEmpty()) {
            $this->error('Nenhum usuário admin_edu com e-mail encontrado para enviar.');
            return Command::FAILURE;
        }
        $matricula = Matricula::latest()->first();
        $sent = [];
        $failed = [];
        foreach ($users as $user) {
            try {
                if ($useRaw) {
                    $encodedId = $matricula ? base64_encode((string) $matricula->id) : null;
                    $dl = $encodedId ? url("/matricula/comprovante/{$encodedId}/d") : null;
                    $pr = $encodedId ? url("/matricula/comprovante/{$encodedId}/p") : null;
                    $urlNova = $matricula ? url("/nova/resources/matriculas/{$matricula->id}") : null;
                    $texto = "Teste de e-mail do sistema de pré-matrícula.\n";
                    if ($matricula) {
                        $texto .= "Matrícula exemplo: {$matricula->id}\n";
                        $texto .= "Ver Matrícula: {$urlNova}\n";
                        $texto .= "Baixar comprovante: {$dl}\n";
                        $texto .= "Imprimir comprovante: {$pr}\n";
                    }
                    Mail::raw($texto, function ($m) use ($user) {
                        $m->to($user->email)->subject('Teste de e-mail - Pré-matrícula');
                    });
                }
                if ($useNova && $matricula) {
                    $user->notify(new NovaMatriculaCriada($matricula));
                }
                $sent[] = $user->email;
            } catch (\Throwable $e) {
                $failed[] = ['email' => $user->email, 'error' => $e->getMessage()];
            }
        }
        $this->info('Enviados: ' . implode(', ', $sent));
        if (!empty($failed)) {
            foreach ($failed as $f) {
                $this->error("Falha: {$f['email']} => {$f['error']}");
            }
        }
        return Command::SUCCESS;
    }
}
