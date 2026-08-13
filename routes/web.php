<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistrarController;
use App\Http\Controllers\DeslogarController;
use App\Http\Controllers\PedidosController;
use App\Http\Controllers\ProdutosController;
use App\Http\Controllers\ProdutosStatusController;
use App\Http\Controllers\ProdutosCategoriasController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/dashboard');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('/categorias')->group(function () {
        Route::get('/', [ProdutosCategoriasController::class, 'index'])->name('categorias.index');
        Route::post('/', [ProdutosCategoriasController::class, 'store'])->name('categorias.store');
        Route::get('/criar', [ProdutosCategoriasController::class, 'create'])->name('categorias.create');
        Route::get('/{categoria}/editar', [ProdutosCategoriasController::class, 'edit'])->name('categorias.edit');
        Route::patch('/{categoria}', [ProdutosCategoriasController::class, 'update'])->name('categorias.update');
        Route::delete('/{categoria}', [ProdutosCategoriasController::class, 'destroy'])->name('categorias.destroy');
    });

    Route::prefix('/produtos')->group(function () {
        Route::get('/', [ProdutosController::class, 'index'])->name('produtos.index');
        Route::post('/', [ProdutosController::class, 'store'])->name('produtos.store');
        Route::get('/criar', [ProdutosController::class, 'create'])->name('produtos.create');
        Route::get('/{produto}/visualizar', [ProdutosController::class, 'show'])->name('produtos.show');
        Route::get('/{produto}/editar', [ProdutosController::class, 'edit'])->name('produtos.edit');
        Route::patch('/{produto}', [ProdutosController::class, 'update'])->name('produtos.update');
        Route::delete('/{produto}', [ProdutosController::class, 'destroy'])->name('produtos.destroy');
    });

    Route::prefix('/statusProdutos')->group(function () {
        Route::get('/', [ProdutosStatusController::class, 'index'])->name('statusProdutos.index');
        Route::post('/', [ProdutosStatusController::class, 'store'])->name('statusProdutos.store');
        Route::get('/criar', [ProdutosStatusController::class, 'create'])->name('statusProdutos.create');
        Route::get('/{statusProduto}/editar', [ProdutosStatusController::class, 'edit'])->name('statusProdutos.edit');
        Route::patch('/{statusProduto}', [ProdutosStatusController::class, 'update'])->name('statusProdutos.update');
        Route::delete('/{statusProduto}', [ProdutosStatusController::class, 'destroy'])->name('statusProdutos.destroy');
    });

    Route::prefix('/pedidos')->group(function () {
       Route::get('/', [PedidosController::class, 'index'])->name('pedidos.index');
       Route::post('/', [PedidosController::class, 'store'])->name('pedidos.store');
       Route::get('/criar', [PedidosController::class, 'create'])->name('pedidos.create');
       Route::get('/{pedido}/visualizar', [PedidosController::class, 'show'])->name('pedidos.show');
       Route::get('/{pedido}/editar', [PedidosController::class, 'edit'])->name('pedidos.edit');
       Route::patch('/{pedido}', [PedidosController::class, 'update'])->name('pedidos.update');
       Route::delete('/{pedido}', [PedidosController::class, 'destroy'])->name('pedidos.destroy');
    });
});

Route::middleware('autenticado')->group(function () {
    Route::post('/registrar', [RegistrarController::class, 'registrarUsuario']);
    Route::post('/logar', [LoginController::class, 'loginUsuario']);
    Route::post('/deslogar', [DeslogarController::class, 'deslogarUsuario']);
});

require __DIR__.'/auth.php';
