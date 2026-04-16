<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dominio extends Model
{
    protected $table = 'dominios';
    protected $primaryKey = 'nr_sequencia';
    public $timestamps = false;

    protected $fillable = [
        'ds_nome',
        'ds_url',
        'nr_registro',
        'nr_ip',
        'nr_dns_primario',
        'nr_dns_secundario',
        'dt_aquisicao',
        'dt_inicio_vigencia',
        'dt_fim_vigencia',
        'vl_aquisicao',
        'vl_mensal',
        'ds_observacao',
        'ie_status',
        'dt_criacao',
        'dt_atualizacao',
    ];

    protected $casts = [
        'dt_criacao'          => 'datetime',
        'dt_atualizacao'      => 'datetime',
        'dt_aquisicao'        => 'date',
        'dt_inicio_vigencia'  => 'date',
        'dt_fim_vigencia'     => 'date',
        'nr_ip'               => 'string',
        'nr_dns_primario'     => 'string',
        'nr_dns_secundario'   => 'string',
        'ie_status'           => 'string',
        'vl_aquisicao'        => 'float',
        'vl_mensal'           => 'float',
    ];

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
                $this->ie_status = 'E'; // Expirado
            } else {
                $this->ie_status = 'A'; // Ativo
            }
        }
    }
}
