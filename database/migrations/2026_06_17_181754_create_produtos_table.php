<?php

use App\Models\Fornecedor;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\ProdutoCategoria;
use App\Models\ProdutoStatus;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 200);
            $table->string('referencia', 30)->nullable();
            $table->text('descricao')->nullable();
            $table->string('colecao', 50)->nullable();

            $table->foreignIdFor(Fornecedor::class)
                ->constrained('fornecedores')
            ->restrictOnDelete();

            $table->foreignIdFor(ProdutoStatus::class)
                ->constrained('produtos_status')
                ->restrictOnDelete();

            $table->foreignIdFor(ProdutoCategoria::class)
                ->constrained('produtos_categorias')
            ->restrictOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produtos');
    }
};
