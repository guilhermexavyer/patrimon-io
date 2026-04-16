<?php

namespace App\Http\Controllers;

use App\Models\Fornecedor;
use Illuminate\Http\Request;

class FornecedorController extends Controller
{
    // Método de listagem
    public function index(Request $request)
    {
        $query = Fornecedor::query();

        if ($request->filled('search')) {
            $term = $request->input('search');
            $query->where(function ($q) use ($term) {
                $q->where('ds_nome', 'LIKE', "%{$term}%")
                  ->orWhere('ds_razao_social', 'LIKE', "%{$term}%")
                  ->orWhere('nm_fantasia', 'LIKE', "%{$term}%")
                  ->orWhere('cpf', 'LIKE', "%{$term}%")
                  ->orWhere('cnpj', 'LIKE', "%{$term}%");
            });
        }

        $fornecedores = $query->orderBy('nr_sequencia')->get();

        return view('fornecedores.index', compact('fornecedores'));
    }

    // Método de exibição da tela de cadastro
    public function create()
    {
        return view('fornecedores.create');
    }

    // Método de cadastro
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ie_tipo'         => 'required|in:PF,PJ',
            'ds_nome'         => 'nullable|string|max:255',
            'ds_razao_social' => 'nullable|string|max:255',
            'nm_fantasia'     => 'nullable|string|max:255',
            'cpf'             => 'nullable|string|max:25',
            'cnpj'            => 'nullable|string|max:25',
            'nr_telefone'     => 'nullable|string|max:255',
            'ds_email'        => 'nullable|email|max:255',
            'ds_endereco'     => 'nullable|string|max:255',
            'ds_observacao'   => 'nullable|string',
            'ie_status'       => 'required|in:A,I',
        ]);

        Fornecedor::create($validated);

        return redirect()
            ->route('fornecedores.index')
            ->with('success', 'Fornecedor cadastrado com sucesso!');
    }

    // Método de exibição da tela de atualização
    public function edit($id)
    {
        $fornecedor = Fornecedor::findOrFail($id);
        return view('fornecedores.edit', compact('fornecedor'));
    }

    // Método de atualização
    public function update(Request $request, $id)
    {
        $fornecedor = Fornecedor::findOrFail($id);

        $validated = $request->validate([
            'ie_tipo'         => 'required|in:PF,PJ',
            'ds_nome'         => 'nullable|string|max:255',
            'ds_razao_social' => 'nullable|string|max:255',
            'nm_fantasia'     => 'nullable|string|max:255',
            'cpf'             => 'nullable|string|max:25',
            'cnpj'            => 'nullable|string|max:25',
            'nr_telefone'     => 'nullable|string|max:255',
            'ds_email'        => 'nullable|email|max:255',
            'ds_endereco'     => 'nullable|string|max:255',
            'ds_observacao'   => 'nullable|string',
            'ie_status'       => 'required|in:A,I',
        ]);

        $fornecedor->update($validated);

        return redirect()
            ->route('fornecedores.index')
            ->with('success', 'Fornecedor atualizado com sucesso!');
    }

    // Método de exclusão
    public function destroy($id)
    {
        try {
            $fornecedor = Fornecedor::findOrFail($id);
            $fornecedor->delete();

            return redirect()
                ->route('fornecedores.index')
                ->with('success', 'Fornecedor removido com sucesso!');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == '23000') {
                return redirect()
                    ->route('fornecedores.index')
                    ->with('error', "Não é possível excluir este fornecedor, pois há registros vinculados a ele.");
            }

            return redirect()
                ->route('fornecedores.index')
                ->with('error', "Erro ao tentar excluir o fornecedor.");
        } catch (\Exception $e) {
            return redirect()
                ->route('fornecedores.index')
                ->with('error', "Ocorreu um erro inesperado ao tentar excluir o fornecedor.");
        }
    }
}
