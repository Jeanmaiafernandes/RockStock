<?php

use App\Http\Controllers\UsuariosController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/cadastro', [UsuariosController::class, 'formCadastro'])->name('cadastro');
    Route::post('/cadastro', [UsuariosController::class, 'cadastrar']);

    Route::get('/entrar', [UsuariosController::class, 'formEntrar'])->name('login');
    Route::post('/entrar', [UsuariosController::class, 'entrar'])->middleware('throttle:5,1');
});

Route::middleware(['auth', 'auth.session'])->group(function () {
    Route::post('/sair', [UsuariosController::class, 'sair'])->name('sair');

    Route::get('/perfil', [UsuariosController::class, 'perfil'])->name('perfil');
    Route::patch('/perfil', [UsuariosController::class, 'atualizarPerfil'])->name('perfil.atualizar');
    Route::patch('/perfil/senha', [UsuariosController::class, 'atualizarSenha'])->name('perfil.senha');
});
