<?php

namespace Database\Seeders;

use App\Models\ProdutoStatus;
use Illuminate\Database\Eloquent\Factories\Attributes\UseModel;
use Illuminate\Database\Seeder;

#[UseModel(ProdutoStatus::class)]
class ProdutoStatusSeeder extends Seeder
{
    public function run(): void
    {
        ProdutoStatus::factory(2)->create();
    }
}
