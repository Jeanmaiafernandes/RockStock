<?php

namespace App\Http\Controllers;

use App\Http\Requests\PedidosStoreRequest;
use App\Http\Requests\PedidosUpdateRequest;
use App\Models\Pedido;
use App\Models\Produto;
use App\Models\User;
use App\Services\Services\PedidoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Throwable;

class PedidosController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::with('user')
        ->withCount('itens')
        ->latest()
            ->paginate(10);

        return view('pedidos.index', compact('pedidos'));
    }

    public function create()
    {
        return view('pedidos.criar', [
            'produtos' => Produto::query()->pluck('nome', 'id'),
        ]);
    }

    /**
     * @throws Throwable
     */
    public function store(PedidosStoreRequest $request, PedidoService $pedidoService): RedirectResponse
    {
        $dados = $request->validated();

        $pedido = $pedidoService->criarPedido($dados);

        return redirect()->route('pedidos.show', $pedido)
            ->with('successo', 'Pedido criado com sucesso!');
    }

    public function show(Pedido $pedido): View
    {
        $pedido->load('user', 'itens.produto');

        return view('pedidos.visualizar',
            compact('pedido'));
    }

    public function edit(Pedido $pedido)
    {
        $pedido->load('itens');

        return view('pedidos.editar', [
            'pedido'   => $pedido,
            'produtos' => Produto::query()->pluck('nome', 'id'),
            'users'    => User::query()->pluck('name', 'id'),
        ]);
    }

    /**
     * @throws Throwable
     */
    public function update(PedidosUpdateRequest $request, PedidoService $pedidoService ,Pedido $pedido)
    {
        $dados = $request->validated();

        $pedido = $pedidoService->atualizarPedido($pedido, $dados);

        return redirect()->route('pedidos.index', $pedido)
            ->with('status', 'Pedido atualizado com sucesso!');
    }

    public function destroy(Pedido $pedido)
    {
        $pedido->delete();
        return back()->with('sucesso', 'Pedido excluído.')
            ->with('status');
    }
}
