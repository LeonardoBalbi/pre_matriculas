<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EscolaTurmaTipo extends Model
{
    protected $table = 'escola_turma_tipo';
    protected $fillable = [
        'escola_id',
        'turma_tipo_id',
    ];

    public function escola()
    {
        return $this->belongsTo(Escola::class, 'escola_id');
    }

    public function turmaTipo()
    {
        return $this->belongsTo(TurmaTipo::class, 'turma_tipo_id');
    }

    // Accessor para exibir o nome da escola
    public function getEscolaNomeAttribute()
    {
        return $this->escola ? $this->escola->escola_nome : null;
    }

    // Accessor para exibir a descrição do tipo de turma
    public function getTipoDescricaoAttribute()
    {
        return $this->turmaTipo ? $this->turmaTipo->tipo_descricao : null;
    }
}
