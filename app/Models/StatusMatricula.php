<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusMatricula extends Model
{
    use HasFactory;
    protected $table = 'status_matriculas';
    protected $fillable = [
        'situacao_matricula',

        'color'
    ];




}
