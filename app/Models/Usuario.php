<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    public $timestamps = false;

    protected $table = 'usuarios';
    protected $primaryKey = 'nr_sequencia';

    protected $fillable = [
        'ds_nome',
        'ds_usuario',
        'ds_senha',
        'ie_acesso',
        'ds_observacao',
        'ie_status',
        'dt_criacao',
        'dt_atualizacao',
    ];

    protected $hidden = ['ds_senha'];

    protected $dates = ['dt_criacao', 'dt_atualizacao'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->dt_criacao = now();
            $model->dt_atualizacao = now();
        });

        static::updating(function ($model) {
            $model->dt_atualizacao = now();
        });
    }

    public function getAuthPassword()
    {
        return $this->ds_senha;
    }

    public function getAuthIdentifierName()
    {
        return 'ds_usuario';
    }

    protected $casts = [
        'dt_criacao' => 'datetime',
        'dt_atualizacao' => 'datetime',
    ];
}
