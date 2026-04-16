<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ativo;
use App\Models\Licenca;
use App\Models\Fornecedor;
use App\Models\Dominio;
use App\Models\Manutencao;
use App\Models\CategoriaAtivo;
use App\Models\Localizacao;

class RelatorioController extends Controller
{
    public function index()
    {
        $categorias = CategoriaAtivo::where('ie_status', 'A')->orderBy('ds_nome')->get();
        $localizacoes = Localizacao::where('ie_status', 'A')->orderBy('ds_nome')->get();
        $fornecedores = Fornecedor::where('ie_status', 'A')->orderBy('nr_sequencia')->get();

        return view('relatorios.index', compact('categorias', 'localizacoes', 'fornecedores'));
    }

    public function buscar(Request $request)
    {
        $tipo = $request->input('tipo');
        $dt_inicio = $request->input('dt_inicio');
        $dt_fim = $request->input('dt_fim');
        $registros = [];

        switch ($tipo) {
            case 'ativos':
                $registros = Ativo::whereBetween('dt_criacao', [$dt_inicio, $dt_fim])->get();
                break;
            case 'licencas':
                $registros = Licenca::whereBetween('dt_criacao', [$dt_inicio, $dt_fim])->get();
                break;
            case 'dominios':
                $registros = Dominio::whereBetween('dt_criacao', [$dt_inicio, $dt_fim])->get();
                break;
            case 'manutencoes':
                $registros = Manutencao::whereBetween('dt_criacao', [$dt_inicio, $dt_fim])->get();
                break;
        }

        return view('relatorios.resultado', compact('registros', 'tipo', 'dt_inicio', 'dt_fim'));
    }
}
