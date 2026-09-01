<?php

namespace Database\Seeders;

use App\Models\Fornecedor;
use App\Models\Produto;
use App\Models\ProdutoCategoria;
use App\Models\ProdutoStatus;
use App\Models\Usuario;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        Usuario::factory()->create([
            'nome' => 'Test User',
            'email' => 'test@example.com',
            'senha' => password_hash('test', PASSWORD_DEFAULT),
        ]);

        $this->call([
            ProdutoCategoriaSeeder::class,
            ProdutoStatusSeeder::class,
            UsuarioSeeder::class,
            ProdutoSeeder::class,
            PedidoSeeder::class,
            PedidoItemSeeder::class,
            FornecedorSeed::class,
            EnderecoDeEstoqueSeeder::class,
        ]);
    }
}
