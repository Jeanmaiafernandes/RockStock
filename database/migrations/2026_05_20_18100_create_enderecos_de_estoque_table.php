<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * A situação do estoque é representada pelo tipo do endereço:
 * bloquear ou marcar avaria = transferir para um endereço desse tipo.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('enderecos_de_estoque', function (Blueprint $table) {
            $table->id();

            $table->foreignId('local_estoque_id')
                ->constrained('locais_estoque')
                ->restrictOnDelete();

            $table->string('codigo', 20); // A-03-02-B
            $table->enum('tipo', [
                'doca',
                'armazenagem',
                'bloqueado',
                'avaria',
                'devolucao'
            ])->default('armazenagem');

            $table->boolean('ativo')->default(true);
            $table->timestamps();

            $table->unique(['local_estoque_id', 'codigo']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('enderecos_de_estoque');
    }
};
