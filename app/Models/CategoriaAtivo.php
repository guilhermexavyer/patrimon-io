<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriaAtivo extends Model
{
    protected $table = 'categoria_ativos';
    protected $primaryKey = 'nr_sequencia';
    public $timestamps = false;

    protected $fillable = [
        'ds_nome',
        'ds_observacao',
        'ie_status',
        'dt_criacao',
        'dt_atualizacao',
    ];

    protected $casts = [
        'dt_criacao'    => 'datetime',
        'dt_atualizacao'=> 'datetime',
        'ie_status'     => 'string',
    ];

    public function ativos()
    {
        return $this->hasMany(Ativo::class, 'nr_seq_categoria_ativo', 'nr_sequencia');
    }

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
}
