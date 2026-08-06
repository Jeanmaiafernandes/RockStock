<?php

namespace Database\Seeders;

use App\Models\Produto;
use App\Models\ProdutoCategoria;
use App\Models\ProdutoStatus;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => '123123'
        ]);

        $this->call([
            ProdutoCategoriaSeeder::class,
            ProdutoStatusSeeder::class,
            UserSeeder::class,
            ProdutoSeeder::class,
            PedidoSeeder::class,
            PedidoItemSeeder::class,
        ]);
    }
}
