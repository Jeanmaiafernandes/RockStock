<?php

namespace Database\Seeders;

use App\Models\ProdutoCategoria;
use Illuminate\Database\Eloquent\Factories\Attributes\UseModel;
use Illuminate\Database\Seeder;

#[UseModel(ProdutoCategoria::class)]
class ProdutoCategoriaSeeder extends Seeder
{
    public function run(): void
    {
        ProdutoCategoria::factory(2)->create();
    }
}
