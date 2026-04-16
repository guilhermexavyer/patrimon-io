<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patrimon.io</title>

    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/login/icone3.ico') }}">
</head>
<body>
    <div class="login-container">
        <div class="login-cabecalho">
            <i class="fa-solid fa-box-open"></i>
            <h1>PATRIMON.IO</h1>
        </div>

        <form method="POST" action="{{ route('login.submit') }}" autocomplete="off">
            @csrf
            <div>
                <input type="email" id="email" name="email" placeholder="Usuário" value="{{ old('email') }}" required autofocus>
            </div>

            <div>
                <input type="password" id="password" name="password" placeholder="Senha" required>
            </div>

            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <p class="mensagem-erro">{{ $error }}</p>
                @endforeach
            @endif

            <button type="submit">Entrar</button>
        </form>

        <div class="login-rodape">
            <p>Patrimon.io &copy; {{ date('Y') }} - Todos os direitos reservados</p>
        </div>
    </div>

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
