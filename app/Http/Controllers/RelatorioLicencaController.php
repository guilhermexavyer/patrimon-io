<?php

namespace App\Http\Controllers;

use App\Models\Licenca;
use App\Models\CategoriaLicenca;
use App\Models\Fornecedor;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class RelatorioLicencaController extends Controller
{
    // Método de gerar PDF do relatório
    public function gerarPDF(Request $request)
    {
        $query = Licenca::with(['categoria', 'fornecedor']);

        if ($request->status) {
            $query->where('ie_status', $request->status);
        }

        if ($request->categoria) {
            $query->where('nr_seq_categoria_licenca', $request->categoria);
        }

        if ($request->fornecedor) {
            $query->where('nr_seq_fornecedor', $request->fornecedor);
        }

        if ($request->dt_inicio_vigencia && $request->dt_fim_vigencia) {
            $query->whereBetween('dt_inicio_vigencia', [$request->dt_inicio_vigencia, $request->dt_fim_vigencia]);
        }

        if ($request->valor_min) {
            $query->where('vl_aquisicao', '>=', $request->valor_min);
        }

        if ($request->valor_max) {
            $query->where('vl_aquisicao', '<=', $request->valor_max);
        }

        $licencas = $query->orderBy('nr_sequencia')->get();

        // Dados enviados para a view PDF
        $pdf = Pdf::loadView('relatorios.licencas-pdf', [
            'titulo' => 'Relatório de Licenças',
            'data' => now()->format('d/m/Y H:i'),
            'licencas' => $licencas,
        ]);

        return $pdf->stream('relatorio-licencas.pdf');
    }
}
