@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Editar</h2>
    <h3>Sequência: {{ $usuario->nr_sequencia }}</h3>

    <form action="{{ route('usuarios.update', $usuario->nr_sequencia) }}" method="POST" novalidate>
        @method('PUT')
        @include('usuarios.form')
    </form>
</div>
@endsection
