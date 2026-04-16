<?php

namespace App\Http\Controllers;

use App\Models\Ativo;
use App\Models\CategoriaAtivo;
use App\Models\Fornecedor;
use App\Models\Localizacao;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class RelatorioAtivoController extends Controller
{
    // Método de gerar PDF do relatório
    public function gerarPDF(Request $request)
    {
        $query = Ativo::with(['categoria', 'localizacao', 'fornecedor']);

        if ($request->categoria) {
            $query->where('nr_seq_categoria_ativo', $request->categoria);
        }
        if ($request->fornecedor) {
            $query->where('nr_seq_fornecedor', $request->fornecedor);
        }
        if ($request->status) {
            $query->where('ie_status', $request->status);
        }
        if ($request->localizacao) {
            $query->where('nr_seq_localizacao', $request->localizacao);
        }
        if ($request->valor_min) {
            $query->where('vl_aquisicao', '>=', $request->valor_min);
        }
        if ($request->valor_max) {
            $query->where('vl_aquisicao', '<=', $request->valor_max);
        }

        $ativos = $query->orderBy('nr_sequencia')->get();

        $data = [
            'titulo' => 'Relatório de Ativos',
            'data' => now()->format('d/m/Y H:i'),
            'ativos' => $ativos,
        ];

        $pdf = Pdf::loadView('relatorios.ativos-pdf', $data);
        return $pdf->stream('relatorio-ativos.pdf');
    }
}
