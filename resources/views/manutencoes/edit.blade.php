@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Editar Manutenção</h2>
    <form action="{{ route('manutencoes.update', $manutencao->nr_sequencia) }}" method="POST" novalidate>
        @csrf
        @method('PUT')
        @include('manutencoes.form')
    </form>
</div>
@endsection
