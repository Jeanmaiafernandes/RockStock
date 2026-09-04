<?php

use Illuminate\Session\Middleware\AuthenticateSession;
use App\Http\Controllers\Auth\AutenticarController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\EnderecoDeEstoqueController;
use App\Http\Controllers\FornecedoresController;
use App\Http\Controllers\PedidosController;
use App\Http\Controllers\MovimentacaoEstoqueController;
use App\Http\Controllers\PerfilUsuarioController;
use App\Http\Controllers\ProdutosController;
use App\Http\Controllers\ProdutosStatusController;
use App\Http\Controllers\ProdutosCategoriasController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/painel');

Route::middleware('guest')->group(function () {
    Route::get('/registrar', [AutenticarController::class, 'mostrarRegistroForm'])->name('registrar');
    Route::post('/registrar', [AutenticarController::class, 'registrar']);

    Route::get('/entrar', [LoginController::class, 'mostrarLoginForm'])->name('login');
    Route::post('/entrar', [LoginController::class, 'entrar'])
        ->middleware('throttle:5,1');
});

Route::middleware(['auth', 'auth.session'])->group(function () {
    Route::post('/sair', [LoginController::class, 'sair'])->name('sair');
    Route::view('/painel', 'painel')->name('painel');

    Route::prefix('/perfil')->group(function () {
        Route::get('/', [PerfilUsuarioController::class, 'index'])->name('perfil.index');
        Route::patch('/', [PerfilUsuarioController::class, 'atualizar'])->name('perfil.atualizar');
        Route::patch('/senha', [PerfilUsuarioController::class, 'atualizarSenha'])->name('perfil.senha');
       // Auth::logoutOtherDevices($senhaAtual);
    });

    Route::prefix('fornecedores')->group(function () {
        Route::get('/', [FornecedoresController::class, 'index'])->name('fornecedores.index');
        Route::post('/', [FornecedoresController::class, 'store'])->name('fornecedores.store');
        Route::get('/cadastrar', [FornecedoresController::class, 'create'])->name('fornecedores.create');
        Route::get('fornecedores/editar/{fornecedor}', [FornecedoresController::class, 'edit'])->name('fornecedores.edit');
        Route::put('fornecedores/{fornecedor}', [FornecedoresController::class, 'update'])->name('fornecedores.update');
        Route::delete('fornecedores/{fornecedor}', [FornecedoresController::class, 'destroy'])->name('fornecedores.destroy');
    });

    Route::prefix('enderecoDeEstoque')->group(function () {
        Route::get('/', [EnderecoDeEstoqueController::class, 'index'])->name('enderecoDeEstoque.index');
        Route::post('/', [EnderecoDeEstoqueController::class, 'store'])->name('enderecoDeEstoque.store');
        Route::get('/cadastrar', [EnderecoDeEstoqueController::class, 'create'])->name('enderecoDeEstoque.create');
        Route::get('enderecosDeEstoque/editar/{enderecoDeEstoque}', [EnderecoDeEstoqueController::class, 'edit'])->name('enderecoDeEstoque.edit');
        Route::put('enderecosDeEstoque/{enderecoDeEstoque}', [EnderecoDeEstoqueController::class, 'update'])->name('enderecoDeEstoque.update');
        Route::delete('enderecosDeEstoque/{enderecoDeEstoque}', [EnderecoDeEstoqueController::class, 'destroy'])->name('enderecoDeEstoque.delete');
    });

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

    Route::prefix('/movimentacoes')->group(function () {
        Route::get('/', [MovimentacaoEstoqueController::class, 'index'])->name('movimentacoes.index');
        Route::get('/{movimentacoes}/visualizar', [MovimentacaoEstoqueController::class, 'show'])->name('movimentacoes.show');
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
