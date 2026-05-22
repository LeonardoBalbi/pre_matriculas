<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Matricula extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'protocolo',
        'ano_letivo',
        'data_nascimento',
        'nome_candidato',
        'cpf_candidato',
        'idade',
        'situacao_matricula',
        'observacao',
        'idade_corte_meses',
        'idade_data_corte',
        'idade_data_corte_mes',
        'idade_data_corte_dias',
        'escola_nome_id',
        'turma_id',
        'sexo',

        'irmao_creche',
        'irmao_gemeo',
        'nome_irmao_gemeo',
        'carteira_vacinacao',
        'cartao_sus',
        'bolsa_familia',
        'cad_unico',
        'portador_deficiencia',
        'deficiencias_tipo',
        'distrito_id',
        'endereco',
        'escola_bairro_id',
        'grau_parentesco',
        'nome_responsavel',
        'email_responsavel',
        'data_nasc_responsavel',
        'cpf_responsavel',
        'rg_responsavel',
        'mae_menor',
        'escolaridade_id',
        'tel_fixo_responsavel',
        'tel_cel_responsavel',
        'vulneravel_social',
        'pedido_transferencia',
        'aceite_edital',
        'acao_judicial_candidato',
        'candidato_remanescente',
        'data_inscricao',
        'data_reat_inscricao',
        'inscricao_reativada',
        'usr_login',
        'declaro',
        'edital',
        'turma_especie', // adicionado para mass assignment
    ];


    protected $casts = [
        'data_nascimento'=> 'string',
        'data_nasc_responsavel'=> 'string',
        // 'ano_letivo'=> 'date',
        'data_inscricao'=> 'string',
        'data_reat_inscricao'=> 'date',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Obtenha o ano atual
            $anoAtual = now()->year;

            // Obtenha o último número de protocolo gerado e incremente
            $ultimoProtocolo = Matricula::latest('protocolo')->first();
            $ultimoNumero = $ultimoProtocolo ? intval(substr($ultimoProtocolo->protocolo, -6)) + 1 : 1;

            // Gere o número do protocolo
            $numeroProtocolo = $anoAtual . str_pad($ultimoNumero, 6, '0', STR_PAD_LEFT);
            $model->protocolo = $numeroProtocolo;

            // Verifica se o campo DATA_INSCRICAO ainda não foi definido
           if (is_null($model->data_inscricao)) {
        // Atribui apenas a data atual (sem hora) ao campo DATA_INSCRICAO
        $model->data_inscricao = Carbon::now()->format('Y-m-d');
    }
        });


    }
protected static function booted()
{
    // Lógica comentada - não está sendo executada
    // static::saving(function ($matricula) {
    //     if ($matricula->data_nascimento) {
    //         $dataNascimento = \Carbon\Carbon::parse($matricula->data_nascimento);
    //
    //         // Ano atual e data de corte
    //         $anoAtual = now()->year;
    //         $dataCorte = \Carbon\Carbon::create($anoAtual, 3, 31);
    //
    //         // Idade na data de corte (usada para todas as turmas, exceto BERÇÁRIO A)
    //         $idadeMesesCorte = $dataNascimento->diffInMonths($dataCorte);
    //         $idadeDiasExtrasCorte = $dataNascimento->copy()->addMonths($idadeMesesCorte)->diffInDays($dataCorte);
    //
    //         // Idade atual (usada somente para BERÇÁRIO A)
    //         $idadeMesesAtual = $dataNascimento->diffInMonths(now());
    //
    //         // BERÇÁRIO A - considera idade atual
    //         if ($idadeMesesAtual >= 6 && ($idadeMesesAtual < 12)) {
    //             $matricula->turma_especie = 'BERÇÁRIO A';
    //
    //         // BERÇÁRIO B - considera data de corte
    //         } elseif ($idadeMesesCorte >= 12 && ($idadeMesesCorte < 24 || ($idadeMesesCorte == 23 && $idadeDiasExtrasCorte <= 29))) {
    //             $matricula->turma_especie = 'BERÇÁRIO B';
    //
    //         // Nível 1 - considera data de corte
    //         } elseif ($idadeMesesCorte >= 24 && ($idadeMesesCorte < 36 || ($idadeMesesCorte == 35 && $idadeDiasExtrasCorte <= 29))) {
    //             $matricula->turma_especie = 'Nível 1';
    //
    //         // Nível 2 - considera data de corte
    //         } elseif ($idadeMesesCorte >= 36 && ($idadeMesesCorte < 48 || ($idadeMesesCorte == 47 && $idadeDiasExtrasCorte <= 29))) {
    //             $matricula->turma_especie = 'Nível 2';
    //
    //         } else {
    //             $matricula->turma_especie = 'Não atribuída';
    //         }
    //
    //     } else {
    //         $matricula->turma_especie = 'Não atribuída';
    //     }
    // });
}



    // static::creating(function ($matricula) {
    //     // Adicione a lógica para encontrar a turma desejada
    //     $idDaTurma = $matricula->TURMA_ID; // Use o campo correto aqui
    //     $turma = Turma::find($idDaTurma);

    //     // Verifique se a turma foi encontrada
    //     if ($turma) {
    //         // Associe a turma à matrícula
    //         $matricula->turma()->associate($turma);
    //         $matricula->save(); // Salva a matrícula após associar a turma
    //     }
    // });


    public function tipo_deficiencia()
    {
        return $this->belongsTo(TipoDeficiencia::class, 'deficiencias_tipo');
    }

    public function distrito()
    {
        return $this->belongsTo(Distrito::class, 'distrito_id');
    }

    public function escolaridade()
    {
        return $this->belongsTo(Escolaridade::class, 'escolaridade_id');
    }

    public function bairro_escola()
    {
        return $this->belongsTo(Bairro::class, 'escola_bairro_id');
    }

    public function escola()
    {
        return $this->belongsTo(Escola::class, 'escola_nome_id', 'id');
    }

    public function turmatipo()
    {
        return $this->BelongsTo(TurmaTipo::class, 'turma_id', 'id');
    }

    public function matricula()
    {
        return $this->hasMany(Matricula::class,'turma_id', 'id');
    }

    public function turma()
    {
        return $this->belongsTo(Turma::class, 'turma_id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function getDataInscricaoFormatadaAttribute()
    {
        return $this->created_at ? $this->created_at->format('d/m/Y') : null;
    }
}
