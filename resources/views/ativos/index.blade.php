@extends('layouts.app')

@section('title', 'Ativos')

@section('styles')
    <link href="{{ asset('css/index.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="usuarios-container">
    <div class="usuarios-header">
        <h2>Ativos</h2>

        <div class="usuarios-actions">
            <form action="{{ route('ativos.index') }}" method="GET" class="usuarios-search">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Pesquisar por nome, série ou patrimônio" class="form-control">
                <button type="submit" class="btn btn-primary btn-search"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>

            <a href="{{ route('ativos.create') }}" class="btn btn-success">Adicionar</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger mt-3">{{ session('error') }}</div>
    @endif

    @if($ativos->count())
    <div class="table-container mt-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Sequência</th>
                        <th>Patrimônio</th>
                        <th>Nome</th>
                        <th>Série</th>
                        <th>Modelo</th>
                        <th>Categoria</th>
                        <th>Valor</th>
                        <th>Atualização</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ativos as $ativo)
                    <tr>
                        <td>
                            @if($ativo->ie_status === 'A')
                                <i class="fa-solid fa-circle status-ativo" title="Ativo"></i>
                            @elseif($ativo->ie_status === 'M')
                                <i class="fa-solid fa-circle status-manutencao" title="Em manutenção"></i>
                            @elseif($ativo->ie_status === 'I')
                                <i class="fa-solid fa-circle status-inativo" title="Inativo"></i>
                            @else
                                <i class="fa-solid fa-circle status-descartado" title="Descartado"></i>
                            @endif
                        </td>
                        <td>{{ $ativo->nr_sequencia }}</td>
                        <td>{{ $ativo->cd_patrimonio }}</td>
                        <td>{{ $ativo->ds_nome }}</td>
                        <td>{{ $ativo->nr_serie }}</td>
                        <td>{{ $ativo->ds_modelo }}</td>
                        <td>{{ $ativo->categoria->ds_nome ?? '' }}</td>
                        <td>{{ number_format($ativo->vl_aquisicao, 2, ',', '.') }}</td>
                        <td>{{ $ativo->dt_atualizacao ? $ativo->dt_atualizacao->format('d/m/Y H:i') : '' }}</td>
                        <td class="usuarios-acoes">
                            {{-- Botão editar --}}
                            <a href="{{ route('ativos.edit', $ativo->nr_sequencia) }}" class="btn btn-sm btn-primary" title="Editar">
                                <i class="fa-solid fa-square-pen"></i>
                            </a>

                            {{-- Botão excluir --}}
                            <form action="{{ route('ativos.destroy', $ativo->nr_sequencia) }}" method="POST" class="d-inline" onsubmit="return confirm('Confirma exclusão do ativo?');">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" type="submit" title="Excluir">
                                    <i class="fa-solid fa-square-xmark"></i>
                                </button>
                            </form>

                            {{-- Botão ENVIAR PARA MANUTENÇÃO (somente se ativo) --}}
                            @if($ativo->ie_status === 'A')
                                <a href="{{ route('manutencoes.create', ['ativo' => $ativo->nr_sequencia]) }}"
                                   class="btn btn-sm btn-warning"
                                   title="Enviar para manutenção">
                                    <i class="fa-solid fa-screwdriver-wrench"></i>
                                </a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @else
        <div class="alert alert-info text-center mt-4">Nenhum ativo encontrado.</div>
    @endif
</div>
@endsection
