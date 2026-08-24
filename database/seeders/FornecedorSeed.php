<?php

namespace Database\Seeders;

use App\Models\Fornecedor;
use Illuminate\Database\Eloquent\Factories\Attributes\UseModel;
use Illuminate\Database\Seeder;

#[UseModel(fornecedor::class)]
class FornecedorSeed extends Seeder
{
    public function run(): void
    {
        Fornecedor::factory()->create(1);
    }
}
