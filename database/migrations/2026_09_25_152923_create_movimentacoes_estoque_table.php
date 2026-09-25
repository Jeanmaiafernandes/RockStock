<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movimentacoes_estoque', function (Blueprint $table) {
            $table->id();

            $table->foreignId('documento_id')->nullable()
                ->constrained('documentos')
                ->restrictOnDelete();

            $table->enum('tipo', [
                'entrada',
                'saida',
                'transferencia',
                'ajuste'
            ]);

            $table->foreignId('produto_variacao_id')
                ->constrained('produto_variacoes')
                ->restrictOnDelete();

            $table->unsignedInteger('quantidade');

            $table->foreignId('endereco_origem_id')->nullable()
                ->constrained('enderecos_de_estoque')
                ->restrictOnDelete();

            $table->foreignId('endereco_destino_id')->nullable()
                ->constrained('enderecos_de_estoque')
                ->restrictOnDelete();

            $table->string('motivo', 100)->nullable();

            $table->foreignId('usuario_id')
                ->constrained('usuarios')
                ->restrictOnDelete();

            $table->timestamp('created_at')->useCurrent();

            $table->index(['produto_variacao_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movimentacoes_estoque');
    }
};
