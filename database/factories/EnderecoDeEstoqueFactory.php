<?php

namespace Database\Factories;

use App\Models\EnderecoDeEstoque;
use Illuminate\Database\Eloquent\Factories\Attributes\UseModel;
use Illuminate\Database\Eloquent\Factories\Factory;

#[UseModel(EnderecoDeEstoque::class)]
class EnderecoDeEstoqueFactory extends Factory
{
    public function definition(): array
    {
        return [
            'codigo' => strtoupper($this->faker->unique()->bothify('????')),
            'tipo' => fake()->randomElement(['arara', 'arquivado', 'restauro']),
            'bloqueado' => $this->faker->boolean(),
        ];
    }
}
