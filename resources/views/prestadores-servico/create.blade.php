@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Cadastrar Prestador de Serviço</h2>
    <form action="{{ route('prestadores-servico.store') }}" method="POST" novalidate>
        @csrf
        @include('prestadores-servico.form')
    </form>
</div>
@endsection
