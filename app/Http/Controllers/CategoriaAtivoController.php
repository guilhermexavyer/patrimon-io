<?php

namespace App\Http\Controllers;

use App\Models\CategoriaAtivo;
use Illuminate\Http\Request;

class CategoriaAtivoController extends Controller
{
    // Método de listagem
    public function index(Request $request)
    {
        $query = CategoriaAtivo::query();

        if ($request->filled('search')) {
            $term = $request->input('search');
            $query->where(function ($q) use ($term) {
                $q->where('ds_nome', 'LIKE', "%{$term}%");
            });
        }

        $categorias = $query->orderBy('nr_sequencia')->get();

        return view('categorias-ativos.index', compact('categorias'));
    }

    // Método de exibição da tela de cadastro
    public function create()
    {
        return view('categorias-ativos.create');
    }

    // Método de cadastro
    public function store(Request $request)
    {
        $request->validate([
            'ds_nome' => 'required|string|max:255',
            'ie_status' => 'required|in:A,I'
        ]);
        CategoriaAtivo::create($request->all());
        return redirect()->route('categorias-ativos.index')->with('success', 'Categoria de ativo cadastrada!');
    }

    // Método de exibição de detalhes
    public function show($id)
    {
        $categoria = CategoriaAtivo::findOrFail($id);
        return view('categorias-ativos.show', compact('categoria'));
    }

    // Método de exibição da tela de atualização
    public function edit($id)
    {
        $categoria = CategoriaAtivo::findOrFail($id);
        return view('categorias-ativos.edit', compact('categoria'));
    }

    // Método de atualização
    public function update(Request $request, $id)
    {
        $categoria = CategoriaAtivo::findOrFail($id);
        $request->validate([
            'ds_nome' => 'required|string|max:255',
            'ie_status' => 'required|in:A,I'
        ]);
        $categoria->update($request->all());
        return redirect()->route('categorias-ativos.index')->with('success', 'Categoria de ativo atualizada!');
    }

    // Método de exclusão
    public function destroy($id)
    {
        try {
            CategoriaAtivo::destroy($id);
            return redirect()
                ->route('categorias-ativos.index')
                ->with('success', 'Categoria de ativo removida com sucesso!');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == '23000') {
                return redirect()
                    ->route('categorias-ativos.index')
                    ->with('error', 'Não é possível excluir esta categoria, pois existem ativos vinculados a ela.');
            }
            return redirect()
                ->route('categorias-ativos.index')
                ->with('error', 'Erro ao tentar excluir a categoria.');
        }
    }
}
