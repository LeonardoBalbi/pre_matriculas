<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidato extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_vagas',
        'nome',
        'local',
        'cpf',
        'data_nasc',
        'cor_raca',
        'nacionalidade',
        'naturalidade',
        'sexo',
        'estado_civil',
        'deficiencia',
        'tipo_deficiencia',
        'nome_pai',
        'nome_mae',
        'escolaridade',
        'rg',
        'rg_emissor',
        'rg_estado',
        'rg_data_emissao',
        'cep',
        'endereco',
        'numero',
        'complemento',
        'bairro',
        'cidade',
        'uf',
        'telefone',
        'celular',
        'email',
        'pontos',
        'status'
    ];

    protected $casts = [
        'deficiencia' => 'boolean',
        'data_nasc' => 'datetime:Y-m-d',
        'rg_data_emissao' => 'datetime:Y-m-d',
    ];

    public function vagas()
    {
        return $this->belongsTo(Vagas::class, 'id_vagas');
    }

    public function getCanditadoXp()
    {
        return $this->hasMany(CandidatoXp::class, 'id_candidato');
        
    }

    public function somaPontosExperiencias()
    {
    return $this->getCanditadoXp()
                ->join('vagas_xp_pluses', 'candidato_xps.id_vagas_xp_plus', '=', 'vagas_xp_pluses.id')
                ->sum('vagas_xp_pluses.pontos');
    }

    public function candidatoXp()
    {
        return $this->hasOne(CandidatoXp::class);
    }


}
