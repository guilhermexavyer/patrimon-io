@extends('layouts.app')

@section('title', 'Localização')

@section('styles')
    <link href="{{ asset('css/index.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="usuarios-container">
    <div class="usuarios-header">
        <h2>Localizações</h2>

        <div class="usuarios-actions">
            <form action="{{ route('localizacoes.index') }}" method="GET" class="usuarios-search">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Pesquisar por nome" class="form-control">
                <button type="submit" class="btn btn-primary btn-search"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>

            <a href="{{ route('localizacoes.create') }}" class="btn btn-success">Adicionar</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger mt-3">{{ session('error') }}</div>
    @endif

    @if($localizacoes->count())
    <div class="table-container mt-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Sequência</th>
                        <th>Nome</th>
                        <th>Atualização</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($localizacoes as $localizacao)
                    <tr>
                        <td>
                            @if($localizacao->ie_status === 'A')
                                <i class="fa-solid fa-circle status-ativo" title="Ativo"></i>
                            @elseif($localizacao->ie_status === 'E')
                                <i class="fa-solid fa-circle status-expirado" title="Expirado"></i>
                            @else
                                <i class="fa-solid fa-circle status-inativo" title="Inativo"></i>
                            @endif
                        </td>
                        <td>{{ $localizacao->nr_sequencia }}</td>
                        <td>{{ $localizacao->ds_nome }}</td>
                        <td>{{ $localizacao->dt_atualizacao ? $localizacao->dt_atualizacao->format('d/m/Y H:i') : '' }}</td>
                        <td class="usuarios-acoes">
                            <a href="{{ route('localizacoes.edit', $localizacao->nr_sequencia) }}" class="btn btn-sm btn-primary"><i class="fa-solid fa-square-pen"></i></a>
                            <form action="{{ route('localizacoes.destroy', $localizacao->nr_sequencia) }}" method="POST" class="d-inline"
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
        <div class="alert alert-info text-center mt-4">Nenhuma localização encontrada.</div>
    @endif
</div>
@endsection
