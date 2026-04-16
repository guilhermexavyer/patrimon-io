@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Editar</h2>
    <h3>Sequência: {{ $dominio->nr_sequencia }}</h3>

    <form action="{{ route('dominios.update', $dominio->nr_sequencia) }}" method="POST" novalidate>
        @method('PUT')
        @include('dominios.form')
    </form>
</div>
@endsection
