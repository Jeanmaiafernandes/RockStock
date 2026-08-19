<?php

use App\Http\Controllers\Auth\AutenticacaoController;
use App\Http\Controllers\Auth\RegistroController;
use App\Http\Controllers\PedidosController;
use App\Http\Controllers\ProdutosController;
use App\Http\Controllers\ProdutosStatusController;
use App\Http\Controllers\ProdutosCategoriasController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/painel');

Route::middleware('guest')->group(function () {
    Route::get('/registrar', [RegistroController::class, 'exibirRegistro'])->name('registrar');
    Route::post('/registrar', [RegistroController::class, 'registrar']);

    Route::get('/entrar', [AutenticacaoController::class, 'exibirLogin'])->name('entrar');
    Route::post('/entrar', [AutenticacaoController::class, 'autenticar'])
        ->middleware('throttle:5,1');
});

Route::middleware('auth')->group(function () {
    Route::post('/sair', [AutenticacaoController::class, 'sair'])->name('sair');
    Route::view('/painel', 'painel')->name('painel');

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
