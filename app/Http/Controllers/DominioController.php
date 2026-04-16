<?php

namespace App\Http\Controllers;

use App\Models\Dominio;
use Illuminate\Http\Request;

class DominioController extends Controller
{
    // Método de listagem
    public function index(Request $request)
    {
        $query = Dominio::query();

        if ($request->filled('search')) {
            $term = $request->input('search');
            $query->where(function ($q) use ($term) {
                $q->orwhere('ds_nome', 'LIKE', "%{$term}%")
                ->orWhere('ds_url', 'LIKE', "%{$term}%")
                ->orWhere('nr_registro', 'LIKE', "%{$term}%");
            });
        }

        $dominios = $query->orderBy('nr_sequencia')->get();

        return view('dominios.index', compact('dominios'));
    }

    // Método de exibição da tela de cadastro
    public function create()
    {
        return view('dominios.create');
    }

    // Método de cadastro
    public function store(Request $request)
    {
        $request->validate([
            'ds_nome' => 'required|string|max:255',
            'ds_url' => 'required|string|max:500',
            'ie_status' => 'required|in:A,I,E'
        ]);
        Dominio::create($request->all());
        return redirect()->route('dominios.index')->with('success', 'Domínio cadastrado!');
    }

    // Método de exibição de detalhes
    public function show($id)
    {
        $dominio = Dominio::findOrFail($id);
        return view('dominios.show', compact('dominio'));
    }

    // Método de exibição da tela de atualização
    public function edit($id)
    {
        $dominio = Dominio::findOrFail($id);
        return view('dominios.edit', compact('dominio'));
    }

    // Método de atualização
    public function update(Request $request, $id)
    {
        $dominio = Dominio::findOrFail($id);
        $request->validate([
            'ds_nome' => 'required|string|max:255',
            'ds_url' => 'required|string|max:500',
            'ie_status' => 'required|in:A,I,E'
        ]);
        $dominio->update($request->all());
        return redirect()->route('dominios.index')->with('success', 'Domínio atualizado!');
    }

    // Método de exclusão
    public function destroy($id)
    {
        Dominio::destroy($id);
        return redirect()->route('dominios.index')->with('success', 'Domínio removido!');
    }
}
