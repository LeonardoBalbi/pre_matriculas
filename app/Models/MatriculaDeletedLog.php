<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatriculaDeletedLog extends Model
{
    use HasFactory;

    protected $table = 'matriculas_deleted_log';

    protected $fillable = [
        'matricula_id',
        'deleted_by',
        'deleted_by_name',
        'motivo_exclusao',
        'dados_matricula'
    ];

    protected $casts = [
        'dados_matricula' => 'array',
    ];

    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }
}
