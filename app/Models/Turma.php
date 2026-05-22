<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turma extends Model
{
    use HasFactory;

    protected $fillable = [
        'turma_escola_id',
        'turma_tipo_id',
        'nome_candidato_id',
        'turma_descricao',
        'turma_qtd_vagas',
        'turma_qtd_vagas_especiais',
        'turma_ano_letivo',
        'turma_idade_minima',
        'turma_idade_maxima',
        'turma_idade_anos',
        'turma_status',


    ];

    public function escola()
    {
        return $this->belongsTo(Escola::class, 'turma_escola_id');
    }

    public function turmaTipo()
    {
        return $this->belongsTo(TurmaTipo::class, 'turma_tipo_id');
    }
    
    public function matricula()
    {
        return $this->hasMany(Matricula::class, 'turma_id');
    }

}
