@extends('layouts.app')

@section('title', 'Manutenções')

@section('styles')
<link href="{{ asset('css/index.css') }}" rel="stylesheet">
<style>

.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(22, 22, 22, 0.55); /* azul-escuro translúcido */
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    transition: opacity 0.25s ease;
}

.modal-overlay.active {
    display: flex;
    animation: fadeIn 0.2s ease-in;
}

.modal {
    background: #ffffff;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
    border-radius: 0;
    width: 420px;
    max-width: 95%;
    overflow: hidden;
    font-family: 'Segoe UI', sans-serif;
}

.modal-header {
    background-color: #1e3a8a;
    color: #ffffff;
    padding: 10px 16px;
    font-size: 15px;
    font-weight: 600;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-body {
    padding: 16px 20px;
    background-color: #f9fafb;
}

.modal-footer {
    padding: 12px 16px;
    background-color: #f1f5f9;
    border-top: 1px solid #e5e7eb;
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}

.btn-close-modal {
    background: none;
    border: none;
    color: #fff;
    font-size: 20px;
    cursor: pointer;
    transition: color 0.2s ease;
}

.btn-close-modal:hover {
    color: #dbeafe;
}

/* Inputs dentro do modal seguem o estilo do form.css */
.modal .form-control {
    border: 1px solid #cbd5e1;
    background-color: #f5f5f5;
    color: #2e3b4e;
    padding: 8px 10px;
    font-size: 14px;
    width: 100%;
    box-sizing: border-box;
}

.modal .form-control:focus {
    border-color: #2563eb;
    outline: none;
}

@keyframes fadeIn {
    from { opacity: 0; transform: scale(0.97); }
    to { opacity: 1; transform: scale(1); }
}
</style>
@endsection

@section('content')
<div class="usuarios-container">
    <div class="usuarios-header">
        <h2>Manutenções</h2>

        <div class="usuarios-actions">
            <form action="{{ route('manutencoes.index') }}" method="GET" class="usuarios-search">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Pesquisar por tipo ou descrição" class="form-control">
                <button type="submit" class="btn btn-primary btn-search">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </form>

            <a href="{{ route('manutencoes.create') }}" class="btn btn-success">Adicionar</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif

    @if($manutencoes->count())
    <div class="table-container mt-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Sequência</th>
                        <th>Tipo</th>
                        <th>Descrição</th>
                        <th>Ativo</th>
                        <th>Envio</th>
                        <th>Retorno</th>
                        <th>Valor Final</th>
                        <th>Atualização</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($manutencoes as $m)
                    <tr>
                        <td>
                            @if($m->ie_status === 'E')
                                <i class="fa-solid fa-circle status-emcurso" title="Em curso"></i>
                            @else
                                <i class="fa-solid fa-circle status-ativo" title="Concluída"></i>
                            @endif
                        </td>
                        <td>{{ $m->nr_sequencia }}</td>
                        <td>{{ $m->ie_tipo === 'C' ? 'Corretiva' : 'Preventiva' }}</td>
                        <td>{{ $m->ds_descricao ?? '' }}</td>
                        <td>{{ $m->ativo->ds_nome ?? '' }}</td>
                        <td>{{ $m->dt_envio ? \Carbon\Carbon::parse($m->dt_envio)->format('d/m/Y') : '' }}</td>
                        <td>{{ $m->dt_retorno ? \Carbon\Carbon::parse($m->dt_retorno)->format('d/m/Y') : '' }}</td>
                        <td>{{ $m->vl_final ? 'R$ ' . number_format($m->vl_final, 2, ',', '.') : '' }}</td>
                        <td>{{ $m->dt_atualizacao ? \Carbon\Carbon::parse($m->dt_atualizacao)->format('d/m/Y H:i') : '' }}</td>
                        <td class="usuarios-acoes">
                            <a href="{{ route('manutencoes.edit', $m->nr_sequencia) }}" class="btn btn-sm btn-primary">
                                <i class="fa-solid fa-square-pen"></i>
                            </a>

                            <form action="{{ route('manutencoes.destroy', $m->nr_sequencia) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Confirma exclusão da manutenção?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" type="submit">
                                    <i class="fa-solid fa-square-xmark"></i>
                                </button>
                            </form>

                            @if($m->ie_status === 'E')
                            <button type="button" class="btn btn-sm btn-success btn-open-modal btn-concluir"
                                data-target="modal-{{ $m->nr_sequencia }}">
                                <i class="fa-solid fa-check"></i>
                            </button>
                            @endif
                        </td>
                    </tr>

                    {{-- MODAL CONCLUIR MANUTENÇÃO --}}
                    <div class="modal-overlay" id="modal-{{ $m->nr_sequencia }}">
                        <div class="modal">
                            <div class="modal-header">
                                <h5>Concluir Manutenção #{{ $m->nr_sequencia }}</h5>
                                <button type="button" class="btn-close-modal" data-target="modal-{{ $m->nr_sequencia }}" aria-label="Fechar">
                                    &times;
                                </button>
                            </div>

                            <form action="{{ route('manutencoes.concluir', $m->nr_sequencia) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="modal-body">
                                    {{-- CAMPO VISÍVEL COM MÁSCARA --}}
                                    <div class="mb-3">
                                        <label for="vl_final_{{ $m->nr_sequencia }}" class="form-label">Valor Final</label>
                                        <input
                                            type="text"
                                            name="vl_final_masked"
                                            id="vl_final_{{ $m->nr_sequencia }}"
                                            class="form-control"
                                            placeholder="R$ 0,00"
                                            required
                                            data-valor-real="{{ $m->vl_final ?? 0.00 }}"
                                        >
                                        {{-- CAMPO OCULTO QUE SERÁ ENVIADO PARA O BACKEND (VALOR LIMPO) --}}
                                        <input type="hidden" name="vl_final" id="vl_final_hidden_{{ $m->nr_sequencia }}" value="{{ $m->vl_final ?? 0.00 }}">
                                    </div>

                                    {{-- INPUT DATA DE RETORNO (PREENCHIMENTO AUTOMÁTICO) --}}
                                    <div class="mb-3">
                                        <label for="dt_retorno_{{ $m->nr_sequencia }}" class="form-label">Data de Retorno</label>
                                        <input
                                            type="date"
                                            name="dt_retorno"
                                            id="dt_retorno_{{ $m->nr_sequencia }}"
                                            class="form-control"
                                            required
                                            {{-- Preenche automaticamente com a data de hoje no formato YYYY-MM-DD --}}
                                            value="{{ \Carbon\Carbon::now()->toDateString() }}" 
                                        >
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button
                                        type="button"
                                        class="btn btn-secondary btn-close-modal"
                                        data-target="modal-{{ $m->nr_sequencia }}"
                                    >
                                        Cancelar
                                    </button>
                                    <button type="submit" class="btn btn-success">
                                        Concluir
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @else
        <div class="alert alert-info text-center mt-4">Nenhuma manutenção encontrada.</div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {

    /* --- Funções do Modal (Mantidas) --- */

    const openModal = (targetId) => {
        const overlay = document.getElementById(targetId);
        if (overlay) {
            overlay.classList.add('active');
            
            // Foca no input de valor mascarado ao abrir
            const firstCurrencyInput = overlay.querySelector('[name^="vl_final_masked"]');
            if(firstCurrencyInput) firstCurrencyInput.focus();
        }
    };

    const closeModal = (targetId) => {
        const overlay = document.getElementById(targetId);
        if (overlay) overlay.classList.remove('active');
    };

    // Delegação para abrir/fechar o modal
    document.addEventListener('click', (e) => {
        const openBtn = e.target.closest('[data-target]');
        if (openBtn && !openBtn.classList.contains('btn-close-modal')) {
            const targetId = openBtn.getAttribute('data-target');
            if (targetId) {
                openModal(targetId);
                e.preventDefault();
                return;
            }
        }

        const closeBtn = e.target.closest('.btn-close-modal');
        if (closeBtn) {
            const targetId = closeBtn.getAttribute('data-target') || closeBtn.dataset.target;
            if (targetId) {
                closeModal(targetId);
                e.preventDefault();
            } else {
                const overlay = closeBtn.closest('.modal-overlay');
                if (overlay) overlay.classList.remove('active');
            }
            return;
        }

        // Fecha ao clicar no overlay (fora do modal)
        const overlayClicked = e.target.closest('.modal-overlay');
        if (overlayClicked && e.target === overlayClicked) {
            overlayClicked.classList.remove('active');
            return;
        }
    });

    /* -------------------------------------------------------------------------- */
    /* Funções de Máscara de Valor (Ajustadas)                      */
    /* -------------------------------------------------------------------------- */

    /**
     * Aplica a máscara de moeda (0,00) a um valor, SEM o símbolo "R$".
     */
    const formatCurrency = (value) => {
        let numericValue = String(value).replace(',', '.');
        const number = parseFloat(numericValue) || 0;
        
        // 💡 ALTERAÇÃO AQUI: Removemos style: 'currency' e currency: 'BRL'
        return new Intl.NumberFormat('pt-BR', { 
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }).format(number);
    };

    /**
     * Remove a formatação e retorna o valor numérico com ponto como separador decimal.
     */
    const unmaskCurrency = (maskedValue) => {
        if (!maskedValue) return '0.00';
        
        // 💡 ALTERAÇÃO AQUI: Removemos o símbolo R$ da limpeza, pois ele não será mais inserido
        return maskedValue
            .replace(/\s/g, '') // Remove espaços em branco
            .replace(/\./g, '') // Remove separador de milhar (ponto)
            .replace(/,/g, '.') // Substitui vírgula decimal por ponto
            .trim();
    };

    /**
     * Inicializa e aplica a lógica da máscara de valor em um input.
     */
    const setupCurrencyInput = (inputElement) => {
        const hiddenInputId = `vl_final_hidden_${inputElement.id.split('_').pop()}`;
        const hiddenInput = document.getElementById(hiddenInputId);
        
        // 1. Inicializa o campo visível com o valor formatado
        const initialRealValue = inputElement.getAttribute('data-valor-real') || '0.00';
        inputElement.value = formatCurrency(initialRealValue);

        // 2. Evento de input (digitando)
        inputElement.addEventListener('input', (e) => {
            let rawDigits = e.target.value.replace(/\D/g, ''); 
            
            let valueInCents = parseInt(rawDigits, 10) || 0;
            let finalValue = valueInCents / 100;
            
            e.target.value = formatCurrency(finalValue);
            
            if (hiddenInput) {
                hiddenInput.value = finalValue.toFixed(2);
            }
        });

        // 3. Evento de blur (sair do campo) para reforçar a formatação
        inputElement.addEventListener('blur', (e) => {
            const finalValue = parseFloat(unmaskCurrency(e.target.value)) || 0;
            e.target.value = formatCurrency(finalValue);
            
            if (hiddenInput) {
                hiddenInput.value = finalValue.toFixed(2);
            }
        });
    };

    // Aplica a máscara a todos os campos de valor final
    document.querySelectorAll('[name^="vl_final_masked"]').forEach(setupCurrencyInput);


    /* --- Submissão de Formulários (AJAX) --- */

    document.querySelectorAll('.modal-overlay form').forEach(form => {
        form.addEventListener('submit', async (ev) => {
            ev.preventDefault();

            // Garante que o campo oculto recebe o valor limpo ANTES do envio
            const maskedInput = form.querySelector('[name^="vl_final_masked"]');
            const hiddenInput = form.querySelector('input[name="vl_final"]');
            
            if (maskedInput && hiddenInput) {
                const finalValue = parseFloat(unmaskCurrency(maskedInput.value)) || 0;
                hiddenInput.value = finalValue.toFixed(2);
            }

            const url = form.action;
            const formData = new FormData(form);

            const tokenInput = form.querySelector('input[name="_token"]');
            const csrfToken = tokenInput ? tokenInput.value : null;

            try {
                const resp = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken || '',
                        'Accept': 'application/json' 
                    },
                    body: formData
                });

                let data;
                const text = await resp.text();
                try { data = JSON.parse(text); } 
                catch (err) { data = { success: false, message: text || 'Resposta inesperada do servidor.' }; }

                if (resp.ok && data.success) {
                    const overlay = form.closest('.modal-overlay');
                    if (overlay) overlay.classList.remove('active');

                    alert(data.message || 'Operação concluída com sucesso!');
                    location.reload(); 
                } else {
                    let msg = data.message || 'Erro ao processar a solicitação.';
                    
                    if (data.errors) {
                        msg += "\n\nErros de Validação:";
                        for (const field in data.errors) {
                            msg += `\n- ${data.errors[field].join(', ')}`;
                        }
                    }
                    alert(msg);
                }
            } catch (err) {
                console.error(err);
                alert('Erro de rede ao tentar concluir a manutenção.');
            }
        });
    });
});
</script>


@endsection