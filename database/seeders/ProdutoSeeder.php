<?php

namespace Database\Seeders;

use App\Models\Produto;
use App\Models\ProdutoCategoria;
use App\Models\ProdutoStatus;
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
            ->create();
    }
}
