<?php

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
            $table->text('descricao')->nullable();
            $table->string('sku', 20);
            $table->string('ean', 13)->nullable();
            $table->unsignedInteger('quantidade');
            $table->foreignIdFor(ProdutoStatus::class)->constrained('produtos_status')
                ->restrictOnDelete();
            $table->foreignIdFor(ProdutoCategoria::class)->constrained('produtos_categorias')
            ->restrictOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produtos');
    }
};
