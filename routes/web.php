<?php
use App\Http\Controllers\LegalController;
use App\Http\Controllers\CnpjController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DirectoryController;

Route::get('/', function () {
    return view('pages.home');
})->name('home');

// Rota para a página de Política de Privacidade e Termos de Uso
Route::get('/politica-de-privacidade', [LegalController::class, 'privacy'])->name('privacy.policy');

// Rota que recebe o POST dos formulários de busca
Route::post('/consultar', [CnpjController::class, 'consultar'])->name('cnpj.consultar');

// Rota que exibe a página de resultados de um CNPJ
Route::get('/cnpj/{cnpj}', [CnpjController::class, 'show'])->name('cnpj.show');


// O "Mapa do Site" navegável que você mencionou
Route::get('/empresas', [DirectoryController::class, 'index'])->name('empresas.index');

// 1. Navegação Geográfica (Sua ideia principal)
Route::get('/empresas/{uf}', [DirectoryController::class, 'byState'])->name('empresas.state');
Route::get('/empresas/{uf}/{cidade_slug}', [DirectoryController::class, 'byCity'])->name('empresas.city');

// Navegação por Atividade (CNAE)
Route::get('/empresas/atividades', [DirectoryController::class, 'cnaeIndex'])->name('empresas.cnae.index');
Route::get('/empresas/atividades/{codigo_cnae}', [DirectoryController::class, 'byCnae'])->name('empresas.cnae.show');

// 3. Navegação por Status (Ativas, Baixadas, etc.)
Route::get('/empresas/status/{status_slug}', [DirectoryController::class, 'byStatus'])->name('empresas.status');

// 4. Navegação por Data (Novas Empresas)
Route::get('/empresas/recentes', [DirectoryController::class, 'byRecent'])->name('empresas.recent');

// ... (todas as suas outras rotas)

// ROTA DE TESTE - adicione no final do arquivo
Route::get('/teste-cnae/{codigo_cnae}', [\App\Http\Controllers\DirectoryController::class, 'cnaeTest']);