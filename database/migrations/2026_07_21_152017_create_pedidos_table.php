<?php

use App\Models\Usuario;
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
            $table->enum('statusPedido', ['rascunho', 'confirmado',
                'cancelado'])->default('rascunho');
            $table->string('destino');
            $table->string('observacao')->nullable();

            $table->foreignIdFor(Usuario::class)->constrained()
                ->noActionOnDelete()
                ->noActionOnUpdate();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
