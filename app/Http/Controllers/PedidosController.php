<?php

namespace App\Http\Controllers;

use App\Http\Requests\PedidosStoreRequest;
use App\Http\Requests\PedidosUpdateRequest;
use App\Models\Pedido;
use App\Models\Produto\Produto;
use App\Models\Usuario;
use App\Services\Services\PedidoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Throwable;

class PedidosController extends Controller
{
    public function index(): View
    {
        $pedidos = Pedido::with('usuario')
        ->withCount('itens')
        ->latest()
            ->paginate(10);

        return view('pedidos.index', compact('pedidos'));
    }

    public function criar(): View
    {
        return view('pedidos.criar', [
            'produtos' => Produto::query()->pluck('nome', 'id'),
        ]);
    }

    /**
     * @throws Throwable
     */
    public function salvar(PedidosStoreRequest $request, PedidoService $pedidoService): RedirectResponse
    {
        $dados = $request->validated();

        $pedido = $pedidoService->criarPedido($dados);

        return redirect()->route('pedidos.mostrar', $pedido)
            ->with('successo', 'Pedido criado com sucesso!');
    }

    public function mostrar(Pedido $pedido): View
    {
        $pedido->load('usuario', 'itens.produto');

        return view('pedidos.visualizar',
            compact('pedido'));
    }

    public function editar(Pedido $pedido): View
    {
        $pedido->load('itens');

        return view('pedidos.editar', [
            'pedido'   => $pedido,
            'produtos' => Produto::query()->pluck('nome', 'id'),
            'usuario'    => Usuario::query()->pluck('nome', 'id'),
        ]);
    }

    /**
     * @throws Throwable
     */
    public function atualizar(PedidosUpdateRequest $request, PedidoService $pedidoService ,Pedido $pedido)
    {
        $dados = $request->validated();

        $pedido = $pedidoService->atualizarPedido($pedido, $dados);

        return redirect()->route('pedidos.index', $pedido)
            ->with('status', 'Pedido atualizado com sucesso!');
    }

    public function excluir(Pedido $pedido): RedirectResponse
    {
        $pedido->delete();
        return redirect()->back()->with('sucesso', 'Pedido excluído.')
            ->with('status');
    }
}
