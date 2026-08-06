<?php

namespace Database\Factories;

use App\Models\Pedido;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Attributes\UseModel;
use Illuminate\Database\Eloquent\Factories\Factory;

#[UseModel(Pedido::class)]
class PedidoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'codigo'       => strtoupper(fake()->unique()->bothify('PED-######')),
            'destino'      => fake()->city(),
            'observacao'   => fake()->optional()->sentence(),
            'user_id'      => User::factory(),
            'statusPedido' => fake()->randomElement(['rascunho', 'confirmado', 'cancelado']),
        ];
    }

    public function confirmado(): static
    {
        return $this->state(fn () => ['statusPedido' => 'confirmado']);
    }
}
