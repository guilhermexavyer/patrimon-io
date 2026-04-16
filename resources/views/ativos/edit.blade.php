@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Editar Prestador de Serviço</h2>
    <form action="{{ route('ativos.update', $prestador->nr_sequencia) }}" method="POST" novalidate>
        @csrf
        @method('PUT')
        @include('ativos.form')
    </form>
</div>
@endsection
