<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Manutencao;
use PDF;

class RelatorioManutencaoController extends Controller
{
    // Método de gerar PDF do relatório
    public function pdf(Request $request)
    {
        $query = Manutencao::with(['ativo', 'prestadorServico']);

        if ($request->filled('ativo')) {
            $query->where('nr_seq_ativo', $request->ativo);
        }

        if ($request->filled('prestador')) {
            $query->where('nr_seq_prestador_servico', $request->prestador);
        }

        if ($request->filled('status')) {
        $query->where('ie_status', $request->status);
        }

        if ($request->filled('tipo')) {
        $query->where('ie_tipo', $request->tipo);
        }

        if ($request->filled('dt_inicio')) {
        $query->whereDate('dt_envio', '>=', $request->dt_inicio);
        }

        if ($request->filled('dt_fim')) {
        $query->whereDate('dt_envio', '<=', $request->dt_fim);
        }

        if ($request->filled('vl_min')) {
        $query->where('vl_final', '>=', floatval(str_replace(',', '.', $request->vl_min)));
        }

        if ($request->filled('vl_max')) {
        $query->where('vl_final', '<=', floatval(str_replace(',', '.', $request->vl_max)));
        }

        $manutencoes = $query->orderByDesc('nr_sequencia')->get();

        $pdf = PDF::loadView('relatorios.manutencoes-pdf', compact('manutencoes'))
                ->setPaper('a4', 'portrait');

        return $pdf->stream('relatorio-manutencoes.pdf');
    }
}
