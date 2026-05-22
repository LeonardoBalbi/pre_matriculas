<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EscolaTurma extends Model
{
    protected $table = 'escola_turma';
    protected $fillable = [
        'escola_id',
        'turma_id',
    ];

    public function escola()
    {
        return $this->belongsTo(Escola::class, 'escola_id');
    }

    public function turma()
    {
        return $this->belongsTo(Turma::class, 'turma_id');
    }
}
