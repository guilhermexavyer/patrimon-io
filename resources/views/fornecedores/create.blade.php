@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Cadastrar Fornecedor</h2>
    <form action="{{ route('fornecedores.store') }}" method="POST" novalidate>
        @csrf
        @include('fornecedores.form')
    </form>
</div>
@endsection
