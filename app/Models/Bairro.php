<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bairro extends Model
{
    use HasFactory;

    protected $fillable = [
        'escola_bairro_id',
        'descricao',
        'distrito_id'
    ];
    

    public function bairro()
    {
        return $this->belongsTo(Bairro::class);
    }

    public function distrito()
    {
        return $this->belongsTo(Distrito::class);
    }

}
