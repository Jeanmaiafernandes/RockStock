<?php

namespace Database\Factories;

use App\Models\EnderecoDeEstoque;
use App\Models\Fornecedor;
use App\Models\ProdutoCategoria;
use App\Models\Produto;
use App\Models\ProdutoStatus;
use Illuminate\Database\Eloquent\Factories\Attributes\UseModel;
use Illuminate\Database\Eloquent\Factories\Factory;

#[UseModel(Produto::class)]
class ProdutoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nome' => ucfirst($this->faker->words(3, true)),
            'referencia' => $this->faker->word(),
            'colecao' => $this->faker->word(),
            'descricao' => $this->faker->optional()->sentence(),
            'produto_categoria_id' => ProdutoCategoria::factory(),
            'produto_status_id' => ProdutoStatus::factory(),
            'fornecedor_id' => Fornecedor::factory(),
        ];
    }

    public function semEstoque(): static
    {
        return $this->state(fn () => ['quantidade' => 0]);
    }

    public function estoqueBaixo(): static
    {
        return $this->state(fn () => ['quantidade' => 1]);
    }
}
