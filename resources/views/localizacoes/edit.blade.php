@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Editar</h2>
    <h3>Sequência: {{ $localizacao->nr_sequencia }}</h3>

    <form action="{{ route('localizacoes.update', $localizacao->nr_sequencia) }}" method="POST" novalidate>
        @method('PUT')
        @include('localizacoes.form')
    </form>
</div>
@endsection
