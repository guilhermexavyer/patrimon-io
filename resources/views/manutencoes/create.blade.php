@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Cadastrar Manutenção</h2>
    <form action="{{ route('manutencoes.store') }}" method="POST" novalidate>
        @csrf
        @include('manutencoes.form')
    </form>
</div>
@endsection
