@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Editar</h2>
    <h3>Sequência: {{ $licenca->nr_sequencia }}</h3>

    <form action="{{ route('licencas.update', $licenca->nr_sequencia) }}" method="POST" novalidate>
        @method('PUT')
        @include('licencas.form')
    </form>
</div>
@endsection
