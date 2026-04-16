<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ativo;
use App\Models\Licenca;
use App\Models\Dominio;
use App\Models\Manutencao;
use App\Models\PrestadorServico;
use App\Models\Fornecedor;
use App\Models\Usuario;
use App\Models\Localizacao;

class DashboardController extends Controller
{
    public function index()
    {
        // Total de ativos
        $totalAtivos = Ativo::count();
        $ativosAtivos = Ativo::where('ie_status', 'A')->count();
        $ativosInativos = Ativo::where('ie_status', 'I')->count();
        $ativosEmManutencao = Ativo::where('ie_status', 'M')->count();
        $ativosDescartados = Ativo::where('ie_status', 'D')->count();

        // Total de licenças
        $totalLicencas = Licenca::count();
        $licencasAtivas = Licenca::where('ie_status', 'A')->count();
        $licencasInativas = Licenca::where('ie_status', 'I')->count();
        $licencasExpiradas = Licenca::where('ie_status', 'E')->count();

        // Total de domínios
        $totalDominios = Dominio::count();
        $dominiosExpirados = Dominio::where('ie_status', 'E')->count();
        $dominiosAtivos = Dominio::where('ie_status', 'A')->count();
        $dominiosInativos = Dominio::where('ie_status', 'I')->count();

        // Total fornecedores
        $totalFornecedores = Fornecedor::count();
        $fornecedoresAtivos = Fornecedor::where('ie_status', 'A')->count();
        $fornecedoresInativos = Fornecedor::where('ie_status', 'I')->count();

        // Total localizações
        $totalLocalizacoes = Localizacao::count();
        $localizacoesAtivas = Localizacao::where('ie_status', 'A')->count();
        $localizacoesInativas = Localizacao::where('ie_status', 'I')->count();

        // Total prestadores de serviço
        $totalPrestadoresServico = PrestadorServico::count();
        $prestadoresServicoAtivos = PrestadorServico::where('ie_status', 'A')->count();
        $prestadoresServicoInativos = PrestadorServico::where('ie_status', 'I')->count();

        // Total usuarios
        $totalUsuarios = Usuario::count();
        $usuariosAtivos = Usuario::where('ie_status', 'A')->count();
        $usuariosInativos = Usuario::where('ie_status', 'I')->count();
        
        // Manutencões em andamento
        $totalManutencoes = Manutencao::count();
        $manutencoesEmAndamento = Manutencao::where('ie_status', 'E')->count();
        $manutencoesConcluidas = Manutencao::where('ie_status', 'C')->count();

        return view('dashboard', compact(
            'totalAtivos', 'ativosAtivos', 'ativosInativos', 'ativosEmManutencao', 'ativosDescartados',
            'totalLicencas', 'licencasAtivas', 'licencasInativas', 'licencasExpiradas',
            'totalDominios', 'dominiosAtivos', 'dominiosInativos', 'dominiosExpirados',
            'totalFornecedores', 'fornecedoresAtivos', 'fornecedoresInativos',
            'totalLocalizacoes', 'localizacoesAtivas', 'localizacoesInativas',
            'totalPrestadoresServico', 'prestadoresServicoAtivos', 'prestadoresServicoInativos',
            'totalUsuarios', 'usuariosAtivos', 'usuariosInativos',
            'totalManutencoes', 'manutencoesEmAndamento', 'manutencoesConcluidas'
        ));
    }
}
