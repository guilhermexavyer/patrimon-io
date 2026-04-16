@extends('layouts.app')

@section('content')
<div class="dashboard-container">
    <div class="dashboard-header">
        <div>
            <h3>Dashboard</h3>
        </div>
        <div class="update-time">
            Atualizado em: {{ now()->format('d/m/Y H:i') }}
        </div>
    </div>

    <div class="dashboard-grid">
        <!-- Ativos -->
        <div class="dashboard-card blue">
            <div class="icon"><i class="fas fa-cubes"></i></div>
            <h6>Ativos</h6>
            <h2>{{ $totalAtivos }}</h2>
            <br>
            <div class="card-dados">
                <div>
                    <span>Ativos: {{ $ativosAtivos }}</span><br>
                    <span>Inativos: {{ $ativosInativos }}</span><br>
                    <span>Descartados: {{ $ativosDescartados }}</span><br>
                </div>
                <div>
                    <span>Em menutenção: {{ $ativosEmManutencao }}</span>
                </div>
            </div>
        </div>

        <!-- Licenças -->
        <div class="dashboard-card green">
            <div class="icon"><i class="fas fa-key"></i></div>
            <h6>Licenças</h6>
            <h2>{{ $totalLicencas }}</h2>
            <br>
            <p>
                <span>Ativas: {{ $licencasAtivas }}</span><br>
                <span>Inativas: {{ $licencasInativas }}</span><br>
                <span>Expiradas: {{ $licencasExpiradas }}</span>
            </p>
        </div>

        <!-- Domínios -->
        <div class="dashboard-card red">
            <div class="icon"><i class="fas fa-globe"></i></div>
            <h6>Domínios</h6>
            <h2>{{ $totalDominios }}</h2>
            <br>
            <p>
                <span>Ativos: {{ $dominiosAtivos }}</span><br>
                <span>Inativos: {{ $dominiosInativos }}</span><br>
                <span>Expirados: {{ $dominiosExpirados }}</span>
            </p>
        </div>

        <!-- Manutenções -->
        <div class="dashboard-card yellow">
            <div class="icon"><i class="fas fa-tools"></i></div>
            <h6>Manutenções</h6>
            <h2>{{ $totalManutencoes }}</h2>
            <br>
            <p>
                <span>Em curso: {{ $manutencoesEmAndamento }}</span><br>
                <span>Concluídas: {{ $manutencoesConcluidas }}</span>
            </p>
        </div>
    </div>

    <div class="dashboard-grid">
        <!-- Fornecedores -->
        <div class="dashboard-card blue">
            <div class="icon"><i class="fa-solid fa-cart-shopping"></i></div>
            <h6>Fornecedores</h6>
            <h2>{{ $totalFornecedores }}</h2>
            <br>
            <p>
                <span>Ativos: {{ $fornecedoresAtivos }}</span><br>
                <span>Inativos: {{ $fornecedoresInativos }}</span>
            </p>
        </div>

        <!-- Localizações -->
        <div class="dashboard-card green">
            <div class="icon"><i class="fa-solid fa-map"></i></div>
            <h6>Localizações</h6>
            <h2>{{ $totalLocalizacoes }}</h2>
            <br>
            <p>
                <span>Ativas: {{ $localizacoesAtivas }}</span><br>
                <span>Inativas: {{ $localizacoesInativas }}</span>
            </p>
        </div>

        <!-- Prestadores de Serviço -->
        <div class="dashboard-card red">
            <div class="icon"><i class="fas fa-handshake"></i></div>
            <h6>Prestadores de Serviço</h6>
            <h2>{{ $totalPrestadoresServico }}</h2>
            <br>
            <p>
                <span>Ativos: {{ $prestadoresServicoAtivos }}</span><br>
                <span>Inativos: {{ $prestadoresServicoInativos }}</span>
            </p>
        </div>

        <!-- Usuários -->
        <div class="dashboard-card yellow">
            <div class="icon"><i class="fa-solid fa-users"></i></div>
            <h6>Usuários</h6>
            <h2>{{ $totalUsuarios }}</h2>
            <br>
            <p>
                <span>Ativos: {{ $usuariosAtivos }}</span><br>
                <span>Inativos: {{ $usuariosInativos }}</span>
            </p>
        </div>
    </div>
</div>
@endsection
