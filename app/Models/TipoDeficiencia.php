<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoDeficiencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo_deficiencia',
    ];

    
}
