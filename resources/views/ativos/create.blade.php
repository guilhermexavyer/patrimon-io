@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Cadastrar Ativo</h2>
    <form action="{{ route('ativos.store') }}" method="POST" novalidate>
        @csrf
        @include('ativos.form')
    </form>
</div>
@endsection
