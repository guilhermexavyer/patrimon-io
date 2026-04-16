@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Cadastrar</h2>

    <form action="{{ route('dominios.store') }}" method="POST" novalidate>
        @include('dominios.form')
    </form>
</div>
@endsection
