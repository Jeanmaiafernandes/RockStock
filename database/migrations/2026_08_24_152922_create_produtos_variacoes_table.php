<?php

use App\Models\Produto;
use App\Models\ProdutoTamanho;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produtos_variacoes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('produto_id')
                ->constrained('produtos')
                ->restrictOnDelete();

            $table->foreignId('tamanho_id')
                ->constrained('produtos_tamanhos')
                ->restrictOnDelete();

            $table->string('cor', 50);
            $table->string('sku', 40)->unique();
            $table->string('ean', 14)->nullable()->unique();
            $table->boolean('ativo')->default(true);
            $table->timestamps();

            $table->unique(['produto_id', 'cor', 'tamanho_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produtos_variacoes');
    }
};
