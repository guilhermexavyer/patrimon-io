<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Manutencao extends Model
{
    use HasFactory;

    protected $table = 'manutencoes';
    protected $primaryKey = 'nr_sequencia';
    public $timestamps = false;

    protected $fillable = [
        'ie_tipo',
        'ds_descricao',
        'dt_envio',
        'dt_retorno',
        'vl_final',
        'ds_observacao',
        'ie_status',
        'dt_criacao',
        'dt_atualizacao',
        'nr_seq_ativo',
        'nr_seq_prestador_servico',
    ];

    
    protected $attributes = [
        'ie_status' => 'E', // E = Em curso, C = Concluída
    ];

    protected $casts = [
        'dt_envio'       => 'date',
        'dt_retorno'     => 'date',
        'dt_criacao'     => 'datetime',
        'dt_atualizacao' => 'datetime',
        'vl_final'       => 'float',
    ];


    public function ativo()
    {
        return $this->belongsTo(Ativo::class, 'nr_seq_ativo', 'nr_sequencia');
    }

    public function prestadorServico()
    {
        return $this->belongsTo(PrestadorServico::class, 'nr_seq_prestador_servico', 'nr_sequencia');
    }

    // Alias opcional — permite acessar $manutencao->prestador
    public function prestador()
    {
        return $this->prestadorServico();
    }

    public function getTipoTextoAttribute()
    {
        return match ($this->ie_tipo) {
            'C' => 'Corretiva',
            'P' => 'Preventiva',
            default => '—',
        };
    }

    public function getStatusTextoAttribute()
    {
        return match ($this->ie_status) {
            'E' => 'Em curso',
            'C' => 'Concluída',
            default => '—',
        };
    }

    public function getStatusCorAttribute()
    {
        return $this->ie_status === 'C' ? 'status-concluida' : 'status-emcurso';
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $agora = now();
            $model->dt_criacao = $agora;
            $model->dt_atualizacao = $agora;

            // Garante que toda nova manutenção comece "Em curso"
            if (empty($model->ie_status)) {
                $model->ie_status = 'E';
            }
        });

        static::updating(function ($model) {
            $model->dt_atualizacao = now();
        });
    }
}
