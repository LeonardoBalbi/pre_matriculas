<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        \App\Models\Bairro::class => \App\Policies\BairroPolicy::class,
        \App\Models\Candidato::class => \App\Policies\CandidatoPolicy::class,
        \App\Models\CandidatoXp::class => \App\Policies\CandidatoXpPolicy::class,
        \App\Models\Classificado::class => \App\Policies\ClassificadoPolicy::class,
        \App\Models\CpfAutorizado::class => \App\Policies\CpfAutorizadoPolicy::class,
        \App\Models\Distrito::class => \App\Policies\DistritoPolicy::class,
        \App\Models\Escola::class => \App\Policies\EscolaPolicy::class,
        \App\Models\Escolaridade::class => \App\Policies\EscolaridadePolicy::class,
        \App\Models\Geral::class => \App\Policies\GeralPolicy::class,
        \App\Models\Matricula::class => \App\Policies\MatriculaPolicy::class,
        \App\Models\StatusMatricula::class => \App\Policies\StatusMatriculaPolicy::class,
        \App\Models\TipoDeficiencia::class => \App\Policies\TipoDeficienciaPolicy::class,
        \App\Models\Turma::class => \App\Policies\TurmaPolicy::class,
        \App\Models\TurmaTipo::class => \App\Policies\TurmaTipoPolicy::class,
        \App\Models\User::class => \App\Policies\UserPolicy::class,
        \App\Models\Vagas::class => \App\Policies\VagasPolicy::class,
        \App\Models\VagasXp::class => \App\Policies\VagasXpPolicy::class,
        \App\Models\VagasXpPlus::class => \App\Policies\VagasXpPlusPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Implicitly grant "super-admin" role all permission checks using can()
        Gate::before(function ($user, $ability) {
            return $user->hasRole('super-admin') ? true : null;
        });
    }
}
