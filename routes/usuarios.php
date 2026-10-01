<?php

use App\Http\Controllers\Usuario\AutenticacaoController;
use App\Http\Controllers\Usuario\PerfilController;
use App\Http\Controllers\Usuario\SenhaController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::controller(AutenticacaoController::class)->group(function () {
        Route::get('/cadastro', 'formularioDeCadastro')->name('cadastro');
        Route::post('/cadastro', 'cadastrar');

        Route::get('/entrar', 'formularioDeLogin')->name('login');
        Route::post('/entrar', 'entrar')->middleware('throttle:5,1');
    });
});

Route::middleware(['auth', 'auth.session'])->group(function () {
    Route::post('/sair', [AutenticacaoController::class, 'sair'])->name('sair');

    Route::get('/perfil', [PerfilController::class, 'perfil'])->name('perfil');
    Route::patch('/perfil', [PerfilController::class, 'atualizarPerfil'])->name('perfil.atualizar');

    Route::patch('/perfil/senha', [SenhaController::class, 'atualizarSenha'])->name('perfil.senha');
});
