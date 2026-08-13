<?php

namespace App\Services\Services;

use App\Models\Pedido;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Throwable;

class PedidoService
{
    /**
     * @throws Throwable
     */
    public function criarPedido(array $dados): Pedido
    {
        return DB::transaction(function () use ($dados) {
            $pedido = Pedido::query()->create([
                'user_id' => auth()->id(),
                'destino' => $dados['destino'],
                'observacao' => $dados['observacao'] ?? null,
                'statusPedido' => $dados['statusPedido'],
            ]);

            $pedido->itens()->createMany($dados['itens']);

            return $pedido;
        });
    }

    /**
     * @throws Throwable
     */
    public function atualizarPedido(Pedido $pedido, array $dados): Pedido
    {
        return DB::transaction(function () use ($pedido, $dados) {
            $itens = $dados['itens'] ?? [];
            $dados =  Arr::except($dados, 'itens');
            // itens é apenas um relacionamento

            $pedido->update($dados);
            $pedido->itens()->delete();
            $pedido->itens()->createMany($itens);

            return $pedido;
        });
    }
}
