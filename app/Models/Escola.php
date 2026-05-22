<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Escola extends Model
{
    use HasFactory;

    // Relacionamento muitos-para-muitos com tipos de turma
    public function turmaTiposMulti()
    {
        return $this->belongsToMany(
            TurmaTipo::class,
            'escola_turma_tipo',
            'escola_id',
            'turma_tipo_id'
        );
    }

    protected $fillable = [
        'escola_nome',
        'escola_endereco',
        'escola_foto',
        'escola_bairro_id',
        'escola_distrito_id',
        'escola_vagas',
        'escola_vagas_especiais',
        'escola_ano_leitivo',
        'escola_status',
    ];


    public function bairro()
    {
        return $this->belongsTo(Bairro::class, 'escola_bairro_id');
    }   

    // Uma escola pode ter vários tipos de turma através das turmas
    public function turmatipos()
    {
        return $this->hasManyThrough(
            TurmaTipo::class, // Modelo destino
            Turma::class,     // Modelo intermediário
            'turma_escola_id', // FK em Turma que referencia Escola
            'id',              // FK em TurmaTipo (chave primária)
            'id',              // PK em Escola
            'turma_tipo_id'    // FK em Turma que referencia TurmaTipo
        );
    }

    public function matricula()
    {
        return $this->hasOne(Matricula::class. 'nome_candidato', 'id');
    }

    public function turma()
    {
        return $this->hasMany(Turma::class, 'turma_escola_id');
    }

    public function distrito()
    {
        return $this->belongsTo(Distrito::class, 'escola_distrito_id');
    }

    public function turmas()
{
    return $this->hasMany(Turma::class, 'turma_escola_id');
}



}
