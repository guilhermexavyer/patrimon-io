@extends('layouts.app')

@section('title', isset($dominio) ? 'Editar domínio' : 'Cadastrar domínio')

@section('styles')
    <link href="{{ asset('css/form.css') }}" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a2e0e6ad3d.js" crossorigin="anonymous"></script>
@endsection

@section('content')
<div class="usuarios-container">

    <!-- Cabeçalho da página -->
    <div class="usuarios-header">
        <h2>{{ isset($dominio) ? 'Editar domínio' : 'Cadastrar domínio' }}</h2>
    </div>

    <!-- Mensagens de sucesso -->
    @if(session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif

    <!-- Formulário -->
    <div class="form-wrapper mt-4">
        <form action="{{ isset($dominio) ? route('dominios.update', $dominio->nr_sequencia) : route('dominios.store') }}"
              method="POST">
            @csrf
            @if(isset($dominio))
                @method('PUT')
            @endif

            <div class="form-section">
                <div class="form-row">
                    <div class="form-group half">
                        <label for="nr_sequencia">
                            Sequência
                            <i class="fa-solid fa-circle-info info-icon" title="Tabela: dominios | Atributo: nr_sequencia"></i>
                        </label>
                        <input type="text"
                            id="nr_sequencia"
                            name="nr_sequencia"
                            class="input-desabled form-control @error('nr_sequencia') is-invalid @enderror"
                            value="{{ old('nr_sequencia', $dominio->nr_sequencia ?? '') }}"
                            required disabled>
                        @error('nr_sequencia')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group half">
                        <label for="ds_nome">
                            Nome
                            <i class="fa-solid fa-circle-info info-icon" title="Tabela: dominios | Atributo: ds_nome"></i>
                        </label>
                        <input type="text"
                            id="ds_nome"
                            name="ds_nome"
                            class="form-control @error('ds_nome') is-invalid @enderror"
                            value="{{ old('ds_nome', $dominio->ds_nome ?? '') }}"
                            required>
                        @error('ds_nome')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group half">
                        <label for="ds_url">
                            URL
                            <i class="fa-solid fa-circle-info info-icon" title="Tabela: dominios | Atributo: ds_url"></i>
                        </label>
                        <input type="text"
                            id="ds_url"
                            name="ds_url"
                            class="form-control @error('ds_url') is-invalid @enderror"
                            value="{{ old('ds_url', $dominio->ds_url ?? '') }}"
                            required>
                        @error('ds_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group half">
                        <label for="nr_registro">
                            Número Registro
                            <i class="fa-solid fa-circle-info info-icon" title="Tabela: dominios | Atributo: nr_registro"></i>
                        </label>
                        <input type="text"
                            id="nr_registro"
                            name="nr_registro"
                            class="form-control @error('nr_registro') is-invalid @enderror"
                            value="{{ old('nr_registro', $dominio->nr_registro ?? '') }}">
                        @error('nr_registro')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group half">
                        <label for="nr_ip">
                            IP
                            <i class="fa-solid fa-circle-info info-icon" title="Tabela: dominios | Atributo: nr_ip"></i>
                        </label>
                        <input type="text"
                            id="nr_ip"
                            name="nr_ip"
                            class="form-control @error('nr_ip') is-invalid @enderror"
                            value="{{ old('nr_ip', $dominio->nr_ip ?? '') }}"
                            oninput="formatIP(this)"
                            maxlength="15">
                        @error('nr_ip')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group half">
                        <label for="nr_dns_primario">
                            DNS Primário
                            <i class="fa-solid fa-circle-info info-icon" title="Tabela: dominios | Atributo: nr_dns_primario"></i>
                        </label>
                        <input type="text"
                            id="nr_dns_primario"
                            name="nr_dns_primario"
                            class="form-control @error('nr_dns_primario') is-invalid @enderror"
                            value="{{ old('nr_dns_primario', $dominio->nr_dns_primario ?? '') }}"
                            oninput="formatIP(this)"
                            maxlength="15">
                        @error('nr_dns_primario')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group half">
                        <label for="nr_dns_secundario">
                            DNS Secundário
                            <i class="fa-solid fa-circle-info info-icon" title="Tabela: dominios | Atributo: nr_dns_secundario"></i>
                        </label>
                        <input type="text"
                            id="nr_dns_secundario"
                            name="nr_dns_secundario"
                            class="form-control @error('nr_dns_secundario') is-invalid @enderror"
                            value="{{ old('nr_dns_secundario', $dominio->nr_dns_secundario ?? '') }}"
                            oninput="formatIP(this)"
                            maxlength="15">
                        @error('nr_dns_secundario')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group half">
                        <label for="dt_aquisicao">
                            Data Aquisição
                            <i class="fa-solid fa-circle-info info-icon" title="Tabela: dominios | Atributo: dt_aquisicao"></i>
                        </label>
                        <input type="date"
                            id="dt_aquisicao"
                            name="dt_aquisicao"
                            class="form-control @error('dt_aquisicao') is-invalid @enderror"
                            value="{{ old('dt_aquisicao', isset($dominio->dt_aquisicao) ? $dominio->dt_aquisicao->format('Y-m-d') : '') }}">
                        @error('dt_aquisicao')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group half">
                        <label for="dt_inicio_vigencia">
                            Data Início Vigência
                            <i class="fa-solid fa-circle-info info-icon" title="Tabela: dominios | Atributo: dt_inicio_vigencia"></i>
                        </label>
                        <input type="date"
                            id="dt_inicio_vigencia"
                            name="dt_inicio_vigencia"
                            class="form-control @error('dt_inicio_vigencia') is-invalid @enderror"
                            value="{{ old('dt_inicio_vigencia', isset($dominio->dt_inicio_vigencia) ? $dominio->dt_inicio_vigencia->format('Y-m-d') : '') }}">
                        @error('dt_inicio_vigencia')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group half">
                        <label for="dt_fim_vigencia">
                            Data Fim Vigência
                            <i class="fa-solid fa-circle-info info-icon" title="Tabela: dominios | Atributo: dt_fim_vigencia"></i>
                        </label>
                        <input type="date"
                            id="dt_fim_vigencia"
                            name="dt_fim_vigencia"
                            class="form-control @error('dt_fim_vigencia') is-invalid @enderror"
                            value="{{ old('dt_fim_vigencia', isset($dominio->dt_fim_vigencia) ? $dominio->dt_fim_vigencia->format('Y-m-d') : '') }}">
                        @error('dt_fim_vigencia')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group half">
                        <label for="vl_aquisicao">
                            Valor Aquisição
                            <i class="fa-solid fa-circle-info info-icon" title="Tabela: dominios | Atributo: vl_aquisicao"></i>
                        </label>
                        <input type="text"
                            id="vl_aquisicao"
                            name="vl_aquisicao"
                            class="form-control @error('vl_aquisicao') is-invalid @enderror"
                            value="{{ old('vl_aquisicao', $dominio->vl_aquisicao ?? '') }}"
                            oninput="formatCurrency(this)">
                        @error('vl_aquisicao')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group half">
                        <label for="vl_mensal">
                            Valor Mensal
                            <i class="fa-solid fa-circle-info info-icon" title="Tabela: dominios | Atributo: vl_mensal"></i>
                        </label>
                        <input type="text"
                            id="vl_mensal"
                            name="vl_mensal"
                            class="form-control @error('vl_mensal') is-invalid @enderror"
                            value="{{ old('vl_mensal', $dominio->vl_mensal ?? '') }}"
                            oninput="formatCurrency(this)">
                        @error('vl_mensal')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="ds_observacao">
                        Observação
                        <i class="fa-solid fa-circle-info info-icon" title="Tabela: dominios | Atributo: ds_observacao"></i>
                    </label>
                    <textarea id="ds_observacao"
                              name="ds_observacao"
                              rows="3"
                              class="form-control @error('ds_observacao') is-invalid @enderror">{{ old('ds_observacao', $dominio->ds_observacao ?? '') }}</textarea>
                    @error('ds_observacao')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-row">

                    <div class="form-group half">
                        <label for="ie_status">
                            Status
                            <i class="fa-solid fa-circle-info info-icon" title="Tabela: dominios | Atributo: ie_status"></i>
                        </label>
                        <select id="ie_status"
                                name="ie_status"
                                class="form-select @error('ie_status') is-invalid @enderror"
                                required>
                            <option value="A" {{ old('ie_status', $dominio->ie_status ?? '') == 'A' ? 'selected' : '' }}>Ativo</option>
                            <option value="E" {{ old('ie_status', $dominio->ie_status ?? '') == 'E' ? 'selected' : '' }}>Expirado</option>
                            <option value="I" {{ old('ie_status', $dominio->ie_status ?? '') == 'I' ? 'selected' : '' }}>Inativo</option>
                        </select>
                        @error('ie_status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <a href="{{ route('dominios.index') }}" class="btn btn-secondary">Cancelar</a>
                    
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

// 🔥 Máscara de IP removida
// function formatIP(input) { ... }  ← Removido



(function () {
  function getFocusableElements(container = document) {
    return Array.from(
      container.querySelectorAll(
        'a[href], button:not([disabled]), input:not([disabled]):not([type="hidden"]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])'
      )
    ).filter(el => el.offsetParent !== null);
  }

  document.addEventListener('keydown', function (e) {
    if (e.key !== 'Tab') return;

    const active = document.activeElement;
    if (!active) return;

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
