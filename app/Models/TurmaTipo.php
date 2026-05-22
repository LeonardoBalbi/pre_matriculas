<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class TurmaTipo extends Model
{
    use HasFactory;

    // Relacionamento muitos-para-muitos com escolas
    public function escolasMulti()
    {
        return $this->belongsToMany(
            Escola::class,
            'escola_turma_tipo',
            'turma_tipo_id',
            'escola_id'
        );
    }

    protected $fillable = [
        'tipo_descricao',
        'tipo_status'
    ];

    public function turmas()
    {
        return $this->hasMany(Turma::class, 'turma_tipo_id');
    }


    
}
