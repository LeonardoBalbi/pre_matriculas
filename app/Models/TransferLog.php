<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransferLog extends Model
{
    protected $fillable = [
        'matricula_id',
        'from_escola_id',
        'to_escola_id',
        'action',
        'by_user_id',
        'reason',
    ];
}
