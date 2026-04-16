<?php

namespace App\Http\Controllers;

use App\Models\Localizacao;
use Illuminate\Http\Request;

class LocalizacaoController extends Controller
{
    // Método de listagem
    public function index(Request $request)
    {
        $query = Localizacao::query();

        if ($request->filled('search')) {
            $term = $request->input('search');
            $query->where(function ($q) use ($term) {
                $q->where('ds_nome', 'LIKE', "%{$term}%");
            });
        }

        $localizacoes = $query->orderBy('nr_sequencia')->get();

        return view('localizacoes.index', compact('localizacoes'));
    }

    // Método de exibição da tela de cadastro
    public function create()
    {
        return view('localizacoes.create');
    }

    // Método de cadastro
    public function store(Request $request)
    {
        $request->validate([
            'ds_nome' => 'required|string|max:255',
            'ie_status' => 'required|in:A,I'
        ]);
        Localizacao::create($request->all());
        return redirect()->route('localizacoes.index')->with('success', 'Localização cadastrada!');
    }

    // Método de exibição de detalhes
    public function show($id)
    {
        $localizacao = Localizacao::findOrFail($id);
        return view('localizacoes.show', compact('localizacao'));
    }

    // Método de exibição da tela de atualização
    public function edit($id)
    {
        $localizacao = Localizacao::findOrFail($id);
        return view('localizacoes.edit', compact('localizacao'));
    }

    // Método de atualização
    public function update(Request $request, $id)
    {
        $localizacao = Localizacao::findOrFail($id);
        $request->validate([
            'ds_nome' => 'required|string|max:255',
            'ie_status' => 'required|in:A,I'
        ]);
        $localizacao->update($request->all());
        return redirect()->route('localizacoes.index')->with('success', 'Localização atualizada!');
    }

    // Método de exclusão
    public function destroy($id)
    {
        try {
            Localizacao::destroy($id);
            return redirect()
                ->route('localizacoes.index')
                ->with('success', 'Localização removida com sucesso!');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == '23000') {
                return redirect()
                    ->route('localizacoes.index')
                    ->with('error', 'Não é possível excluir esta localização, pois existem ativos vinculados a ela.');
            }
            return redirect()
                ->route('localizacoes.index')
                ->with('error', 'Erro ao tentar excluir a categoria.');
        }
    }
}
