@extends('layouts.app')

@section('title', 'Usuários')

@section('styles')
    <link href="{{ asset('css/index.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="usuarios-container">
    <div class="usuarios-header">
        <h2>Usuários</h2>

        <div class="usuarios-actions">
            <form action="{{ route('usuarios.index') }}" method="GET" class="usuarios-search">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Pesquisar por nome ou usuário" class="form-control">
                <button type="submit" class="btn btn-primary btn-search"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>

            <a href="{{ route('usuarios.create') }}" class="btn btn-success">Adicionar</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif

    @if($usuarios->count())
    <div class="table-container mt-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Sequência</th>
                        <th>Nome</th>
                        <th>Usuário</th>
                        <th>Perfil</th>
                        <th>Atualização</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($usuarios as $usuario)
                    <tr>
                        <td>
                            @if($usuario->ie_status === 'A')
                                <i class="fa-solid fa-circle status-ativo" title="Ativo"></i>
                            @else
                                <i class="fa-solid fa-circle status-inativo" title="Inativo"></i>
                            @endif
                        </td>
                        <td>{{ $usuario->nr_sequencia }}</td>
                        <td>{{ $usuario->ds_nome }}</td>
                        <td>{{ $usuario->ds_usuario }}</td>
                        <td>
                            @if($usuario->ie_acesso === 'A')
                                <span class="badge bg-primary">Administrador</span>
                            @else
                                <span class="badge bg-secondary">Padrão</span>
                            @endif
                        </td>
                        
                        <td>{{ $usuario->dt_atualizacao ? $usuario->dt_atualizacao->format('d/m/Y H:i') : '' }}</td>
                        <td class="usuarios-acoes">
                            <a href="{{ route('usuarios.edit', $usuario->nr_sequencia) }}" class="btn btn-sm btn-primary"><i class="fa-solid fa-square-pen"></i></a>
                            <form action="{{ route('usuarios.destroy', $usuario->nr_sequencia) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Confirma exclusão do usuário?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" type="submit"><i class="fa-solid fa-square-xmark"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @else
        <div class="alert alert-info text-center mt-4">Nenhum usuário encontrado.</div>
    @endif
</div>
@endsection
