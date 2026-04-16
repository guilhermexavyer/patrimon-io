<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ativo extends Model
{
    protected $table = 'ativos';
    protected $primaryKey = 'nr_sequencia';
    public $timestamps = false;

    protected $fillable = [
        'ds_nome',
        'nr_serie',
        'cd_patrimonio',
        'ds_modelo',
        'dt_aquisicao',
        'dt_fim_garantia',
        'vl_aquisicao',
        'ds_observacao',
        'ie_status',
        'dt_criacao',
        'dt_atualizacao',
        'nr_seq_categoria_ativo',
        'nr_seq_fornecedor',
        'nr_seq_localizacao',
    ];


    protected $casts = [
        'dt_criacao'     => 'datetime',
        'dt_atualizacao' => 'datetime',
        'dt_aquisicao'   => 'date',
        'dt_fim_garantia'=> 'date',
        'vl_aquisicao'   => 'float',
    ];

    public function categoria()
    {
        return $this->belongsTo(CategoriaAtivo::class, 'nr_seq_categoria_ativo', 'nr_sequencia');
    }

    public function fornecedor()
    {
        return $this->belongsTo(Fornecedor::class, 'nr_seq_fornecedor', 'nr_sequencia');
    }

    public function localizacao()
    {
        return $this->belongsTo(Localizacao::class, 'nr_seq_localizacao', 'nr_sequencia');
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

    protected static function booted()
    {
        static::updating(function ($ativo) {
            $statusOriginal = $ativo->getOriginal('ie_status');

            if ($statusOriginal === 'M' && $ativo->ie_status !== 'M') {
                $ativo->ie_status = 'M';
            }
        });
    }
}
