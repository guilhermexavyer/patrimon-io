@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Editar Prestador de Serviço</h2>
    <form action="{{ route('prestadores-servico.update', $prestador->nr_sequencia) }}" method="POST" novalidate>
        @csrf
        @method('PUT')
        @include('prestadores-servico.form')
    </form>
</div>
@endsection
