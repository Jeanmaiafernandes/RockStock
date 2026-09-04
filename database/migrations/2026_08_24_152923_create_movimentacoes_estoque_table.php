<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use App\Models\Produto;
use App\Models\Usuario;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movimentacoes_estoque', function (Blueprint $table) {
            $table->id();
            $table->nullableMorphs('documento');
            $table->enum('tipo', ['entrada', 'saida', 'transf', 'ajuste']);
            $table->integer('quantidade');

            $table->foreignIdFor(Produto::class)
                ->constrained('produtos')
                ->restrictOnDelete();

            $table->foreignId('endereco_origem_id')->nullable()
                ->constrained('enderecos_de_estoque')
                ->restrictOnDelete();

            $table->foreignId('endereco_destino_id')->nullable()
                ->constrained('enderecos_de_estoque')
                ->restrictOnDelete();

            $table->foreignIdFor(Usuario::class)
                ->constrained('usuarios')
                ->restrictOnDelete();

            $table->timestamps();

            //   $table->index(['produto_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movimentacoes_estoque');
    }
};
