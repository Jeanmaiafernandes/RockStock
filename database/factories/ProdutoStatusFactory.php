<?php

namespace Database\Factories;

use App\Models\ProdutoStatus;
use Illuminate\Database\Eloquent\Factories\Attributes\UseModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<ProdutoStatus> */
#[UseModel(ProdutoStatus::class)]
class ProdutoStatusFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nome' => ucfirst($this->faker->unique()->word()),
            'disponivel' => $this->faker->boolean(),
            'permite_saida' => $this->faker->boolean(),
        ];
    }
}
