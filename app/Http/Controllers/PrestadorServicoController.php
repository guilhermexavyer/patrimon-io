<?php

namespace App\Http\Controllers;

use App\Models\PrestadorServico;
use Illuminate\Http\Request;

class PrestadorServicoController extends Controller
{
    // Método de listagem
    public function index(Request $request)
    {
        $query = PrestadorServico::query();

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

        $prestadores = $query->orderBy('nr_sequencia')->get();

        return view('prestadores-servico.index', compact('prestadores'));
    }

    // Método de exibição da tela de cadastro
    public function create()
    {
        return view('prestadores-servico.create');
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

        PrestadorServico::create($validated);

        return redirect()
            ->route('prestadores-servico.index')
            ->with('success', 'Prestador de serviço cadastrado com sucesso!');
    }

    // Método de exibição da tela de atualização
    public function edit($id)
    {
        $prestador = PrestadorServico::findOrFail($id);
        return view('prestadores-servico.edit', compact('prestador'));
    }

    // Método de atualização
    public function update(Request $request, $id)
    {
        $prestador = PrestadorServico::findOrFail($id);

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

        $prestador->update($validated);

        return redirect()
            ->route('prestadores-servico.index')
            ->with('success', 'Prestador de serviço atualizado com sucesso!');
    }

    // Método de exclusão
    public function destroy($id)
    {
        try {
            $prestador = PrestadorServico::findOrFail($id);
            $prestador->delete();

            return redirect()
                ->route('prestadores-servico.index')
                ->with('success', 'Prestador de serviço removido com sucesso!');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == '23000') {
                return redirect()
                    ->route('prestadores-servico.index')
                    ->with('error', "Não é possível excluir este prestador de serviço, pois há registros vinculados a ele.");
            }
            return redirect()
                ->route('prestadores-servico.index')
                ->with('error', "Erro ao tentar excluir o prestador de serviço.");
        } catch (\Exception $e) {
            return redirect()
                ->route('prestadores-servico.index')
                ->with('error', "Ocorreu um erro inesperado ao tentar excluir o prestador de serviço.");
        }
    }

}
