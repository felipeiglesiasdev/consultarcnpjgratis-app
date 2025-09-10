<?php
use App\Http\Controllers\LegalController;
use App\Http\Controllers\CnpjController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.home');
})->name('home');

// Rota para a página de Política de Privacidade e Termos de Uso
Route::get('/politica-de-privacidade', [LegalController::class, 'privacy'])->name('privacy.policy');

// Rota que recebe o POST dos formulários de busca
Route::post('/consultar', [CnpjController::class, 'consultar'])->name('cnpj.consultar');

// Rota que exibe a página de resultados de um CNPJ
Route::get('/cnpj/{cnpj}', [CnpjController::class, 'show'])->name('cnpj.show');
