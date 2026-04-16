<?php

namespace App\Http\Controllers;

use App\Models\Ativo;
use App\Models\CategoriaAtivo;
use App\Models\Fornecedor;
use App\Models\Localizacao;
use Illuminate\Http\Request;

class AtivoController extends Controller
{
    // Método de listagem
    public function index(Request $request)
    {
        $query = Ativo::with(['categoria', 'fornecedor', 'localizacao']);

        if ($request->filled('search')) {
        $term = $request->input('search');
        $query->where(function ($q) use ($term) {
        $q->orWhere('ds_nome', 'LIKE', "%{$term}%")
            ->orWhere('nr_serie', 'LIKE', "%{$term}%")
            ->orWhere('cd_patrimonio', 'LIKE', "%{$term}%");
        });
        }

        $ativos = $query->orderByDesc('nr_sequencia')->get();

        return view('ativos.index', compact('ativos'));
    }

    // Método de exibição da tela de cadastro
    public function create()
    {
        $categorias  = CategoriaAtivo::all();
        $fornecedores = Fornecedor::all();
        $localizacoes = Localizacao::all();

        return view('ativos.form', compact('categorias', 'fornecedores', 'localizacoes'));
    }

    // Método de cadastro
    public function store(Request $request)
    {
        $request->validate([
            'ds_nome'              => 'required|string|max:255',
            'nr_serie'             => 'nullable|string|max:255',
            'cd_patrimonio'        => 'nullable|string|max:10',
            'ds_modelo'            => 'nullable|string|max:255',
            'dt_aquisicao'         => 'nullable|date',
            'dt_fim_garantia' => 'nullable|date',
            'vl_aquisicao'         => 'nullable|numeric|min:0',
            'ds_observacao'        => 'nullable|string|max:500',
            'nr_seq_categoria_ativo' => 'nullable|exists:categoria_ativos,nr_sequencia',
            'nr_seq_fornecedor'    => 'nullable|exists:fornecedores,nr_sequencia',
            'nr_seq_localizacao'   => 'nullable|exists:localizacoes,nr_sequencia',
            'ie_status' => 'required|in:A,I,M,D',
        ]);

        $ativo = Ativo::create($request->all());

        return redirect()
            ->route('ativos.index')
            ->with('success', "Ativo cadastrado com sucesso!");
    }

    // Método de exibição de detalhes
    public function show($id)
    {
        $ativo = Ativo::with(['categoria', 'fornecedor', 'localizacao'])->findOrFail($id);
        return view('ativos.show', compact('ativo'));
    }

    // Método de exibição da tela de atualização
    public function edit($id)
    {
        $ativo = Ativo::findOrFail($id);
        $categorias  = CategoriaAtivo::all();
        $fornecedores = Fornecedor::all();
        $localizacoes = Localizacao::all();

        return view('ativos.form', compact('ativo', 'categorias', 'fornecedores', 'localizacoes'));
    }

    // Método de atualização
    public function update(Request $request, $id)
    {
        $ativo = Ativo::findOrFail($id);

        $request->validate([
            'ds_nome'              => 'required|string|max:255',
            'nr_serie'             => 'nullable|string|max:255',
            'cd_patrimonio'        => 'nullable|string|max:10',
            'ds_modelo'            => 'nullable|string|max:255',
            'dt_aquisicao'         => 'nullable|date',
            'vl_aquisicao'         => 'nullable|numeric|min:0',
            'ds_observacao'        => 'nullable|string|max:500',
            'nr_seq_categoria_ativo' => 'nullable|exists:categoria_ativos,nr_sequencia',
            'nr_seq_fornecedor'    => 'nullable|exists:fornecedores,nr_sequencia',
            'nr_seq_localizacao'   => 'nullable|exists:localizacoes,nr_sequencia',
            'ie_status'            => 'required|in:A,I,M,D',
        ]);

        $ativo->update($request->all());

        return redirect()
            ->route('ativos.index')
            ->with('success', "Ativo atualizado com sucesso!");
    }

    // Método de exclusão
    public function destroy($id)
    {
        try {
            $ativo = Ativo::findOrFail($id);
            $ativo->delete();

            return redirect()
                ->route('ativos.index')
                ->with('success', "Ativo {$ativo->nr_sequencia} excluído com sucesso!");
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == '23000') {
                return redirect()
                    ->route('ativos.index')
                    ->with('error', "Não é possível excluir ativo, pois há registros vinculados a ele.");
            }

            return redirect()
                ->route('ativos.index')
                ->with('error', "Erro ao tentar excluir ativo.");
        } catch (\Exception $e) {
            return redirect()
                ->route('ativos.index')
                ->with('error', "Ocorreu um erro inesperado ao tentar excluir ativo.");
        }
    }
}