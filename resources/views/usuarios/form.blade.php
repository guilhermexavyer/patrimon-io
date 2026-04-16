@extends('layouts.app')

@section('title', isset($usuario) ? 'Editar usuário' : 'Cadastrar usuário')

@section('styles')
    <link href="{{ asset('css/form.css') }}" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a2e0e6ad3d.js" crossorigin="anonymous"></script>
@endsection

@section('content')
<div class="usuarios-container">

    <!-- Cabeçalho da página -->
    <div class="usuarios-header">
        <h2>{{ isset($usuario) ? 'Editar usuário' : 'Cadastrar usuário' }}</h2>
    </div>

    <!-- Mensagens de sucesso -->
    @if(session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif

    <!-- Formulário -->
    <div class="form-wrapper mt-4">
        <form action="{{ isset($usuario) ? route('usuarios.update', $usuario->nr_sequencia) : route('usuarios.store') }}"
              method="POST" autocomplete="off">
            @csrf
            @if(isset($usuario))
                @method('PUT')
            @endif

            <div class="form-section">
                <div class="form-row">
                    <div class="form-group half">
                        <label for="nr_sequencia">
                            Sequência
                            <i class="fa-solid fa-circle-info info-icon" title="Tabela: usuarios | Atributo: nr_sequencia"></i>
                        </label>
                        <input type="text"
                            id="nr_sequencia"
                            name="nr_sequencia"
                            class="input-desabled form-control @error('nr_sequencia') is-invalid @enderror"
                            value="{{ old('nr_sequencia', $usuario->nr_sequencia ?? '') }}"
                            required disabled>
                        @error('nr_sequencia')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group half">
                        <label for="ds_nome">
                            Nome
                            <i class="fa-solid fa-circle-info info-icon" title="Tabela: usuarios | Atributo: ds_nome"></i>
                        </label>
                        <input type="text"
                            id="ds_nome"
                            name="ds_nome"
                            class="form-control @error('ds_nome') is-invalid @enderror"
                            value="{{ old('ds_nome', $usuario->ds_nome ?? '') }}"
                            required>
                        @error('ds_nome')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group half">
                        <label for="ds_usuario">
                            Usuário
                            <i class="fa-solid fa-circle-info info-icon" title="Tabela: usuarios | Atributo: ds_usuario"></i>
                        </label>
                        <input type="email"
                            id="ds_usuario"
                            name="ds_usuario"
                            class="form-control @error('ds_usuario') is-invalid @enderror"
                            value="{{ old('ds_usuario', $usuario->ds_usuario ?? '') }}"
                            required>
                        @error('ds_usuario')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group half">
                        <label for="ds_senha">
                            {{ isset($usuario) ? 'Nova Senha' : 'Senha' }}
                            <i class="fa-solid fa-circle-info info-icon" title="Tabela: usuarios | Atributo: ds_senha"></i>
                        </label>
                        <input type="password"
                            id="ds_senha"
                            name="ds_senha"
                            class="form-control @error('ds_senha') is-invalid @enderror"
                            {{ isset($usuario) ? '' : 'required' }}>
                        @error('ds_senha')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group half">
                        <label for="ds_senha_confirmation">
                            {{ isset($usuario) ? 'Confirme a nova senha' : 'Confirme a senha' }}
                            <i class="fa-solid fa-circle-info info-icon" title="Tabela: usuarios | Atributo: ds_senha"></i>
                        </label>
                        <input type="password"
                            id="ds_senha_confirmation"
                            name="ds_senha_confirmation"
                            class="form-control"
                            {{ isset($usuario) ? '' : 'required' }}>
                    </div>
                </div>

                <div class="form-group">
                    <label for="ds_observacao">
                        Observação
                        <i class="fa-solid fa-circle-info info-icon" title="Tabela: usuarios | Atributo: ds_observacao"></i>
                    </label>
                    <textarea id="ds_observacao"
                              name="ds_observacao"
                              rows="3"
                              class="form-control @error('ds_observacao') is-invalid @enderror">{{ old('ds_observacao', $usuario->ds_observacao ?? '') }}</textarea>
                    @error('ds_observacao')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="form-group half">
                        <label for="ie_acesso">
                            Nível de Acesso
                            <i class="fa-solid fa-circle-info info-icon" title="Tabela: usuarios | Atributo: ie_acesso"></i>
                        </label>
                        <select id="ie_acesso"
                                name="ie_acesso"
                                class="form-select @error('ie_acesso') is-invalid @enderror"
                                required>
                            <option value="P" {{ old('ie_acesso', $usuario->ie_acesso ?? '') == 'P' ? 'selected' : '' }}>Padrão</option>
                            <option value="A" {{ old('ie_acesso', $usuario->ie_acesso ?? '') == 'A' ? 'selected' : '' }}>Administrador</option>
                        </select>
                        @error('ie_acesso')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group half">
                        <label for="ie_status">
                            Status
                            <i class="fa-solid fa-circle-info info-icon" title="Tabela: usuarios | Atributo: ie_status"></i>
                        </label>
                        <select id="ie_status"
                                name="ie_status"
                                class="form-select @error('ie_status') is-invalid @enderror"
                                required>
                            <option value="A" {{ old('ie_status', $usuario->ie_status ?? '') == 'A' ? 'selected' : '' }}>Ativo</option>
                            <option value="I" {{ old('ie_status', $usuario->ie_status ?? '') == 'I' ? 'selected' : '' }}>Inativo</option>
                        </select>
                        @error('ie_status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Cancelar</a>
                    
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
