<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vagas extends Model
{
    use HasFactory;

    protected $fillable = [
        'num_edital',
        'titulo',
        'vaga_ac',
        'vaga_pcd',
        'vaga_negro',
        'vaga_indios',
        'status'
    ];

    public function vagasxp(){
        return $this->hasMany(VagasXp::class, 'id_vagas', 'id');
    }
}
