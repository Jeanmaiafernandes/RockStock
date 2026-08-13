<?php

namespace Database\Seeders;

use App\Models\PedidoItem;
use Illuminate\Database\Eloquent\Factories\Attributes\UseModel;
use Illuminate\Database\Seeder;

#[UseModel(PedidoItem::class)]
class PedidoItemSeeder extends Seeder
{
    public function run(): void
    {
        PedidoItem::factory(3);
    }
}
