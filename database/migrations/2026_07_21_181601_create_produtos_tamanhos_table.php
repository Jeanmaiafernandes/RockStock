<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produtos_tamanhos', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 10)->unique();
            $table->unsignedSmallInteger('ordem');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tamanhos');
    }
};
