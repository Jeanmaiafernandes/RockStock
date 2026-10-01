<?php

namespace Database\Seeders;

use App\Models\EnderecoDeEstoque;
use App\Models\Fornecedor;
use App\Models\Produto\Produto;
use App\Models\Produto\ProdutoCategoria;
use App\Models\Produto\ProdutoStatus;
use Illuminate\Database\Eloquent\Factories\Attributes\UseModel;
use Illuminate\Database\Seeder;

#[UseModel(Produto::class)]
class ProdutoSeeder extends Seeder
{
    public function run(): void
    {
        Produto::factory(2)
            ->recycle(ProdutoCategoria::all())
            ->recycle(ProdutoStatus::all())
            ->recycle(Fornecedor::all())
            ->recycle(EnderecoDeEstoque::all())
            ->create();
    }
}
