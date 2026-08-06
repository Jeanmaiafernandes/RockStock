<?php

namespace Database\Factories;

use App\Models\Pedido;
use App\Models\PedidoItem;
use App\Models\Produto;
use Illuminate\Database\Eloquent\Factories\Attributes\UseModel;
use Illuminate\Database\Eloquent\Factories\Factory;

#[UseModel(PedidoItem::class)]
class PedidoItemFactory extends Factory
{
    public function definition(): array
    {
        return [
            'pedido_id' => fn () => Pedido::query()
                ->inRandomOrder()->value('id'),
            'produto_id' => Produto::factory(),
            'quantidade' => $this->faker->numberBetween(1, 10),
        ];
    }
}
