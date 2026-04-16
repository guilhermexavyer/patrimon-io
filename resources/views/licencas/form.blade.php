@extends('layouts.app')

@section('title', isset($licenca) ? 'Editar licença' : 'Cadastrar licença')

@section('styles')
    <link href="{{ asset('css/form.css') }}" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a2e0e6ad3d.js" crossorigin="anonymous"></script>
@endsection

@section('content')
<div class="usuarios-container">

    <!-- Cabeçalho da página -->
    <div class="usuarios-header">
        <h2>{{ isset($licenca) ? 'Editar licença' : 'Cadastrar licença' }}</h2>
    </div>

    <!-- Mensagens de sucesso -->
    @if(session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif

    <!-- Formulário -->
    <div class="form-wrapper mt-4">
        <form action="{{ isset($licenca) ? route('licencas.update', $licenca->nr_sequencia) : route('licencas.store') }}"
              method="POST" autocomplete="off">
            @csrf
            @if(isset($licenca))
                @method('PUT')
            @endif

            <div class="form-section">
                <div class="form-row">
                    <div class="form-group half">
                        <label for="nr_sequencia">
                            <i class="fa-solid fa-asterisk icone-obrigatorio"></i>
                            Sequência
                            <i class="fa-solid fa-circle-info info-icon" title="Tabela: licencas | Atributo: nr_sequencia"></i>
                        </label>
                        <input type="text"
                            id="nr_sequencia"
                            name="nr_sequencia"
                            class="input-desabled form-control @error('nr_sequencia') is-invalid @enderror"
                            value="{{ old('nr_sequencia', $licenca->nr_sequencia ?? '') }}"
                            required disabled>
                        @error('nr_sequencia')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group half">
                        <label for="ds_nome">
                            <i class="fa-solid fa-asterisk icone-obrigatorio"></i>
                            Nome
                            <i class="fa-solid fa-circle-info info-icon" title="Tabela: licencas | Atributo: ds_nome"></i>
                        </label>
                        <input type="text"
                            id="ds_nome"
                            name="ds_nome"
                            class="form-control @error('ds_nome') is-invalid @enderror"
                            value="{{ old('ds_nome', $licenca->ds_nome ?? '') }}"
                            required>
                        @error('ds_nome')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group half">
                        <label for="nr_seq_categoria_licenca">
                            <i class="fa-solid fa-asterisk icone-obrigatorio"></i>
                            Categoria
                            <i class="fa-solid fa-circle-info info-icon" title="Tabela: licencas | Atributo: nr_seq_categoria_licenca"></i>
                        </label>
                        <select id="nr_seq_categoria_licenca"
                                name="nr_seq_categoria_licenca"
                                class="form-control @error('nr_seq_categoria_licenca') is-invalid @enderror"
                                required>
                            <option value="">---</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->nr_sequencia }}"
                                    {{ old('nr_seq_categoria_licenca', $licenca->nr_seq_categoria_licenca ?? '') == $categoria->nr_sequencia ? 'selected' : '' }}>
                                    {{ $categoria->ds_nome }}
                                </option>
                            @endforeach
                        </select>
                        @error('nr_seq_categoria_licenca')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group half">
                        <label for="nr_registro">
                            Número Registro
                            <i class="fa-solid fa-circle-info info-icon" title="Tabela: licencas | Atributo: nr_registro"></i>
                        </label>
                        <input type="text"
                            id="nr_registro"
                            name="nr_registro"
                            class="form-control @error('nr_registro') is-invalid @enderror"
                            value="{{ old('nr_registro', $licenca->nr_registro ?? '') }}">
                        @error('nr_registro')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group half">
                        <label for="nr_seq_fornecedor">
                            <i class="fa-solid fa-asterisk icone-obrigatorio"></i>
                            Fornecedor
                            <i class="fa-solid fa-circle-info info-icon" title="Tabela: licencas | Atributo: nr_seq_fornecedor"></i>
                        </label>
                        <select id="nr_seq_fornecedor"
                                name="nr_seq_fornecedor"
                                class="form-control @error('nr_seq_fornecedor') is-invalid @enderror"
                                required>
                            <option value="">---</option>
                            @foreach($fornecedores as $fornecedor)
                                <option value="{{ $fornecedor->nr_sequencia }}"
                                    {{ old('nr_seq_fornecedor', $licenca->nr_seq_fornecedor ?? '') == $fornecedor->nr_sequencia ? 'selected' : '' }}>
                                    {{ $fornecedor->ds_nome ?? $fornecedor->nm_fantasia }}
                                </option>
                            @endforeach
                        </select>
                        @error('nr_seq_fornecedor')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group half">
                        <label for="dt_aquisicao">
                            Data Aquisição
                            <i class="fa-solid fa-circle-info info-icon" title="Tabela: licencas | Atributo: dt_aquisicao"></i>
                        </label>
                        <input type="date"
                            id="dt_aquisicao"
                            name="dt_aquisicao"
                            class="form-control @error('dt_aquisicao') is-invalid @enderror"
                            value="{{ old('dt_aquisicao', isset($licenca->dt_aquisicao) ? $licenca->dt_aquisicao->format('Y-m-d') : '') }}">
                        @error('dt_aquisicao')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group half">
                        <label for="dt_inicio_vigencia">
                            Data Início Vigência
                            <i class="fa-solid fa-circle-info info-icon" title="Tabela: licencas | Atributo: dt_inicio_vigencia"></i>
                        </label>
                        <input type="date"
                            id="dt_inicio_vigencia"
                            name="dt_inicio_vigencia"
                            class="form-control @error('dt_inicio_vigencia') is-invalid @enderror"
                            value="{{ old('dt_inicio_vigencia', isset($licenca->dt_inicio_vigencia) ? $licenca->dt_inicio_vigencia->format('Y-m-d') : '') }}">
                        @error('dt_inicio_vigencia')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group half">
                        <label for="dt_fim_vigencia">
                            Data Fim Vigência
                            <i class="fa-solid fa-circle-info info-icon" title="Tabela: licencas | Atributo: dt_fim_vigencia"></i>
                        </label>
                        <input type="date"
                            id="dt_fim_vigencia"
                            name="dt_fim_vigencia"
                            class="form-control @error('dt_fim_vigencia') is-invalid @enderror"
                            value="{{ old('dt_fim_vigencia', isset($licenca->dt_fim_vigencia) ? $licenca->dt_fim_vigencia->format('Y-m-d') : '') }}">
                        @error('dt_fim_vigencia')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group half">
                        <label for="vl_aquisicao">
                            Valor Aquisição
                            <i class="fa-solid fa-circle-info info-icon" title="Tabela: licencas | Atributo: vl_aquisicao"></i>
                        </label>
                        <input type="text"
                            id="vl_aquisicao"
                            name="vl_aquisicao"
                            class="form-control @error('vl_aquisicao') is-invalid @enderror"
                            value="{{ old('vl_aquisicao', $licenca->vl_aquisicao ?? '') }}"
                            oninput="formatCurrency(this)">
                        @error('vl_aquisicao')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group half">
                        <label for="vl_mensal">
                            Valor Mensal
                            <i class="fa-solid fa-circle-info info-icon" title="Tabela: licencas | Atributo: vl_mensal"></i>
                        </label>
                        <input type="text"
                            id="vl_mensal"
                            name="vl_mensal"
                            class="form-control @error('vl_mensal') is-invalid @enderror"
                            value="{{ old('vl_mensal', $licenca->vl_mensal ?? '') }}"
                            oninput="formatCurrency(this)">
                        @error('vl_mensal')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="ds_observacao">
                        Observação
                        <i class="fa-solid fa-circle-info info-icon" title="Tabela: licencas | Atributo: ds_observacao"></i>
                    </label>
                    <textarea id="ds_observacao"
                              name="ds_observacao"
                              rows="3"
                              class="form-control @error('ds_observacao') is-invalid @enderror">{{ old('ds_observacao', $licenca->ds_observacao ?? '') }}</textarea>
                    @error('ds_observacao')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-row">

                    <div class="form-group half">
                        <label for="ie_status">
                            Status
                            <i class="fa-solid fa-circle-info info-icon" title="Tabela: licencas | Atributo: ie_status"></i>
                        </label>
                        <select id="ie_status"
                                name="ie_status"
                                class="form-select @error('ie_status') is-invalid @enderror"
                                required>
                            <option value="A" {{ old('ie_status', $licenca->ie_status ?? '') == 'A' ? 'selected' : '' }}>Ativa</option>
                            <option value="E" {{ old('ie_status', $licenca->ie_status ?? '') == 'E' ? 'selected' : '' }}>Expirada</option>
                            <option value="I" {{ old('ie_status', $licenca->ie_status ?? '') == 'I' ? 'selected' : '' }}>Inativa</option>
                        </select>
                        @error('ie_status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <a href="{{ route('licencas.index') }}" class="btn btn-secondary">Cancelar</a>
                    
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
function formatCurrency(input) {
    let value = input.value.replace(/\D/g, '');

    if (value.length === 0) {
        input.value = '';
        return;
    }

    if (value.length === 1) {
        input.value = '0.0' + value;
    } else if (value.length === 2) {
        input.value = '0.' + value;
    } else {
        let integerPart = value.slice(0, -2);
        let decimalPart = value.slice(-2);
        input.value = parseInt(integerPart) + '.' + decimalPart;
    }
}

function formatIP(input) {
    // Remove tudo que não for número
    let value = input.value.replace(/\D/g, '');

    // Limita a 12 dígitos (4 grupos de até 3 números)
    if (value.length > 12) {
        value = value.substring(0, 12);
    }

    // Divide o valor em blocos de 3
    let formatted = '';
    for (let i = 0; i < value.length; i += 3) {
        if (i > 0) formatted += '.';
        formatted += value.substring(i, i + 3);
    }

    input.value = formatted;
}

(function () {
  function getFocusableElements(container = document) {
    return Array.from(
      container.querySelectorAll(
        'a[href], button:not([disabled]), input:not([disabled]):not([type="hidden"]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])'
      )
    ).filter(el => el.offsetParent !== null); // remove elementos invisíveis
  }

  document.addEventListener('keydown', function (e) {
    if (e.key !== 'Tab') return;

    const active = document.activeElement;
    if (!active) return;

    // se estiver num input date, intercepta o Tab
    if (active.tagName.toLowerCase() === 'input' && active.type === 'date') {
      e.preventDefault();

      const focusables = getFocusableElements();
      const idx = focusables.indexOf(active);

      if (idx === -1) return;

      const nextIndex = e.shiftKey ? idx - 1 : idx + 1;
      const nextEl = focusables[nextIndex];

      if (nextEl) {
        nextEl.focus();
      } else {
        // se não houver próximo, deixa o comportamento natural (opcional)
        active.blur();
      }
    }
  }, true);
})();

// Preencher automaticamente a data de aquisição com a data atual (somente se vazio)
document.addEventListener("DOMContentLoaded", function () {
    const inputAquisicao = document.getElementById("dt_aquisicao");

    // Só define automaticamente se o campo estiver vazio
    if (inputAquisicao && !inputAquisicao.value) {
        const hoje = new Date();
        const ano  = hoje.getFullYear();
        const mes  = String(hoje.getMonth() + 1).padStart(2, '0');
        const dia  = String(hoje.getDate()).padStart(2, '0');

        inputAquisicao.value = `${ano}-${mes}-${dia}`;
    }
});
</script>
@endsection
