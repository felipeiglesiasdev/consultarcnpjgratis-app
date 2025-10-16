<?php

use App\Http\Controllers\LegalController;
use App\Http\Controllers\CnpjController;
use App\Http\Controllers\HomeController;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DirectoryController;

/*
|--------------------------------------------------------------------------
| Rotas Principais e Legais
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/politica-de-privacidade', [LegalController::class, 'privacy'])->name('privacy.policy');

/*
|--------------------------------------------------------------------------
| Rotas de Consulta de CNPJ
|--------------------------------------------------------------------------
*/

Route::post('/consultar', [CnpjController::class, 'consultar'])->name('cnpj.consultar');

// Rota de CNPJ com parâmetro (genérica, pode ficar mais para o final)
Route::get('/cnpj/{cnpj}', [CnpjController::class, 'show'])->name('cnpj.show');

/*
|--------------------------------------------------------------------------
| Rotas de Diretório (/empresas)
|--------------------------------------------------------------------------
*/

// Rota principal do diretório
Route::get('/empresas', [DirectoryController::class, 'index'])->name('empresas.index');

// --- ROTAS ESPECÍFICAS PRIMEIRO ---
// Estas são as rotas que não têm parâmetros variáveis no segundo segmento da URL.

Route::get('/empresas/atividades', [DirectoryController::class, 'cnaeIndex'])->name('empresas.cnae.index');
Route::get('/empresas/atividades/{codigo_cnae}', [DirectoryController::class, 'byCnae'])->name('empresas.cnae.show');

Route::get('/empresas/status/{status_slug}', [DirectoryController::class, 'byStatus'])->name('empresas.status');


// --- ROTAS COM PARÂMETROS (GENÉRICAS) POR ÚLTIMO ---
Route::get('/empresas/{uf}', [DirectoryController::class, 'byState'])->name('empresas.state');
Route::get('/empresas/{uf}/{cidade_slug}', [DirectoryController::class, 'byCity'])->name('empresas.city');