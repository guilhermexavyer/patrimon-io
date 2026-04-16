@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Editar Fornecedor</h2>
    <form action="{{ route('fornecedores.update', $fornecedor->nr_sequencia) }}" method="POST" novalidate>
        @csrf
        @method('PUT')
        @include('fornecedores.form')
    </form>
</div>
@endsection
