@extends('layouts.app')

@section('title', 'Licenças')

@section('styles')
    <link href="{{ asset('css/index.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="usuarios-container">
    <div class="usuarios-header">
        <h2>Licenças</h2>

        <div class="usuarios-actions">
            <form action="{{ route('licencas.index') }}" method="GET" class="usuarios-search">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Pesquisar por nome ou registro" class="form-control">
                <button type="submit" class="btn btn-primary btn-search"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>

            <a href="{{ route('licencas.create') }}" class="btn btn-success">Adicionar</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif

    @if($licencas->count())
    <div class="table-container mt-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Sequência</th>
                        <th>Nome</th>
                        <th>Registro</th>
                        <th>Início Vigência</th>
                        <th>Fim Vigência</th>
                        <th>Valor Aquisição</th>
                        <th>Valor Mensal</th>
                        <th>Atualização</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($licencas as $licenca)
                    <tr>
                        <td>
                            @if($licenca->ie_status === 'A')
                                <i class="fa-solid fa-circle status-ativo" title="Ativa"></i>
                            @elseif($licenca->ie_status === 'E')
                                <i class="fa-solid fa-circle status-expirado" title="Expirada"></i>
                            @else
                                <i class="fa-solid fa-circle status-inativo" title="Inativa"></i>
                            @endif
                        </td>
                        <td>{{ $licenca->nr_sequencia }}</td>
                        <td>{{ $licenca->ds_nome }}</td>
                        <td>{{ $licenca->nr_registro }}</td>
                        <td>{{ $licenca->dt_inicio_vigencia ? $licenca->dt_inicio_vigencia->format('d/m/Y') : '' }}</td>
                        <td>{{ $licenca->dt_fim_vigencia ? $licenca->dt_fim_vigencia->format('d/m/Y') : '' }}</td>
                        <td>{{ $licenca->vl_aquisicao }}</td>
                        <td>{{ $licenca->vl_mensal }}</td>
                        <td>{{ $licenca->dt_atualizacao ? $licenca->dt_atualizacao->format('d/m/Y H:i') : '' }}</td>
                        <td class="usuarios-acoes">
                            <a href="{{ route('licencas.edit', $licenca->nr_sequencia) }}" class="btn btn-sm btn-primary"><i class="fa-solid fa-square-pen"></i></a>
                            <form action="{{ route('licencas.destroy', $licenca->nr_sequencia) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Confirma exclusão da licença?');">
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
        <div class="alert alert-info text-center mt-4">Nenhuma licença encontrada.</div>
    @endif
</div>
@endsection
