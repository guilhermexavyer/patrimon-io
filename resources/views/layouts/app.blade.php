<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Patrimon.io</title>

    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/login/icone3.ico') }}">
    @stack('styles')
    @yield('styles')
</head>
@php
    $user = auth()->user();
    $isAtivo = $user && $user->ie_status === 'A';
    $currentRoute = request()->route()->getName();
@endphp

@if($isAtivo)
<body>
    <header class="cabecalho">
        <div class="cabecalho-patrimonio">
            <a href="{{ route('dashboard') }}" class="logo">
                <i class="fa-solid fa-box-open"></i>
                patrimon.io
            </a>
        </div>

        <div class="cabecalho-usuario">
            <span>
                <i class="fa-solid fa-circle-user"></i>&nbsp;&nbsp;{{ auth()->user()->ds_nome ?? 'Guest' }}
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </span>
            <form method="POST" action="{{ route('logout') }}" class="m-0">
                @csrf
                <button title="Sair"><i class="fa-solid fa-arrow-right-from-bracket"></i></button>
            </form>
        </div>
    </header>

    <!-- Menu lateral -->
    <nav id="menu-lateral" class="menu-lateral" aria-label="Main navigation">
        @php
            $user = auth()->user();
            $isAdmin = $user && $user->ie_acesso === 'A';
            $currentRoute = request()->route()->getName();
        @endphp

        <p class="paragrafo-1">Operação</p>
        <a href="{{ route('dashboard') }}" class="menu-lateral-funcao {{ $currentRoute === 'dashboard' ? 'active' : '' }}">
            <span><i class="fas fa-tachometer-alt"></i></span>
            Dashboard
        </a>
        <a href="{{ route('ativos.index') }}" class="menu-lateral-funcao {{ str_starts_with($currentRoute, 'ativos.') ? 'active' : '' }}">
            <span><i class="fas fa-cubes"></i></span>
            Ativos
        </a>
        <a href="{{ route('dominios.index') }}" class="menu-lateral-funcao {{ str_starts_with($currentRoute, 'dominios.') ? 'active' : '' }}">
            <span><i class="fas fa-globe"></i></span>
            Domínios
        </a>
        <a href="{{ route('licencas.index') }}" class="menu-lateral-funcao {{ str_starts_with($currentRoute, 'licencas.') ? 'active' : '' }}">
            <span><i class="fas fa-key"></i></span>
            Licenças
        </a>
        <a href="{{ route('manutencoes.index') }}" class="menu-lateral-funcao {{ str_starts_with($currentRoute, 'manutencoes.') ? 'active' : '' }}">
            <span><i class="fas fa-tools"></i></span>
            Manutenções
        </a>
        <a href="{{ route('relatorios.index') }}" class="menu-lateral-funcao {{ str_starts_with($currentRoute, 'relatorios.') ? 'active' : '' }}">
            <span><i class="fa-solid fa-print"></i></span>
            Relatórios
        </a>
        
        @if($isAdmin)
        <p class="paragrafo-2">Administração</p>
            <a href="{{ route('categorias-ativos.index') }}" class="menu-lateral-funcao {{ str_starts_with($currentRoute, 'categorias-ativos.') ? 'active' : '' }}">
                <span><i class="fas fa-tags"></i></span>
                Categorias de Ativos
            </a>
            <a href="{{ route('categorias-licencas.index') }}" class="menu-lateral-funcao {{ str_starts_with($currentRoute, 'categorias-licencas.') ? 'active' : '' }}">
                <span><i class="fas fa-tags"></i></span>
                Categorias de Licenças
            </a>
            <a href="{{ route('fornecedores.index') }}" class="menu-lateral-funcao {{ str_starts_with($currentRoute, 'fornecedores.') ? 'active' : '' }}">
                <span><i class="fa-solid fa-cart-shopping"></i></span>
                Fornecedores
            </a>
            <a href="{{ route('localizacoes.index') }}" class="menu-lateral-funcao {{ str_starts_with($currentRoute, 'localizacoes.') ? 'active' : '' }}">
                <span><i class="fa-solid fa-map"></i></span>
                Localizações
            </a>
            <a href="{{ route('prestadores-servico.index') }}" class="menu-lateral-funcao {{ str_starts_with($currentRoute, 'prestadores-servico.') ? 'active' : '' }}">
                <span><i class="fas fa-handshake"></i></span>
                Prestadores de Serviço
            </a>
            <a href="{{ route('usuarios.index') }}" class="menu-lateral-funcao {{ str_starts_with($currentRoute, 'usuarios.') ? 'active' : '' }}">
                <span><i class="fa-solid fa-users"></i></span>
                Usuários
            </a>
        @endif
    </nav>

    <main id="conteudo" class="conteudo">
        @yield('content')
    </main>

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

    <script>
        (function () {
            const btn = document.getElementById('btn-sidebar-toggle');
            const sidebar = document.getElementById('menu-lateral');
            const content = document.getElementById('conteudo');

            btn.addEventListener('click', () => {
                const isOpen = sidebar.classList.contains('open');
                if (isOpen) {
                    sidebar.classList.remove('open');
                } else {
                    sidebar.classList.add('open');
                }
            });

            document.addEventListener('click', (ev) => {
                if (window.innerWidth <= 991) {
                    const target = ev.target;
                    if (!sidebar.contains(target) && !btn.contains(target)) {
                        sidebar.classList.remove('open');
                    }
                }
            });

            function adjustForResize(){
                if (window.innerWidth <= 991) {
                    content.classList.add('sidebar-hidden');
                } else {
                    content.classList.remove('sidebar-hidden');
                    sidebar.classList.remove('open');
                }
            }
            window.addEventListener('resize', adjustForResize);
            adjustForResize();
        })();
    </script>

    @stack('scripts')
    @yield('scripts')
</body>

@else

<body class="body2">
    <div class="login-container">
        <div class="login-cabecalho">
            <i class="fa-solid fa-box-open"></i>
            <h1>PATRIMON.IO</h1>
        </div>

        <div class="login-mensagem">
            <h1>Usuário Bloqueado</h1>
            <h3>Contate o administrador</h3>
        </div>

        <form method="POST" action="{{ route('logout') }}" autocomplete="off">
            @csrf
            <button type="submit">Voltar</button>
        </form>

        <div class="login-rodape">
            <p>Patrimon.io &copy; {{ date('Y') }} - Todos os direitos reservados</p>
        </div>
    </div>

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
</body>
@endif
</html>
