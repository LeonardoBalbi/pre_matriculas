<?php

namespace App\Exports;

use App\Models\Matricula;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Database\Eloquent\Builder;

class MatriculaExport implements FromQuery, WithHeadings, WithMapping
{
    protected $query;

    public function __construct(Builder $query)
    {
        $this->query = $query;
    }

    public function query()
    {
        return $this->query;
    }

    public function headings(): array
    {
        return [
            'Protocolo',
            'Nome do Candidato',
            'Data de Nascimento',
            'Vulnerável Social',
            'Portador de Deficiência',
        ];
    }

    public function map($matricula): array
    {
        return [
            $matricula->protocolo,
            $matricula->nome_candidato,
            $matricula->data_nascimento 
                ? \Carbon\Carbon::parse($matricula->data_nascimento)->format('d/m/Y') 
                : '',
            $matricula->vulneravel_social ? 'Sim' : 'Não',
            $matricula->portador_deficiencia ? 'Sim' : 'Não',
        ];
    }
}