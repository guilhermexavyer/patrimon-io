@extends('layouts.app')

@section('title', isset($prestador) ? 'Editar prestador de serviço' : 'Cadastrar prestador de serviço')

@section('styles')
    <link href="{{ asset('css/form.css') }}" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a2e0e6ad3d.js" crossorigin="anonymous"></script>
@endsection

@section('content')
<div class="usuarios-container">

    <!-- Cabeçalho da página -->
    <div class="usuarios-header">
        <h2>{{ isset($prestador) ? 'Editar prestador de serviço' : 'Cadastrar prestador de serviço' }}</h2>
    </div>

    <!-- Mensagem de sucesso -->
    @if(session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif

    <!-- Formulário -->
    <div class="form-wrapper mt-4">
        <form action="{{ isset($prestador) ? route('prestadores-servico.update', $prestador->nr_sequencia) : route('prestadores-servico.store') }}"
              method="POST" autocomplete="off">
            @csrf
            @if(isset($prestador))
                @method('PUT')
            @endif

            <div class="form-section">

                <!-- Tipo e sequência -->
                <div class="form-row">
                    <div class="form-group half">
                        <label for="nr_sequencia">
                            <i class="fa-solid fa-asterisk icone-obrigatorio"></i>
                            Sequência
                            <i class="fa-solid fa-circle-info info-icon" title="Tabela: prestadores_servico | Atributo: nr_sequencia"></i>
                        </label>
                        <input type="text" id="nr_sequencia" name="nr_sequencia"
                               class="input-desabled form-control"
                               value="{{ old('nr_sequencia', $prestador->nr_sequencia ?? '') }}" disabled>
                    </div>

                    <div class="form-group half">
                        <label for="ie_tipo">
                            <i class="fa-solid fa-asterisk icone-obrigatorio"></i>
                            Tipo de Pessoa
                            <i class="fa-solid fa-circle-info info-icon" title="Tabela: prestadores_servico | Atributo: ie_tipo"></i>
                        </label>
                        <select id="ie_tipo" name="ie_tipo"
                                class="form-control @error('ie_tipo') is-invalid @enderror"
                                required onchange="togglePessoaTipo()">
                            <option value="">---</option>
                            <option value="PF" {{ old('ie_tipo', $prestador->ie_tipo ?? '') == 'PF' ? 'selected' : '' }}>Pessoa Física</option>
                            <option value="PJ" {{ old('ie_tipo', $prestador->ie_tipo ?? '') == 'PJ' ? 'selected' : '' }}>Pessoa Jurídica</option>
                        </select>
                        @error('ie_tipo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Pessoa Física -->
                <div id="pf-fields" style="display:none;">
                    <div class="form-row">
                        <div class="form-group half">
                            <label for="ds_nome">
                                <i class="fa-solid fa-asterisk icone-obrigatorio"></i>
                                Nome
                                <i class="fa-solid fa-circle-info info-icon" title="Tabela: prestadores_servico | Atributo: ds_nome"></i>
                            </label>
                            <input type="text" id="ds_nome" name="ds_nome"
                                   class="form-control @error('ds_nome') is-invalid @enderror"
                                   value="{{ old('ds_nome', $prestador->ds_nome ?? '') }}">
                            @error('ds_nome')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group half">
                            <label for="cpf">
                                <i class="fa-solid fa-asterisk icone-obrigatorio"></i>
                                CPF
                                <i class="fa-solid fa-circle-info info-icon" title="Tabela: prestadores_servico | Atributo: cpf"></i>
                            </label>
                            <input maxlength="14" type="text" id="cpf" name="cpf"
                                   class="form-control @error('cpf') is-invalid @enderror"
                                   value="{{ old('cpf', $prestador->cpf ?? '') }}"
                                   oninput="mascaraCPF(this)">
                            @error('cpf')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Pessoa Jurídica -->
                <div id="pj-fields" style="display:none;">
                    <div class="form-row">
                        <div class="form-group half">
                            <label for="ds_razao_social">
                                <i class="fa-solid fa-asterisk icone-obrigatorio"></i>
                                Razão Social
                                <i class="fa-solid fa-circle-info info-icon" title="Tabela: prestadores_servico | Atributo: ds_razao_social"></i>
                            </label>
                            <input type="text" id="ds_razao_social" name="ds_razao_social"
                                   class="form-control @error('ds_razao_social') is-invalid @enderror"
                                   value="{{ old('ds_razao_social', $prestador->ds_razao_social ?? '') }}">
                            @error('ds_razao_social')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group half">
                            <label for="nm_fantasia">
                                <i class="fa-solid fa-asterisk icone-obrigatorio"></i>
                                Nome Fantasia
                                <i class="fa-solid fa-circle-info info-icon" title="Tabela: prestadores_servico | Atributo: nm_fantasia"></i>
                            </label>
                            <input type="text" id="nm_fantasia" name="nm_fantasia"
                                   class="form-control @error('nm_fantasia') is-invalid @enderror"
                                   value="{{ old('nm_fantasia', $prestador->nm_fantasia ?? '') }}">
                            @error('nm_fantasia')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group half">
                            <label for="cnpj">
                                <i class="fa-solid fa-asterisk icone-obrigatorio"></i>
                                CNPJ
                                <i class="fa-solid fa-circle-info info-icon" title="Tabela: prestadores_servico | Atributo: cnpj"></i>
                            </label>
                            <input maxlength="18" type="text" id="cnpj" name="cnpj"
                                   class="form-control @error('cnpj') is-invalid @enderror"
                                   value="{{ old('cnpj', $prestador->cnpj ?? '') }}"
                                   oninput="mascaraCNPJ(this)">
                            @error('cnpj')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Comuns -->
                <div class="form-row">
                    <div class="form-group half">
                        <label for="nr_telefone">Telefone</label>
                        <input type="text" id="nr_telefone" name="nr_telefone"
                               class="form-control @error('nr_telefone') is-invalid @enderror"
                               value="{{ old('nr_telefone', $prestador->nr_telefone ?? '') }}"
                               oninput="mascaraTelefone(this)">
                        @error('nr_telefone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group half">
                        <label for="ds_email">Email</label>
                        <input type="email" id="ds_email" name="ds_email"
                               class="form-control @error('ds_email') is-invalid @enderror"
                               value="{{ old('ds_email', $prestador->ds_email ?? '') }}">
                        @error('ds_email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="ds_endereco">Endereço</label>
                    <input type="text" id="ds_endereco" name="ds_endereco"
                           class="form-control @error('ds_endereco') is-invalid @enderror"
                           value="{{ old('ds_endereco', $prestador->ds_endereco ?? '') }}">
                    @error('ds_endereco')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="ds_observacao">Observação</label>
                    <textarea id="ds_observacao" name="ds_observacao" rows="3"
                              class="form-control @error('ds_observacao') is-invalid @enderror">{{ old('ds_observacao', $prestador->ds_observacao ?? '') }}</textarea>
                    @error('ds_observacao')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="form-group half">
                        <label for="ie_status">
                            Status
                            <i class="fa-solid fa-circle-info info-icon" title="Tabela: prestadores_servico | Atributo: ie_status"></i>
                        </label>
                        <select id="ie_status" name="ie_status"
                                class="form-select @error('ie_status') is-invalid @enderror" required>
                            <option value="A" {{ old('ie_status', $prestador->ie_status ?? '') == 'A' ? 'selected' : '' }}>Ativo</option>
                            <option value="I" {{ old('ie_status', $prestador->ie_status ?? '') == 'I' ? 'selected' : '' }}>Inativo</option>
                        </select>
                        @error('ie_status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Botões -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <a href="{{ route('prestadores-servico.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>

            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
function togglePessoaTipo() {
    const tipo = document.getElementById('ie_tipo').value;
    const pf = document.getElementById('pf-fields');
    const pj = document.getElementById('pj-fields');

    // Esconde ambos
    pf.style.display = 'none';
    pj.style.display = 'none';

    // Remove obrigatoriedade de todos os inputs PF/PJ
    document.querySelectorAll('#pf-fields input, #pj-fields input').forEach(el => {
        el.required = false;
    });

    if (tipo === 'PF') {
        pf.style.display = 'block';
        // tornar obrigatórios somente os campos PF
        const nome = document.getElementById('ds_nome');
        const cpf = document.getElementById('cpf');
        if (nome) nome.required = true;
        if (cpf) cpf.required = true;
        // limpa campos PJ para evitar submissão indevida
        const cnpj = document.getElementById('cnpj');
        if (cnpj) cnpj.value = '';
    } else if (tipo === 'PJ') {
        pj.style.display = 'block';
        // tornar obrigatórios somente os campos PJ
        const razao = document.getElementById('ds_razao_social');
        const fantasia = document.getElementById('nm_fantasia');
        const cnpj = document.getElementById('cnpj');
        if (razao) razao.required = true;
        if (fantasia) fantasia.required = true;
        if (cnpj) cnpj.required = true;
        // limpa campos PF
        const cpf = document.getElementById('cpf');
        if (cpf) cpf.value = '';
    }
}

// Máscara CPF (limita a 11 dígitos e formata)
function mascaraCPF(input) {
    let v = input.value.replace(/\D/g, '').slice(0, 11);
    v = v.replace(/(\d{3})(\d)/, '$1.$2');
    v = v.replace(/(\d{3})(\d)/, '$1.$2');
    v = v.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
    input.value = v;
}

// Máscara CNPJ (limita a 14 dígitos e formata)
function mascaraCNPJ(input) {
    let v = input.value.replace(/\D/g, '').slice(0, 14);
    v = v.replace(/^(\d{2})(\d)/, '$1.$2');
    v = v.replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3');
    v = v.replace(/\.(\d{3})(\d)/, '.$1/$2');
    v = v.replace(/(\d{4})(\d)/, '$1-$2');
    input.value = v;
}

// Máscara Telefone (formata e limita)
function mascaraTelefone(input) {
    let v = input.value.replace(/\D/g, '').slice(0, 11);
    if (v.length > 10) {
        v = v.replace(/^(\d{2})(\d{5})(\d{4}).*/, '($1) $2-$3');
    } else if (v.length > 5) {
        v = v.replace(/^(\d{2})(\d{4})(\d{0,4}).*/, '($1) $2-$3');
    } else if (v.length > 2) {
        v = v.replace(/^(\d{2})(\d{0,5})/, '($1) $2');
    } else {
        v = v.replace(/^(\d*)/, '($1');
    }
    input.value = v;
}

// Ao carregar a página, ajusta a visibilidade conforme o valor (edição)
window.addEventListener('DOMContentLoaded', function() {
    togglePessoaTipo();
});
</script>
@endsection
