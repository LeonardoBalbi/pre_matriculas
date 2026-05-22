<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classificado extends Model
{
    use HasFactory;
    protected $table = 'classificados';
    protected $fillable = [
        'titulo',
        'descricao',
    ];
}
