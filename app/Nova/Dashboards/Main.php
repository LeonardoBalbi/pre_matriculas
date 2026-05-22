<?php

namespace App\Nova\Dashboards;

use Laravel\Nova\Cards\Help;
use App\Nova\Metrics\Candidatos;
use App\Nova\Metrics\PreMatriculas;
use App\Nova\Metrics\Sexo;
use App\Nova\Metrics\TotalEscolas;
use App\Nova\Metrics\PreMatriculaBairro;
use App\Nova\Metrics\PreMatriculaEscola;
use Laravel\Nova\Dashboards\Main as Dashboard;

class Main extends Dashboard
{
    
    /**
     * Get the cards for the dashboard.
     *
     * @return array
     */
    public function cards()
    {
        return [
            new Candidatos,
            new PreMatriculas,
            new Sexo,
            new TotalEscolas,
            new PreMatriculaBairro,
        ];
    }

    public function label()
    {
        return 'Dashboard';
    }
}
