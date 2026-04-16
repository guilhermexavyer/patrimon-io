<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    UsuarioController,
    AtivoController,
    CategoriaAtivoController,
    CategoriaLicencaController,
    FornecedorController,
    LocalizacaoController,
    LicencaController,
    DominioController,
    PrestadorServicoController,
    ManutencaoController,
    RelatorioController,
    DashboardController,
    Auth\LoginController,
    RelatorioAtivoController,
    RelatorioDominioController,
    RelatorioLicencaController,
    RelatorioManutencaoController  // Certifique-se de importar aqui
};


// Página inicial redireciona para dashboard (se autenticado)
Route::get('/', function () {
    return redirect()->route('dashboard');
})->name('home');


// Rotas públicas (login)
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login.submit');


// Rotas protegidas por autenticação
Route::middleware('auth')->group(function () {
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');


    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


    // Recursos CRUD
    Route::resource('usuarios', UsuarioController::class);
    Route::resource('ativos', AtivoController::class);
    Route::resource('categorias-ativos', CategoriaAtivoController::class);
    Route::resource('categorias-licencas', CategoriaLicencaController::class);
    Route::resource('fornecedores', FornecedorController::class);
    Route::resource('localizacoes', LocalizacaoController::class);
    Route::resource('licencas', LicencaController::class);
    Route::resource('dominios', DominioController::class);
    Route::resource('prestadores-servico', PrestadorServicoController::class);
    Route::resource('manutencoes', ManutencaoController::class);


    // Rotas adicionais de manutenção
    Route::get('/manutencoes/create', [ManutencaoController::class, 'create'])->name('manutencoes.create');
    Route::put('/manutencoes/{id}/concluir', [ManutencaoController::class, 'concluir'])->name('manutencoes.concluir');


    // Relatórios principais
    Route::get('relatorios', [RelatorioController::class, 'index'])->name('relatorios.index');
    Route::post('relatorios/buscar', [RelatorioController::class, 'buscar'])->name('relatorios.buscar');


    // Grupo de relatórios específicos (PDF)
    Route::prefix('relatorios')->name('relatorios.')->group(function () {
        Route::get('/ativos/pdf', [RelatorioAtivoController::class, 'gerarPDF'])->name('ativos.pdf');
        Route::get('/dominios/pdf', [RelatorioDominioController::class, 'gerarPDF'])->name('dominios.pdf');
        Route::get('/licencas/pdf', [RelatorioLicencaController::class, 'gerarPDF'])->name('licencas.pdf');
        Route::get('/manutencoes/pdf', [RelatorioManutencaoController::class, 'pdf'])->name('manutencoes.pdf'); 
        // Observação: método corrigido para 'pdf'
    });

});
