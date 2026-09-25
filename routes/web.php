<?php

use App\Http\Controllers\EnderecoDeEstoqueController;
use App\Http\Controllers\FornecedoresController;
use App\Http\Controllers\ProdutosVariacoesController;
use App\Http\Controllers\MovimentacaoEstoqueController;
use App\Http\Controllers\PedidosController;
use App\Http\Controllers\ProdutosCategoriasController;
use App\Http\Controllers\ProdutosController;
use App\Http\Controllers\ProdutosStatusController;
use App\Http\Controllers\ProdutosTamanhosController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/painel');

require __DIR__.'/usuarios.php';

Route::middleware(['auth', 'auth.session'])->group(callback: function () {
    Route::view('/painel', 'painel')->name('painel');

    Route::prefix('fornecedores')
        ->name('fornecedores.')
        ->controller(FornecedoresController::class)
        ->group(function () {
        Route::get('/','index')->name('index');
        Route::post('/','store')->name('store');
        Route::get('/cadastrar','create')->name('create');
        Route::get('fornecedores/editar/{fornecedor}','edit')->name('edit');
        Route::put('fornecedores/{fornecedor}','update')->name('update');
        Route::delete('fornecedores/{fornecedor}','destroy')->name('destroy');
    });

    Route::prefix('enderecoDeEstoque')
        ->name('enderecoDeEstoque.')
        ->controller(EnderecoDeEstoqueController::class)
        ->group(function () {
        Route::get('/','index')->name('index');
        Route::post('/','store')->name('store');
        Route::get('/cadastrar','create')->name('create');
        Route::get('enderecosDeEstoque/editar/{enderecoDeEstoque}', 'edit')->name('edit');
        Route::put('enderecosDeEstoque/{enderecoDeEstoque}','update')->name('update');
        Route::delete('enderecosDeEstoque/{enderecoDeEstoque}','destroy')->name('delete');
    });

    Route::prefix('/produtos')
        ->name('produtos.')
        ->controller(ProdutosController::class)
        ->group(function () {
        Route::get('/','index')->name('index');
        Route::post('/','store')->name('store');
        Route::get('/criar', 'create')->name('create');
        Route::get('/{produto}/visualizar', 'show')->name('show');
        Route::get('/{produto}/editar','edit')->name('edit');
        Route::patch('/{produto}','update')->name('update');
    });

    Route::post('/{produto}/grade', [ProdutosVariacoesController::class, 'store'])->name('grade.store');

    Route::prefix('/variacoes')
        ->name('variacoes.')
        ->controller(ProdutosVariacoesController::class)
        ->group(function () {
            Route::put('/{variacao}', 'update')->name('update');
        });

    Route::prefix('/categoriasProduto')
        ->name('categoriasProduto.')
        ->controller(ProdutosCategoriasController::class)
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'store')->name('store');
            Route::get('/criar', 'create')->name('create');
            Route::get('/{categoria}/editar', 'edit')->name('edit');
            Route::patch('/{categoria}', 'update')->name('update');
            Route::delete('/{categoria}', 'destroy')->name('destroy');
        });

    Route::prefix('/statusProduto')
        ->name('statusProduto.')
        ->controller(ProdutosStatusController::class)
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'store')->name('store');
            Route::get('/criar','create')->name('create');
            Route::get('/{statusProduto}/editar','edit')->name('edit');
            Route::patch('/{statusProduto}', 'update')->name('update');
            Route::delete('/{statusProduto}', 'destroy')->name('destroy');
        });

    Route::prefix('produtos-tamanhos')
        ->name('tamanhos.')
        ->controller(ProdutosTamanhosController::class)
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'store')->name('store');
            Route::get('/criar', 'create')->name('create');
            Route::get('/{tamanho}/editar', 'edit')->name('edit');
            Route::put('/{tamanho}', 'update')->name('update');
            Route::delete('/{tamanho}', 'destroy')->name('destroy');
        });

    Route::prefix('/pedidos')
        ->name('pedidos.')
        ->controller(PedidosController::class)
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'store')->name('store');
            Route::get('/criar', 'create')->name('create');
            Route::get('/{pedido}/editar', 'edit')->name('edit');
            Route::get('/{pedido}/visualizar', 'show')->name('show');
            Route::patch('/{pedido}', 'update')->name('update');
            Route::delete('/{pedido}', 'destroy')->name('destroy');
        });

    Route::prefix('/movimentacoes')
        ->name('movimentacoes.')
        ->controller(MovimentacaoEstoqueController::class)
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{movimentacoes}/visualizar', 'show')->name('visualizar');
        });
});
