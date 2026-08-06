<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 30);
            $table->foreignIdFor(User::class)->constrained()->noActionOnDelete()->noActionOnUpdate();
            $table->enum('statusPedido', ['rascunho', 'confirmado',
                'cancelado'])->default('rascunho');
            $table->string('destino');
            $table->string('observacao')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
