@extends('layouts.app')

@section('title', 'Domínios')

@section('styles')
    <link href="{{ asset('css/index.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="usuarios-container">
    <div class="usuarios-header">
        <h2>Domínios</h2>

        <div class="usuarios-actions">
            <form action="{{ route('dominios.index') }}" method="GET" class="usuarios-search">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Pesquisar por nome, url ou registro" class="form-control">
                <button type="submit" class="btn btn-primary btn-search"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>

            <a href="{{ route('dominios.create') }}" class="btn btn-success">Adicionar</a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif

    @if($dominios->count())
    <div class="table-container mt-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Sequência</th>
                        <th>Nome</th>
                        <th>URL</th>
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
                    @foreach($dominios as $dominio)
                    <tr>
                        <td>
                            @if($dominio->ie_status === 'A')
                                <i class="fa-solid fa-circle status-ativo" title="Ativo"></i>
                            @elseif($dominio->ie_status === 'E')
                                <i class="fa-solid fa-circle status-expirado" title="Expirado"></i>
                            @else
                                <i class="fa-solid fa-circle status-inativo" title="Inativo"></i>
                            @endif
                        </td>
                        <td>{{ $dominio->nr_sequencia }}</td>
                        <td>{{ $dominio->ds_nome }}</td>
                        <td>{{ $dominio->ds_url }}</td>
                        <td>{{ $dominio->nr_registro }}</td>
                        <td>{{ $dominio->dt_inicio_vigencia ? $dominio->dt_inicio_vigencia->format('d/m/Y') : '' }}</td>
                        <td>{{ $dominio->dt_fim_vigencia ? $dominio->dt_fim_vigencia->format('d/m/Y') : '' }}</td>
                        <td>{{ $dominio->vl_aquisicao }}</td>
                        <td>{{ $dominio->vl_mensal }}</td>
                        <td>{{ $dominio->dt_atualizacao ? $dominio->dt_atualizacao->format('d/m/Y H:i') : '' }}</td>
                        <td class="usuarios-acoes">
                            <a href="{{ route('dominios.edit', $dominio->nr_sequencia) }}" class="btn btn-sm btn-primary"><i class="fa-solid fa-square-pen"></i></a>
                            <form action="{{ route('dominios.destroy', $dominio->nr_sequencia) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Confirma exclusão do domínio?');">
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
        <div class="alert alert-info text-center mt-4">Nenhum domínio encontrado.</div>
    @endif
</div>
@endsection
