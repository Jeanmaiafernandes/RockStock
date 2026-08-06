<?php

namespace App\Http\Controllers;

use App\Http\Requests\PedidosStoreRequest;
use App\Http\Requests\PedidosUpdateRequest;
use App\Models\Pedido;
use App\Models\PedidoItem;
use App\Models\Produto;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Throwable;

class PedidosController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::with('user')
        ->withCount('itens')
        ->latest()
            ->paginate(15);

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
    public function store(PedidosStoreRequest $request): RedirectResponse
    {
        $dados = $request->validated();

        $pedido = DB::transaction(function () use ($dados) {
            $pedido = new Pedido();
            $pedido->user_id      = auth()->id();
            $pedido->destino      = $dados['destino'];
            $pedido->observacao   = $dados['observacao'] ?? null;
            $pedido->statusPedido = $dados['statusPedido'];
            $pedido->save();

            try {
                foreach ($dados['itens'] as $item) {
                    $pedidoItem = new PedidoItem();
                    $pedidoItem->produto_id = $item['produto_id'];
                    $pedidoItem->quantidade = $item['quantidade'];

                    $pedido->itens()->save($pedidoItem);
                }
            }
            catch (Throwable $e) {
                return back()->withErrors($e->getMessage());
            }
            return $pedido;
        });

        return redirect()->route('pedidos.show', $pedido)
            ->with('sucesso', 'Pedido criado com sucesso!');
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
    public function update(PedidosUpdateRequest $request, Pedido $pedido)
    {
        $dados = $request->validated();

        DB::transaction(function () use ($dados, $pedido) {
            $pedido->user_id    = auth()->id();
            $pedido->statusPedido = $dados['statusPedido'];
            $pedido->observacao  = $dados['observacao'] ?? null;
            $pedido->destino = $dados['destino'];
            $pedido->save();

            $pedido->itens()->delete();

            try {
                foreach ($dados['itens'] as $item) {
                    $itemPedido = new PedidoItem();
                    $itemPedido->produto()->associate($item['produto_id']);
                    $itemPedido->quantidade = $item['quantidade'];

                    $pedido->itens()->save($itemPedido);
                }
            }
            catch (Throwable $e) {
                return back()->withInput()->with('error', $e->getMessage());
            }
            return $pedido;
        });

        return redirect()->route('pedidos.index')
            ->with('sucesso', 'Pedido atualizado com sucesso.');
    }

    public function destroy(Pedido $pedido)
    {
        $pedido->delete();
        return back()->with('sucesso', 'Pedido excluído.');
    }
}
