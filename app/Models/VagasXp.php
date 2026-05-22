<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Vagas;

class VagasXp extends Model
{
    use HasFactory;

    public $filable = [
        'id_vagas',
        'titulo',
    ];

   public function vagas()
   {
       return $this->belongsTo(Vagas::class, 'id_vagas');
   }

    public function vagasxpplus()
    {
         return $this->hasMany(VagasXpPlus::class, 'id_vagas_xps', 'id');
    }

    public function candidatoXp()
    {
        return $this->hasOne(CandidatoXp::class);
    }

    // public function vagasXpPlus()
    // {
    //     return $this->hasOne(VagasXpPlus::class);
    // }


}
