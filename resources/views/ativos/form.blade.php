@extends('layouts.app')

@section('title', isset($ativo) ? 'Editar ativo' : 'Cadastrar ativo')

@section('styles')
    <link href="{{ asset('css/form.css') }}" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a2e0e6ad3d.js" crossorigin="anonymous"></script>
@endsection

@section('content')
<div class="usuarios-container">

    <!-- Cabeçalho da página -->
    <div class="usuarios-header">
        <h2>{{ isset($ativo) ? 'Editar ativo' : 'Cadastrar ativo' }}</h2>
    </div>

    <!-- Mensagens de sucesso -->
    @if(session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif

    <!-- Formulário -->
    <div class="form-wrapper mt-4">
        <form action="{{ isset($ativo) ? route('ativos.update', $ativo->nr_sequencia) : route('ativos.store') }}"
              method="POST" autocomplete="off">
            @csrf
            @if(isset($ativo))
                @method('PUT')
            @endif

            <div class="form-section">
                <div class="form-row">
                    <div class="form-group half">
                        <label for="nr_sequencia">
                            <i class="fa-solid fa-asterisk icone-obrigatorio"></i>
                            Sequência
                            <i class="fa-solid fa-circle-info info-icon" title="Tabela: ativos | Atributo: nr_sequencia"></i>
                        </label>
                        <input type="text"
                            id="nr_sequencia"
                            name="nr_sequencia"
                            class="input-desabled form-control @error('nr_sequencia') is-invalid @enderror"
                            value="{{ old('nr_sequencia', $ativo->nr_sequencia ?? '') }}"
                            required disabled>
                        @error('nr_sequencia')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group half">
                        <label for="ds_nome">
                            <i class="fa-solid fa-asterisk icone-obrigatorio"></i>
                            Nome
                            <i class="fa-solid fa-circle-info info-icon" title="Tabela: ativos | Atributo: ds_nome"></i>
                        </label>
                        <input type="text"
                            id="ds_nome"
                            name="ds_nome"
                            class="form-control @error('ds_nome') is-invalid @enderror"
                            value="{{ old('ds_nome', $ativo->ds_nome ?? '') }}"
                            required>
                        @error('ds_nome')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group half">
                        <label for="nr_serie">
                            Nº Série / Placa
                            <i class="fa-solid fa-circle-info info-icon" title="Tabela: ativos | Atributo: nr_serie"></i>
                        </label>
                        <input type="text"
                            id="nr_serie"
                            name="nr_serie"
                            class="form-control @error('nr_serie') is-invalid @enderror"
                            value="{{ old('nr_serie', $ativo->nr_serie ?? '') }}">
                        @error('nr_serie')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group half">
                        <label for="ds_modelo">
                            Modelo
                            <i class="fa-solid fa-circle-info info-icon" title="Tabela: ativos | Atributo: ds_modelo"></i>
                        </label>
                        <input type="text"
                            id="ds_modelo"
                            name="ds_modelo"
                            class="form-control @error('ds_modelo') is-invalid @enderror"
                            value="{{ old('ds_modelo', $ativo->ds_modelo ?? '') }}">
                        @error('ds_modelo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group half">
                        <label for="cd_patrimonio">
                            Patrimônio
                            <i class="fa-solid fa-circle-info info-icon" title="Tabela: ativos | Atributo: cd_patrimonio"></i>
                        </label>
                        <input type="text"
                            id="cd_patrimonio"
                            name="cd_patrimonio"
                            class="form-control @error('cd_patrimonio') is-invalid @enderror"
                            value="{{ old('cd_patrimonio', $ativo->cd_patrimonio ?? '') }}">
                        @error('cd_patrimonio')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group half">
                        <label for="nr_seq_categoria_ativo">
                            <!--<i class="fa-solid fa-asterisk icone-obrigatorio"></i>-->
                            Categoria
                            <i class="fa-solid fa-circle-info info-icon" title="Tabela: ativos | Atributo: nr_seq_categoria_ativo"></i>
                        </label>
                        <select id="nr_seq_categoria_ativo"
                                name="nr_seq_categoria_ativo"
                                class="form-control @error('nr_seq_categoria_ativo') is-invalid @enderror">
                            <option value="">---</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->nr_sequencia }}"
                                    {{ old('nr_seq_categoria_ativo', $ativo->nr_seq_categoria_ativo ?? '') == $categoria->nr_sequencia ? 'selected' : '' }}>
                                    {{ $categoria->ds_nome }}
                                </option>
                            @endforeach
                        </select>
                        @error('nr_seq_categoria_ativo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group half">
                        <label for="nr_seq_localizacao">
                            <!--<i class="fa-solid fa-asterisk icone-obrigatorio"></i>-->
                            Localização
                            <i class="fa-solid fa-circle-info info-icon" title="Tabela: ativos | Atributo: nr_seq_localizacao"></i>
                        </label>
                        <select id="nr_seq_localizacao"
                                name="nr_seq_localizacao"
                                class="form-control @error('nr_seq_localizacao') is-invalid @enderror">
                            <option value="">---</option>
                            @foreach($localizacoes as $localizacao)
                                <option value="{{ $localizacao->nr_sequencia }}"
                                    {{ old('nr_seq_localizacao', $ativo->nr_seq_localizacao ?? '') == $localizacao->nr_sequencia ? 'selected' : '' }}>
                                    {{ $localizacao->ds_nome }}
                                </option>
                            @endforeach
                        </select>
                        @error('nr_seq_localizacao')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group half">
                        <label for="nr_seq_fornecedor">
                            <!--<i class="fa-solid fa-asterisk icone-obrigatorio"></i>-->
                            Fornecedor
                            <i class="fa-solid fa-circle-info info-icon" title="Tabela: ativos | Atributo: nr_seq_fornecedor"></i>
                        </label>
                        <select id="nr_seq_fornecedor"
                                name="nr_seq_fornecedor"
                                class="form-control @error('nr_seq_fornecedor') is-invalid @enderror">
                            <option value="">---</option>
                            @foreach($fornecedores as $fornecedor)
                                <option value="{{ $fornecedor->nr_sequencia }}"
                                    {{ old('nr_seq_fornecedor', $ativo->nr_seq_fornecedor ?? '') == $fornecedor->nr_sequencia ? 'selected' : '' }}>
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
                            <i class="fa-solid fa-circle-info info-icon" title="Tabela: ativos | Atributo: dt_aquisicao"></i>
                        </label>
                        <input type="date"
                            id="dt_aquisicao"
                            name="dt_aquisicao"
                            class="form-control @error('dt_aquisicao') is-invalid @enderror"
                            value="{{ old('dt_aquisicao', isset($ativo->dt_aquisicao) ? $ativo->dt_aquisicao->format('Y-m-d') : '') }}">
                        @error('dt_aquisicao')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group half">
                        <label for="dt_fim_garantia">
                            Fim da Garantia
                            <i class="fa-solid fa-circle-info info-icon" title="Tabela: ativos | Atributo: dt_fim_garantia"></i>
                        </label>
                        <input type="date"
                            id="dt_fim_garantia"
                            name="dt_fim_garantia"
                            class="form-control @error('dt_fim_garantia') is-invalid @enderror"
                            value="{{ old('dt_fim_garantia', isset($ativo->dt_fim_garantia) ? $ativo->dt_fim_garantia->format('Y-m-d') : '') }}">
                        @error('dt_fim_garantia')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group half">
                        <label for="vl_aquisicao">
                            Valor Aquisição
                            <i class="fa-solid fa-circle-info info-icon" title="Tabela: ativos | Atributo: vl_aquisicao"></i>
                        </label>
                        <input type="text"
                            id="vl_aquisicao"
                            name="vl_aquisicao"
                            class="form-control @error('vl_aquisicao') is-invalid @enderror"
                            value="{{ old('vl_aquisicao', $ativo->vl_aquisicao ?? '') }}"
                            oninput="formatCurrency(this)">
                        @error('vl_aquisicao')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="ds_observacao">
                        Observação
                        <i class="fa-solid fa-circle-info info-icon" title="Tabela: ativos | Atributo: ds_observacao"></i>
                    </label>
                    <textarea id="ds_observacao"
                              name="ds_observacao"
                              rows="3"
                              class="form-control @error('ds_observacao') is-invalid @enderror">{{ old('ds_observacao', $ativo->ds_observacao ?? '') }}</textarea>
                    @error('ds_observacao')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-row">

                    <div class="form-group half">
                        <label for="ie_status">
                            Status
                            <i class="fa-solid fa-circle-info info-icon" title="Tabela: ativos | Atributo: ie_status"></i>
                        </label>

                        @if(isset($ativo) && $ativo->ie_status === 'M')
                            {{-- Se o ativo estiver em manutenção, não permitir alterar o status --}}
                            <input type="hidden" name="ie_status" value="M">
                            <input type="text" class="form-control input-desabled" value="Em manutenção" disabled>
                        @else
                            <select id="ie_status"
                                    name="ie_status"
                                    class="form-select @error('ie_status') is-invalid @enderror"
                                    required>
                                <option value="A" {{ old('ie_status', $ativo->ie_status ?? '') == 'A' ? 'selected' : '' }}>Ativo</option>
                                <option value="I" {{ old('ie_status', $ativo->ie_status ?? '') == 'I' ? 'selected' : '' }}>Inativo</option>
                                <option value="D" {{ old('ie_status', $ativo->ie_status ?? '') == 'D' ? 'selected' : '' }}>Descartado</option>
                            </select>

                        @endif

                        @error('ie_status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <a href="{{ route('ativos.index') }}" class="btn btn-secondary">Cancelar</a>
                    
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
document.addEventListener("DOMContentLoaded", function () {
    const dtAquisicao = document.getElementById("dt_aquisicao");

    if (dtAquisicao && !dtAquisicao.value) {
        let today = new Date();
        let year = today.getFullYear();
        let month = String(today.getMonth() + 1).padStart(2, '0');
        let day = String(today.getDate()).padStart(2, '0');

        dtAquisicao.value = `${year}-${month}-${day}`;
    }
});

</script>
@endsection
