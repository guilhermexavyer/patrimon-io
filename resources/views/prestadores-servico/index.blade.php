@extends('layouts.app')

@section('title', 'Prestadores de Serviço')

@section('styles')
<link href="{{ asset('css/index.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="usuarios-container">
    <div class="usuarios-header">
        <h2>Prestadores de Serviço</h2>

        <div class="usuarios-actions">
            <form action="{{ route('prestadores-servico.index') }}" method="GET" class="usuarios-search">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Pesquisar por nome, CPF ou CNPJ" class="form-control">
                <button type="submit" class="btn btn-primary btn-search"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>

            <a href="{{ route('prestadores-servico.create') }}" class="btn btn-success">Adicionar</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger mt-3">{{ session('error') }}</div>
    @endif

    @if($prestadores->count())
    <div class="table-container mt-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Sequência</th>
                        <th>Tipo</th>
                        <th>Nome</th>
                        <th>CPF/CNPJ</th>
                        <th>Telefone</th>
                        <th>Email</th>
                        <th>Atualização</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($prestadores as $p)
                    <tr>
                        <td>
                            @if($p->ie_status === 'A')
                                <i class="fa-solid fa-circle status-ativo" title="Ativo"></i>
                            @else
                                <i class="fa-solid fa-circle status-inativo" title="Inativo"></i>
                            @endif
                        </td>
                        <td>{{ $p->nr_sequencia }}</td>
                        <td>{{ $p->ie_tipo }}</td>
                        <td>{{ $p->ie_tipo == 'PF' ? $p->ds_nome : $p->nm_fantasia }}</td>
                        <td>{{ $p->ie_tipo == 'PF' ? $p->cpf : $p->cnpj }}</td>
                        <td>{{ $p->nr_telefone }}</td>
                        <td>{{ $p->ds_email }}</td>
                        <td>{{ $p->dt_atualizacao?->format('d/m/Y H:i') }}</td>
                        <td class="usuarios-acoes">
                            <a href="{{ route('prestadores-servico.edit', $p->nr_sequencia) }}" class="btn btn-sm btn-primary"><i class="fa-solid fa-square-pen"></i></a>
                            <form action="{{ route('prestadores-servico.destroy', $p->nr_sequencia) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Confirma exclusão do prestador de serviço?');">
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
        <div class="alert alert-info text-center mt-4">Nenhum prestador de serviço encontrado.</div>
    @endif
</div>
@endsection
