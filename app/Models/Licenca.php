<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Licenca extends Model
{
    protected $table = 'licencas';
    protected $primaryKey = 'nr_sequencia';
    public $timestamps = false;

    protected $fillable = [
        'ds_nome',
        'nr_registro',
        'dt_aquisicao',
        'dt_inicio_vigencia',
        'dt_fim_vigencia',
        'vl_aquisicao',
        'vl_mensal',
        'ds_observacao',
        'ie_status',
        'dt_criacao',
        'dt_atualizacao',
        'nr_seq_categoria_licenca',
        'nr_seq_fornecedor',
    ];

    protected $casts = [
        'dt_criacao'          => 'datetime',
        'dt_atualizacao'      => 'datetime',
        'dt_aquisicao'        => 'date',
        'dt_inicio_vigencia'  => 'date',
        'dt_fim_vigencia'     => 'date',
        'vl_aquisicao'        => 'float',
        'vl_mensal'           => 'float',
    ];

    public function categoria()
    {
        return $this->belongsTo(CategoriaLicenca::class, 'nr_seq_categoria_licenca', 'nr_sequencia');
    }

    public function fornecedor()
    {
        return $this->belongsTo(Fornecedor::class, 'nr_seq_fornecedor', 'nr_sequencia');
    }

    protected static function boot()
    {
        parent::boot();

        // Ao criar
        static::creating(function ($model) {
            $model->dt_criacao = now();
            $model->dt_atualizacao = now();
            $model->atualizarStatusAutomaticamente();
        });

        // Ao atualizar
        static::updating(function ($model) {
            $model->dt_atualizacao = now();
            $model->atualizarStatusAutomaticamente();
        });
    }

    protected function atualizarStatusAutomaticamente()
    {
        if ($this->dt_fim_vigencia) {
            if ($this->dt_fim_vigencia < now()) {
                $this->ie_status = 'E'; // Expirada
            } else {
                $this->ie_status = 'A'; // Ativa
            }
        }
    }
}
