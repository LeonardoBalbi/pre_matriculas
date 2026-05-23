<?php

namespace App\Providers;

use App\Models\Bairro;
use App\Models\Candidato;
use App\Models\CandidatoXp;
use App\Models\Classificado;
use App\Models\CpfAutorizado;
use App\Models\Distrito;
use App\Models\Escola;
use App\Models\Escolaridade;
use App\Models\Geral;
use App\Models\Matricula;
use App\Models\StatusMatricula;
use App\Models\TipoDeficiencia;
use App\Models\Turma;
use App\Models\TurmaTipo;
use App\Models\User;
use App\Models\Vagas;
use App\Models\VagasXp;
use App\Models\VagasXpPlus;
use App\Policies\BairroPolicy;
use App\Policies\CandidatoPolicy;
use App\Policies\CandidatoXpPolicy;
use App\Policies\ClassificadoPolicy;
use App\Policies\CpfAutorizadoPolicy;
use App\Policies\DistritoPolicy;
use App\Policies\EscolaPolicy;
use App\Policies\EscolaridadePolicy;
use App\Policies\GeralPolicy;
use App\Policies\MatriculaPolicy;
use App\Policies\StatusMatriculaPolicy;
use App\Policies\TipoDeficienciaPolicy;
use App\Policies\TurmaPolicy;
use App\Policies\TurmaTipoPolicy;
use App\Policies\UserPolicy;
use App\Policies\VagasPolicy;
use App\Policies\VagasXpPlusPolicy;
use App\Policies\VagasXpPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Bairro::class => BairroPolicy::class,
        Candidato::class => CandidatoPolicy::class,
        CandidatoXp::class => CandidatoXpPolicy::class,
        Classificado::class => ClassificadoPolicy::class,
        CpfAutorizado::class => CpfAutorizadoPolicy::class,
        Distrito::class => DistritoPolicy::class,
        Escola::class => EscolaPolicy::class,
        Escolaridade::class => EscolaridadePolicy::class,
        Geral::class => GeralPolicy::class,
        Matricula::class => MatriculaPolicy::class,
        StatusMatricula::class => StatusMatriculaPolicy::class,
        TipoDeficiencia::class => TipoDeficienciaPolicy::class,
        Turma::class => TurmaPolicy::class,
        TurmaTipo::class => TurmaTipoPolicy::class,
        User::class => UserPolicy::class,
        Vagas::class => VagasPolicy::class,
        VagasXp::class => VagasXpPolicy::class,
        VagasXpPlus::class => VagasXpPlusPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('accessAdminPanel', function ($user): bool {
            return method_exists($user, 'hasAnyRole')
                && $user->hasAnyRole(['super-admin', 'admin', 'admin_edu', 'colegio']);
        });

        // Implicitly grant "super-admin" role all permission checks using can()
        Gate::before(function ($user, $ability) {
            return $user->hasRole('super-admin') ? true : null;
        });
    }
}
