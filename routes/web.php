<?php
use App\Http\Controllers\LegalController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.home');
})->name('home');

// Rota para a página de Política de Privacidade e Termos de Uso
Route::get('/politica-de-privacidade', [LegalController::class, 'privacy'])->name('privacy.policy');
