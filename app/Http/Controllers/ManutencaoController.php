<?php

namespace App\Http\Controllers;

use App\Models\Manutencao;
use App\Models\Ativo;
use App\Models\PrestadorServico;
use Illuminate\Http\Request;

class ManutencaoController extends Controller
{
    // Método de listagem
    public function index(Request $request)
    {
        $query = Manutencao::with(['ativo', 'prestadorServico']);

        if ($request->filled('search')) {
            $term = $request->input('search');
            $query->where(function ($q) use ($term) {
                $q->where('ds_descricao', 'LIKE', "%{$term}%")
                  ->orWhere('ie_tipo', 'LIKE', "%{$term}%");
            });
        }

        $manutencoes = $query->orderByDesc('nr_sequencia')->get();

        return view('manutencoes.index', compact('manutencoes'));
    }

    // Método de exibição da tela de cadastro
    public function create(Request $request)
    {
        $ativos = Ativo::where('ie_status', 'A')->orderBy('ds_nome')->get();
        $prestadores = PrestadorServico::where('ie_status', 'A')->orderBy('ds_nome')->get();

        // captura ativo da query string, se houver
        $ativoSelecionado = $request->query('ativo');

        return view('manutencoes.form', compact('ativos', 'prestadores', 'ativoSelecionado'));
    }

    // Método de cadastro
    public function store(Request $request)
    {
        $validated = $request->validate([
            'ie_tipo' => 'required|in:C,P',
            'ds_descricao' => 'nullable|string|max:255',
            'dt_envio' => 'required|date',
            'nr_seq_ativo' => 'required|exists:ativos,nr_sequencia',
            'nr_seq_prestador_servico' => 'required|exists:prestadores_servico,nr_sequencia',
        ]);

        $validated['ie_status'] = 'E';
        $validated['dt_criacao'] = now();
        $validated['dt_atualizacao'] = now();

        $manutencao = Manutencao::create($validated);

        // Atualiza o ativo para "Em manutenção"
        $ativo = Ativo::find($validated['nr_seq_ativo']);
        if ($ativo) {
            $ativo->ie_status = 'M';
            $ativo->timestamps = false;
            $ativo->saveQuietly();
        }

        return redirect()
            ->route('manutencoes.index')
            ->with('success', 'Manutenção cadastrada com sucesso!');
    }

    // Método de exibição da tela de atualização
    public function edit($id)
    {
        $manutencao = Manutencao::findOrFail($id);
        $ativos = Ativo::orderBy('ds_nome')->get();
        $prestadores = PrestadorServico::where('ie_status', 'A')->orderBy('ds_nome')->get();

        return view('manutencoes.form', compact('manutencao', 'ativos', 'prestadores'));
    }

    // Método de atualização
    public function update(Request $request, $id)
    {
        $manutencao = Manutencao::findOrFail($id);

        $validated = $request->validate([
            'ie_tipo' => 'required|in:C,P',
            'ds_descricao' => 'nullable|string|max:255',
            'dt_envio' => 'required|date',
            'dt_retorno' => 'nullable|date|after_or_equal:dt_envio',
            'vl_final' => 'nullable|numeric|min:0',
            'nr_seq_ativo' => 'required|exists:ativos,nr_sequencia',
            'nr_seq_prestador_servico' => 'required|exists:prestadores_servico,nr_sequencia',
        ]);

        $validated['dt_atualizacao'] = now();

        $manutencao->update($validated);

        return redirect()
            ->route('manutencoes.index')
            ->with('success', 'Manutenção atualizada com sucesso!');
    }

    // Método de conclusão
    public function concluir(Request $request, $id)
    {
        $manutencao = Manutencao::findOrFail($id);

        $validated = $request->validate([
            'dt_retorno' => 'required|date',
            'vl_final' => 'required|numeric|min:0',
        ]);

        // Atualiza a manutenção
        $manutencao->update([
            'dt_retorno' => $validated['dt_retorno'],
            'vl_final' => $validated['vl_final'],
            'ie_status' => 'C',
            'dt_atualizacao' => now(),
        ]);

        // Reativa o ativo vinculado
        $ativo = Ativo::find($manutencao->nr_seq_ativo);
        if ($ativo) {
            $ativo->ie_status = 'A';
            $ativo->timestamps = false;
            $ativo->saveQuietly();
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Manutenção concluída com sucesso!'
            ]);
        }

        return redirect()
            ->route('manutencoes.index')
            ->with('success', 'Manutenção concluída com sucesso!');
    }

    // Método de exclusão
    public function destroy($id)
    {
        $manutencao = Manutencao::findOrFail($id);
        $manutencao->delete();

        return redirect()
            ->route('manutencoes.index')
            ->with('success', 'Manutenção removida com sucesso!');
    }
}
