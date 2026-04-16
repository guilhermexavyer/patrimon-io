<?php

namespace App\Http\Controllers;

use App\Models\Dominio;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class RelatorioDominioController extends Controller
{
    // Método de gerar PDF do relatório
    public function gerarPDF(Request $request)
    {
        $query = Dominio::query();

        if ($request->status) {
            $query->where('ie_status', $request->status);
        }

        if ($request->dt_inicio) {
            $query->whereDate('dt_criacao', '>=', $request->dt_inicio);
        }

        if ($request->dt_fim) {
            $query->whereDate('dt_criacao', '<=', $request->dt_fim);
        }

        if ($request->valor_min) {
            $query->where('vl_aquisicao', '>=', $request->valor_min);
        }

        if ($request->valor_max) {
            $query->where('vl_aquisicao', '<=', $request->valor_max);
        }

        $dominios = $query->orderBy('nr_sequencia')->get();

        $data = [
            'titulo' => 'Relatório de Domínios',
            'data' => now()->format('d/m/Y H:i'),
            'dominios' => $dominios,
        ];

        $pdf = Pdf::loadView('relatorios.dominios-pdf', $data);
        return $pdf->stream('relatorio-dominios.pdf');
    }
}
