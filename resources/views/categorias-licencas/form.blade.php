@extends('layouts.app')

@section('title', isset($categoria) ? 'Editar categoria de licença' : 'Cadastrar categoria de licença')

@section('styles')
    <link href="{{ asset('css/form.css') }}" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a2e0e6ad3d.js" crossorigin="anonymous"></script>
@endsection

@section('content')
<div class="usuarios-container">

    <!-- Cabeçalho da página -->
    <div class="usuarios-header">
        <h2>{{ isset($categoria) ? 'Editar categoria de licença' : 'Cadastrar categoria de licença' }}</h2>
    </div>

    <!-- Mensagens de sucesso -->
    @if(session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif

    <!-- Formulário -->
    <div class="form-wrapper mt-4">
        <form action="{{ isset($categoria) ? route('categorias-licencas.update', $categoria->nr_sequencia) : route('categorias-licencas.store') }}"
              method="POST" autocomplete="off">
            @csrf
            @if(isset($categoria))
                @method('PUT')
            @endif

            <div class="form-section">
                <div class="form-row">
                    <div class="form-group half">
                        <label for="nr_sequencia">
                            Sequência
                            <i class="fa-solid fa-circle-info info-icon" title="Tabela: categorias_licenca | Atributo: nr_sequencia"></i>
                        </label>
                        <input type="text"
                            id="nr_sequencia"
                            name="nr_sequencia"
                            class="input-desabled form-control @error('nr_sequencia') is-invalid @enderror"
                            value="{{ old('nr_sequencia', $categoria->nr_sequencia ?? '') }}"
                            required disabled>
                        @error('nr_sequencia')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group half">
                        <label for="ds_nome">
                            Nome
                            <i class="fa-solid fa-circle-info info-icon" title="Tabela: categorias_licenca | Atributo: ds_nome"></i>
                        </label>
                        <input type="text"
                            id="ds_nome"
                            name="ds_nome"
                            class="form-control @error('ds_nome') is-invalid @enderror"
                            value="{{ old('ds_nome', $categoria->ds_nome ?? '') }}"
                            required>
                        @error('ds_nome')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="ds_observacao">
                        Observação
                        <i class="fa-solid fa-circle-info info-icon" title="Tabela: categorias_licenca | Atributo: ds_observacao"></i>
                    </label>
                    <textarea id="ds_observacao"
                              name="ds_observacao"
                              rows="3"
                              class="form-control @error('ds_observacao') is-invalid @enderror">{{ old('ds_observacao', $categoria->ds_observacao ?? '') }}</textarea>
                    @error('ds_observacao')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-row">

                    <div class="form-group half">
                        <label for="ie_status">
                            Status
                            <i class="fa-solid fa-circle-info info-icon" title="Tabela: categorias_licenca | Atributo: ie_status"></i>
                        </label>
                        <select id="ie_status"
                                name="ie_status"
                                class="form-select @error('ie_status') is-invalid @enderror"
                                required>
                            <option value="A" {{ old('ie_status', $categoria->ie_status ?? '') == 'A' ? 'selected' : '' }}>Ativo</option>
                            <option value="I" {{ old('ie_status', $categoria->ie_status ?? '') == 'I' ? 'selected' : '' }}>Inativo</option>
                        </select>
                        @error('ie_status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <a href="{{ route('categorias-licencas.index') }}" class="btn btn-secondary">Cancelar</a>
                    
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
</script>
@endsection
