<?php

namespace Database\Factories;

use App\Models\ProdutoCategoria;
use Illuminate\Database\Eloquent\Factories\Attributes\UseModel;
use Illuminate\Database\Eloquent\Factories\Factory;

#[UseModel(ProdutoCategoria::class)]
class ProdutoCategoriaFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nome' => ucfirst($this->faker->unique()->word()),
            'ativo' => $this->faker->boolean(),
        ];
    }
}
