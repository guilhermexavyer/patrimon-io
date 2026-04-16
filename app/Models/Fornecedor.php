<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{
    protected $table = 'fornecedores';
    protected $primaryKey = 'nr_sequencia';
    public $timestamps = false;

    protected $fillable = [
        'ie_tipo',
        'ds_nome',
        'ds_razao_social',
        'nm_fantasia',
        'cpf',
        'cnpj',
        'nr_telefone',
        'ds_email',
        'ds_endereco',
        'ds_observacao',
        'ie_status',
        'dt_criacao',
        'dt_atualizacao',
    ];

    protected $casts = [
        'dt_criacao'     => 'datetime',
        'dt_atualizacao' => 'datetime',
    ];

    public function licencas()
    {
        return $this->hasMany(Licenca::class, 'nr_seq_fornecedor', 'nr_sequencia');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->dt_criacao)) {
                $model->dt_criacao = now();
            }
            $model->dt_atualizacao = now();
        });

        static::updating(function ($model) {
            $model->dt_atualizacao = now();
        });
    }
}
