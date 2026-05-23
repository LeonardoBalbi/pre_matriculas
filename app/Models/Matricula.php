<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

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
        'turma',
        'situacao_matricula',
        'observacao',
        'idade_corte_meses',
        'idade_data_corte',
        'idade_data_corte_mes',
        'idade_data_corte_dias',
        'escola_nome_id',
        'escola_nome',
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
        'turma_especie',
    ];

    protected $casts = [
        'data_nascimento'        => 'date',
        'data_nasc_responsavel'  => 'date',
        'data_inscricao'         => 'date',
        'data_reat_inscricao'    => 'date',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $anoAtual = now()->year;

            $ultimoProtocolo = Matricula::orderByDesc('id')->first();
            $ultimoNumero = $ultimoProtocolo
                ? intval(substr($ultimoProtocolo->protocolo, -6)) + 1
                : 1;

            $model->protocolo = $anoAtual . str_pad($ultimoNumero, 6, '0', STR_PAD_LEFT);

            if (is_null($model->data_inscricao)) {
                $model->data_inscricao = Carbon::now()->format('Y-m-d');
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | RELACIONAMENTOS
    |--------------------------------------------------------------------------
    */
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
        return $this->belongsTo(Escola::class, 'escola_nome_id');
    }

    public function turma()
    {
        return $this->belongsTo(Turma::class, 'turma_id');
    }

    public function turmatipo()
    {
        return $this->belongsTo(TurmaTipo::class, 'turma_id', 'id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function statusMatricula()
    {
        return $this->belongsTo(StatusMatricula::class, 'situacao_matricula');
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */
    public function getDataInscricaoAlunoAttribute()
    {
        return $this->created_at ? $this->created_at->format('d/m/Y') : null;
    }

    public function getDataNascimentoAlunoAttribute()
    {
        return $this->data_nascimento ? Carbon::parse($this->data_nascimento)->format('d/m/Y') : null;
    }

    public function getHoraInscricaoAttribute()
    {
        return $this->created_at ? $this->created_at->format('H:i') : null;
    }

    public function getSituacaoMatriculaNomeAttribute()
    {
        if (!$this->situacao_matricula) {
            return null;
        }

        return $this->statusMatricula?->status_matricula
            ?? StatusMatricula::whereKey($this->situacao_matricula)->value('status_matricula');
    }

    public function getEscolaNomeDisplayAttribute()
    {
        if (!$this->escola_nome_id) {
            return null;
        }

        return $this->escola?->escola_nome
            ?? Escola::whereKey($this->escola_nome_id)->value('escola_nome');
    }

    public function getTurmaNomeDisplayAttribute()
    {
        if (!$this->turma_id) {
            return null;
        }

        return $this->turma?->turma_descricao
            ?? Turma::whereKey($this->turma_id)->value('turma_descricao');
    }

    public function getCelResponsavelAttribute()
    {
        if (!$this->tel_cel_responsavel) {
            return null;
        }

        $numero = preg_replace('/\D/', '', $this->tel_cel_responsavel);

        if (strlen($numero) === 11) {
            return sprintf('(%s) %s-%s',
                substr($numero, 0, 2),
                substr($numero, 2, 5),
                substr($numero, 7, 4)
            );
        }

        if (strlen($numero) === 10) {
            return sprintf('(%s) %s-%s',
                substr($numero, 0, 2),
                substr($numero, 2, 4),
                substr($numero, 6, 4)
            );
        }

        return $this->tel_cel_responsavel;
    }
}
