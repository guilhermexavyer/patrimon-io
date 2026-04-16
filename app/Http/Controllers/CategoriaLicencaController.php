<?php

namespace App\Http\Controllers;

use App\Models\CategoriaLicenca;
use Illuminate\Http\Request;

class CategoriaLicencaController extends Controller
{
    // Método de listagem
    public function index(Request $request)
    {
        $query = CategoriaLicenca::query();

        if ($request->filled('search')) {
            $term = $request->input('search');
            $query->where(function ($q) use ($term) {
                $q->where('ds_nome', 'LIKE', "%{$term}%");
            });
        }

        // Ordena por número de registro e retorna todos
        $categorias = $query->orderBy('nr_sequencia')->get();

        return view('categorias-licencas.index', compact('categorias'));
    }

    // Método de exibição da tela de cadastro
    public function create()
    {
        return view('categorias-licencas.create');
    }

    // Método de cadastro
    public function store(Request $request)
    {
        $request->validate([
            'ds_nome' => 'required|string|max:255',
            'ie_status' => 'required|in:A,I'
        ]);
        CategoriaLicenca::create($request->all());
        return redirect()->route('categorias-licencas.index')->with('success', 'Categoria de licença cadastrada!');
    }

    // Método de exibição de detalhes
    public function show($id)
    {
        $categoria = CategoriaLicenca::findOrFail($id);
        return view('categorias-licencas.show', compact('categoria'));
    }

    // Método de exibição da tela de atualização
    public function edit($id)
    {
        $categoria = CategoriaLicenca::findOrFail($id);
        return view('categorias-licencas.edit', compact('categoria'));
    }

    // Método de atualização
    public function update(Request $request, $id)
    {
        $categoria = CategoriaLicenca::findOrFail($id);
        $request->validate([
            'ds_nome' => 'required|string|max:255',
            'ie_status' => 'required|in:A,I'
        ]);
        $categoria->update($request->all());
        return redirect()->route('categorias-licencas.index')->with('success', 'Categoria de licença atualizada!');
    }

    // Método de exclusão
    public function destroy($id)
    {
        try {
            CategoriaLicenca::destroy($id);
            return redirect()
                ->route('categorias-licencas.index')
                ->with('success', 'Categoria de licença removida com sucesso!');
        } catch (\Illuminate\Database\QueryException $e) {
            // Verifica se é erro de integridade referencial
            if ($e->getCode() == '23000') {
                return redirect()
                    ->route('categorias-licencas.index')
                    ->with('error', 'Não é possível excluir esta categoria, pois existem licenças vinculados a ela.');
            }

            // Outros erros de banco
            return redirect()
                ->route('categorias-licencas.index')
                ->with('error', 'Erro ao tentar excluir a categoria.');
        }
    }
}
