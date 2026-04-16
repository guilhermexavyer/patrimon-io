<?php

namespace App\Http\Controllers;

use App\Models\Licenca;
use App\Models\Fornecedor;
use App\Models\CategoriaLicenca;
use Illuminate\Http\Request;

class LicencaController extends Controller
{
    // Método de listagem
    public function index(Request $request)
    {
        $query = Licenca::with('categoria'); // já carrega o relacionamento

        if ($request->filled('search')) {
            $term = $request->input('search');
            $query->where(function ($q) use ($term) {
                $q->where('ds_nome', 'LIKE', "%{$term}%")
                  ->orWhere('nr_registro', 'LIKE', "%{$term}%");
            });
        }

        $licencas = $query->orderBy('nr_sequencia')->get();

        return view('licencas.index', compact('licencas'));
    }

    // Método de exibição da tela de cadastro
    public function create()
    {
        $categorias = CategoriaLicenca::where('ie_status', 'A')->orderBy('ds_nome')->get();
        $fornecedores = Fornecedor::where('ie_status', 'A')->orderBy('ds_nome')->get();

        return view('licencas.form', compact('categorias', 'fornecedores'));
    }

    // Método de cadastro
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ds_nome' => 'required|string|max:255',
            'ie_status' => 'required|in:A,I,E',
            'nr_seq_categoria_licenca' => 'required|exists:categoria_licencas,nr_sequencia',
            'nr_seq_fornecedor' => 'required|exists:fornecedores,nr_sequencia',
            'ds_observacao' => 'nullable|string',
            'nr_registro' => 'nullable|integer',
            'dt_aquisicao' => 'nullable|date',
            'dt_inicio_vigencia' => 'nullable|date',
            'dt_fim_vigencia' => 'nullable|date',
            'vl_aquisicao' => 'nullable|numeric',
            'vl_mensal' => 'nullable|numeric',
        ]);

        Licenca::create($validated);

        return redirect()
            ->route('licencas.index')
            ->with('success', 'Licença cadastrada com sucesso!');
    }

    // Método de exibição de detalhes
    public function show($id)
    {
        $licenca = Licenca::with('categoria')->findOrFail($id);
        return view('licencas.show', compact('licenca'));
    }

    // Método de exibição da tela de atualização
    public function edit($id)
    {
        $licenca = Licenca::findOrFail($id);
        $categorias = CategoriaLicenca::where('ie_status', 'A')->orderBy('ds_nome')->get();
        $fornecedores = Fornecedor::where('ie_status', 'A')->orderBy('ds_nome')->get();

        return view('licencas.form', compact('licenca', 'categorias', 'fornecedores'));
    }

    // Método de atualização
    public function update(Request $request, $id)
    {
        $licenca = Licenca::findOrFail($id);

        $validated = $request->validate([
            'ds_nome' => 'required|string|max:255',
            'ie_status' => 'required|in:A,I,E',
            'nr_seq_categoria_licenca' => 'required|exists:categoria_licencas,nr_sequencia',
            'nr_seq_fornecedor' => 'required|exists:fornecedores,nr_sequencia',
            'ds_observacao' => 'nullable|string',
            'nr_registro' => 'nullable|integer',
            'dt_aquisicao' => 'nullable|date',
            'dt_inicio_vigencia' => 'nullable|date',
            'dt_fim_vigencia' => 'nullable|date',
            'vl_aquisicao' => 'nullable|numeric',
            'vl_mensal' => 'nullable|numeric',
        ]);

        $licenca->update($validated);

        return redirect()
            ->route('licencas.index')
            ->with('success', 'Licença atualizada com sucesso!');
    }

    // Método de exclusão
    public function destroy($id)
    {
        $licenca = Licenca::findOrFail($id);
        $licenca->delete();

        return redirect()
            ->route('licencas.index')
            ->with('success', 'Licença removida com sucesso!');
    }
}
