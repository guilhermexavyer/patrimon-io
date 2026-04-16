@extends('layouts.app')

@section('title', isset($fornecedor) ? 'Editar fornecedor' : 'Cadastrar fornecedor')

@section('styles')
    <link href="{{ asset('css/form.css') }}" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a2e0e6ad3d.js" crossorigin="anonymous"></script>
@endsection

@section('content')
<div class="usuarios-container">
    <!-- Cabeçalho -->
    <div class="usuarios-header">
        <h2>{{ isset($fornecedor) ? 'Editar fornecedor' : 'Cadastrar fornecedor' }}</h2>
    </div>

    <!-- Mensagem de sucesso -->
    @if(session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif

    <!-- Formulário -->
    <div class="form-wrapper mt-4">
        <form action="{{ isset($fornecedor) ? route('fornecedores.update', $fornecedor->nr_sequencia) : route('fornecedores.store') }}"
              method="POST" autocomplete="off">
            @csrf
            @if(isset($fornecedor))
                @method('PUT')
            @endif

            <div class="form-section">

                <!-- Tipo e sequência -->
                <div class="form-row">
                    <div class="form-group half">
                        <label for="nr_sequencia">
                            <i class="fa-solid fa-asterisk icone-obrigatorio"></i>
                            Sequência
                            <i class="fa-solid fa-circle-info info-icon" title="Tabela: fornecedores | Atributo: nr_sequencia"></i>
                        </label>
                        <input type="text" id="nr_sequencia" name="nr_sequencia"
                               class="input-desabled form-control"
                               value="{{ old('nr_sequencia', $fornecedor->nr_sequencia ?? '') }}" disabled>
                    </div>

                    <div class="form-group half">
                        <label for="ie_tipo">
                            <i class="fa-solid fa-asterisk icone-obrigatorio"></i>
                            Tipo de Pessoa
                            <i class="fa-solid fa-circle-info info-icon" title="Tabela: fornecedores | Atributo: ie_tipo"></i>
                        </label>
                        <select id="ie_tipo" name="ie_tipo"
                                class="form-control @error('ie_tipo') is-invalid @enderror"
                                required onchange="togglePessoaTipo()">
                            <option value="">---</option>
                            <option value="PF" {{ old('ie_tipo', $fornecedor->ie_tipo ?? '') == 'PF' ? 'selected' : '' }}>Pessoa Física</option>
                            <option value="PJ" {{ old('ie_tipo', $fornecedor->ie_tipo ?? '') == 'PJ' ? 'selected' : '' }}>Pessoa Jurídica</option>
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
                                <i class="fa-solid fa-circle-info info-icon" title="Tabela: fornecedores | Atributo: ds_nome"></i>
                            </label>
                            <input type="text" id="ds_nome" name="ds_nome"
                                   class="form-control"
                                   value="{{ old('ds_nome', $fornecedor->ds_nome ?? '') }}">
                        </div>

                        <div class="form-group half">
                            <label for="cpf">
                                <i class="fa-solid fa-asterisk icone-obrigatorio"></i>
                                CPF
                                <i class="fa-solid fa-circle-info info-icon" title="Tabela: fornecedores | Atributo: cpf"></i>
                            </label>
                            <input maxlength="14" type="text" id="cpf" name="cpf"
                                   class="form-control"
                                   value="{{ old('cpf', $fornecedor->cpf ?? '') }}"
                                   oninput="mascaraCPF(this)">
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
                                <i class="fa-solid fa-circle-info info-icon" title="Tabela: fornecedores | Atributo: ds_razao_social"></i>
                            </label>
                            <input type="text" id="ds_razao_social" name="ds_razao_social"
                                   class="form-control"
                                   value="{{ old('ds_razao_social', $fornecedor->ds_razao_social ?? '') }}">
                        </div>

                        <div class="form-group half">
                            <label for="nm_fantasia">
                                <i class="fa-solid fa-asterisk icone-obrigatorio"></i>
                                Nome Fantasia
                                <i class="fa-solid fa-circle-info info-icon" title="Tabela: fornecedores | Atributo: nm_fantasia"></i>
                            </label>
                            <input type="text" id="nm_fantasia" name="nm_fantasia"
                                   class="form-control"
                                   value="{{ old('nm_fantasia', $fornecedor->nm_fantasia ?? '') }}">
                        </div>

                        <div class="form-group half">
                            <label for="cnpj">
                                <i class="fa-solid fa-asterisk icone-obrigatorio"></i>
                                CNPJ
                                <i class="fa-solid fa-circle-info info-icon" title="Tabela: fornecedores | Atributo: cnpj"></i>
                            </label>
                            <input maxlength="18" type="text" id="cnpj" name="cnpj"
                                   class="form-control"
                                   value="{{ old('cnpj', $fornecedor->cnpj ?? '') }}"
                                   oninput="mascaraCNPJ(this)">
                        </div>
                    </div>
                </div>

                <!-- Comuns -->
                <div class="form-row">
                    <div class="form-group half">
                        <label for="nr_telefone">Telefone
                            <i class="fa-solid fa-circle-info info-icon" title="Tabela: fornecedores | Atributo: nr_telefone"></i>
                        </label>
                        <input type="text" id="nr_telefone" name="nr_telefone"
                               class="form-control"
                               value="{{ old('nr_telefone', $fornecedor->nr_telefone ?? '') }}"
                               oninput="mascaraTelefone(this)">
                    </div>

                    <div class="form-group half">
                        <label for="ds_email">Email
                            <i class="fa-solid fa-circle-info info-icon" title="Tabela: fornecedores | Atributo: ds_email"></i>
                        </label>
                        <input type="email" id="ds_email" name="ds_email"
                               class="form-control"
                               value="{{ old('ds_email', $fornecedor->ds_email ?? '') }}">
                    </div>
                </div>

                <div class="form-group">
                    <label for="ds_endereco">Endereço
                        <i class="fa-solid fa-circle-info info-icon" title="Tabela: fornecedores | Atributo: ds_endereco"></i>
                    </label>
                    <input type="text" id="ds_endereco" name="ds_endereco"
                           class="form-control"
                           value="{{ old('ds_endereco', $fornecedor->ds_endereco ?? '') }}">
                </div>

                <div class="form-group">
                    <label for="ds_observacao">Observação
                        <i class="fa-solid fa-circle-info info-icon" title="Tabela: fornecedores | Atributo: ds_observacao"></i>
                    </label>
                    <textarea id="ds_observacao" name="ds_observacao" rows="3"
                              class="form-control">{{ old('ds_observacao', $fornecedor->ds_observacao ?? '') }}</textarea>
                </div>

                <div class="form-row">
                    <div class="form-group half">
                        <label for="ie_status">
                            Status
                            <i class="fa-solid fa-circle-info info-icon" title="Tabela: fornecedores | Atributo: ie_status"></i>
                        </label>
                        <select id="ie_status" name="ie_status"
                                class="form-select" required>
                            <option value="A" {{ old('ie_status', $fornecedor->ie_status ?? '') == 'A' ? 'selected' : '' }}>Ativo</option>
                            <option value="I" {{ old('ie_status', $fornecedor->ie_status ?? '') == 'I' ? 'selected' : '' }}>Inativo</option>
                        </select>
                    </div>
                </div>

                <!-- Botões -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <a href="{{ route('fornecedores.index') }}" class="btn btn-secondary">Cancelar</a>
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

    // Esconde tudo
    pf.style.display = 'none';
    pj.style.display = 'none';

    // Remove obrigatoriedade
    document.querySelectorAll('#pf-fields input, #pj-fields input').forEach(el => el.required = false);

    if (tipo === 'PF') {
        pf.style.display = 'block';
        document.getElementById('ds_nome').required = true;
        document.getElementById('cpf').required = true;
    } else if (tipo === 'PJ') {
        pj.style.display = 'block';
        document.getElementById('ds_razao_social').required = true;
        document.getElementById('nm_fantasia').required = true;
        document.getElementById('cnpj').required = true;
    }
}

// Máscara CPF
function mascaraCPF(input) {
    let v = input.value.replace(/\D/g, '');
    v = v.replace(/(\d{3})(\d)/, '$1.$2');
    v = v.replace(/(\d{3})(\d)/, '$1.$2');
    v = v.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
    input.value = v;
}

// Máscara CNPJ
function mascaraCNPJ(input) {
    let v = input.value.replace(/\D/g, '');
    v = v.replace(/^(\d{2})(\d)/, '$1.$2');
    v = v.replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3');
    v = v.replace(/\.(\d{3})(\d)/, '.$1/$2');
    v = v.replace(/(\d{4})(\d)/, '$1-$2');
    input.value = v;
}

// Máscara Telefone
function mascaraTelefone(input) {
    let v = input.value.replace(/\D/g, '');
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

// Executa ao carregar (caso edição)
window.addEventListener('DOMContentLoaded', togglePessoaTipo);
</script>
@endsection
