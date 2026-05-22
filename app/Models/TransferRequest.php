<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransferRequest extends Model
{
    protected $fillable = [
        'matricula_id',
        'from_escola_id',
        'to_escola_id',
        'requested_by',
        'authorized_by',
        'status',
        'reason',
        'authorized_at',
    ];

    public function matricula()
    {
        return $this->belongsTo(Matricula::class);
    }

    public function fromEscola()
    {
        return $this->belongsTo(Escola::class, 'from_escola_id');
    }

    public function toEscola()
    {
        return $this->belongsTo(Escola::class, 'to_escola_id');
    }

    public function requester()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function authorizer()
    {
        return $this->belongsTo(User::class, 'authorized_by');
    }
}
