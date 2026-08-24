<?php

namespace Database\Seeders;

use App\Models\EnderecoDeEstoque;
use Illuminate\Database\Eloquent\Factories\Attributes\UseModel;
use Illuminate\Database\Seeder;

#[UseModel(EnderecoDeEstoque::class)]
class EnderecoDeEstoqueSeeder extends Seeder
{
    public function run(): void
    {
        EnderecoDeEstoque::factory()->create(3);
    }
}
