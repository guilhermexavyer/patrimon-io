<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriaLicenca extends Model
{
    protected $table = 'categoria_licencas';
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

    public function licencas()
    {
        return $this->hasMany(Licenca::class, 'nr_seq_categoria_licenca', 'nr_sequencia');
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
