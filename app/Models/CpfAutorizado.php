<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CpfAutorizado extends Model
{
    protected $table = 'cpf_autorizados';

    protected $fillable = ['cpf', 'motivo', 'user_id'];

    protected static function boot()
    {
        parent::boot();
        
        // Salva quem criou e limpa o CPF automaticamente
        static::creating(function ($model) {
            if (auth()->check()) {
                $model->user_id = auth()->id();
            }
            $model->cpf = preg_replace('/\D+/', '', $model->cpf);
        });
        
        static::updating(function ($model) {
             $model->cpf = preg_replace('/\D+/', '', $model->cpf);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
