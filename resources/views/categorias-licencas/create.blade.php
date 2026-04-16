@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Cadastrar</h2>

    <form action="{{ route('categorias-licencas.store') }}" method="POST" novalidate>
        @include('categorias-licencas.form')
    </form>
</div>
@endsection
