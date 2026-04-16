@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Cadastrar</h2>

    <form action="{{ route('usuarios.store') }}" method="POST" novalidate>
        @include('usuarios.form')
    </form>
</div>
@endsection
