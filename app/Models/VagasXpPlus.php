<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VagasXpPlus extends Model
{
    use HasFactory;

    public $filable = [
        'id_vagas_xps',
        'titulo',
        'pontos',
    ];
    
    
    public function vagas()
    {
        return $this->belongsTo(Vagas::class, 'id_vagas');
    }
    
    // public function vagasxp()
    // {
    //     return $this->belongsTo(VagasXp::class, 'id_vagas_xps', 'id' );
    // }

    // public function vagasXp()
    // {
    //     return $this->belongsTo(VagasXp::class, 'id_vagas_xps', 'id' );
    // }


    public function candidato()
    {
        return $this->belongsTo(Candidato::class, 'id_candidato');
    }

    public function vagasXp()
    {
        return $this->belongsTo(VagasXp::class, 'id_vagas_xps','id');
    }

    public function vagasXpPlus()
    {
        return $this->belongsTo(VagasXpPlus::class, 'id_vagas_xp_plus', 'id');
    }
}
