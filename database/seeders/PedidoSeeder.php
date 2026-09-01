<?php

namespace Database\Seeders;

use App\Models\Pedido;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Attributes\UseModel;
use Illuminate\Database\Seeder;

#[UseModel(Pedido::class)]
class PedidoSeeder extends Seeder
{
    public function run(): void
    {
        Pedido::factory(3)
            ->recycle(Usuario::all())
           ->hasItens(3)
            ->create();
    }
}
