<?php

use App\Models\Pedido;
use App\Models\Produto;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pedidos_itens', function (Blueprint $table) {
           $table->id();
            $table->foreignIdFor(Pedido::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Produto::class)->constrained();
            $table->unsignedInteger('quantidade');
            $table->timestamps();

            $table->unique(['pedido_id', 'produto_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pedidos_itens');
    }
};
