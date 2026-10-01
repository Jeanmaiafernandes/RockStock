<?php

use App\Http\Controllers\EnderecoDeEstoqueController;
use App\Http\Controllers\FornecedoresController;
use App\Http\Controllers\LocaisEstoqueController;
use App\Http\Controllers\MovimentacaoEstoqueController;
use App\Http\Controllers\PedidosController;
use App\Http\Controllers\Produto\ProdutosCategoriasController;
use App\Http\Controllers\Produto\ProdutosController;
use App\Http\Controllers\Produto\ProdutosStatusController;
use App\Http\Controllers\Produto\ProdutosTamanhosController;
use App\Http\Controllers\Produto\ProdutosVariacoesController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/painel');

require __DIR__.'/usuarios.php';

Route::middleware(['auth', 'auth.session'])->group(function () {

    Route::view('/painel', 'painel')->name('painel');

    Route::controller(FornecedoresController::class)
        ->prefix('fornecedores')->name('fornecedores.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'salvar')->name('salvar');
            Route::get('/cadastrar', 'criar')->name('criar');
            Route::get('/{fornecedor}/editar', 'editar')->name('editar');
            Route::put('/{fornecedor}', 'atualizar')->name('atualizar');
            Route::delete('/{fornecedor}', 'excluir')->name('excluir');
        });

    Route::controller(LocaisEstoqueController::class)
        ->prefix('locaisEstoque')->name('locaisEstoque.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'salvar')->name('salvar');
            Route::get('/cadastrar', 'criar')->name('criar');
            Route::get('/{localEstoque}/editar', 'editar')->name('editar');
            Route::put('/{localEstoque}', 'atualizar')->name('atualizar');
            Route::delete('/{localEstoque}', 'excluir')->name('excluir');
        });

    Route::controller(EnderecoDeEstoqueController::class)
        ->prefix('enderecoDeEstoque')->name('enderecoDeEstoque.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'salvar')->name('salvar');
            Route::get('/cadastrar', 'criar')->name('criar');
            Route::get('/{enderecoDeEstoque}/editar', 'editar')->name('editar');
            Route::put('/{enderecoDeEstoque}', 'atualizar')->name('atualizar');
            Route::delete('/{enderecoDeEstoque}', 'excluir')->name('excluir');
        });

    Route::controller(ProdutosController::class)
        ->prefix('produtos')->name('produtos.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'salvar')->name('salvar');
            Route::get('/criar', 'criar')->name('criar');
            Route::get('/{produto}/visualizar', 'mostrar')->name('mostrar');
            Route::get('/{produto}/editar', 'editar')->name('editar');
            Route::patch('/{produto}', 'atualizar')->name('atualizar');
        });

    Route::post('/produtos/{produto}/grade', [ProdutosVariacoesController::class, 'salvar'])->name('grade.store');
    Route::put('/variacoes/{variacao}', [ProdutosVariacoesController::class, 'atualizar'])->name('variacoes.update');

    Route::controller(ProdutosCategoriasController::class)
        ->prefix('categoriasProduto')->name('categoriasProduto.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'salvar')->name('salvar');
            Route::get('/criar', 'criar')->name('criar');
            Route::get('/{categoria}/editar', 'editar')->name('editar');
            Route::patch('/{categoria}', 'atualizar')->name('atualizar');
            Route::delete('/{categoria}', 'excluir')->name('excluir');
        });

    Route::controller(ProdutosStatusController::class)
        ->prefix('statusProduto')->name('statusProduto.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'salvar')->name('salvar');
            Route::get('/criar', 'criar')->name('criar');
            Route::get('/{statusProduto}/editar', 'editar')->name('editar');
            Route::patch('/{statusProduto}', 'atualizar')->name('atualizar');
            Route::delete('/{statusProduto}', 'excluir')->name('excluir');
        });

    Route::controller(ProdutosTamanhosController::class)
        ->prefix('produtos-tamanhos')->name('tamanhos.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'salvar')->name('salvar');
            Route::get('/criar', 'criar')->name('criar');
            Route::get('/{tamanho}/editar', 'editar')->name('editar');
            Route::put('/{tamanho}', 'atualizar')->name('atualizar');
            Route::delete('/{tamanho}', 'excluir')->name('excluir');
        });

    Route::controller(PedidosController::class)
        ->prefix('pedidos')->name('pedidos.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'salvar')->name('salvar');
            Route::get('/criar', 'criar')->name('criar');
            Route::get('/{pedido}/editar', 'editar')->name('editar');
            Route::get('/{pedido}/visualizar', 'mostrar')->name('mostrar');
            Route::patch('/{pedido}', 'atualizar')->name('atualizar');
            Route::delete('/{pedido}', 'excluir')->name('excluir');
        });

    Route::controller(MovimentacaoEstoqueController::class)
        ->prefix('movimentacoes')->name('movimentacoes.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{movimentacao}/visualizar', 'show')->name('visualizar');
        });
});

Route::fallback(fn () => redirect()->route('painel'));
