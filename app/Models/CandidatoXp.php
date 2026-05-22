<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CandidatoXp extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_candidato',
        'id_vagas_xp',
        'id_vagas_xp_plus',
    ];



    public function candidato()
    {
        return $this->belongsTo(Candidato::class, 'id_candidato');
    }

    public function vagasXp()
    {
        return $this->belongsTo(VagasXp::class,'id_vagas_xp');
    }

    public function vagasXpPlus()
    {
        return $this->belongsTo(VagasXpPlus::class, 'id_vagas_xp_plus');
    }



}
