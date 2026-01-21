<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('noticias', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('titulo');
            $table->string('slug')->unique();
            $table->text('conteudo');
            $table->string('imagem')->nullable(); // Para a thumbnail
            $table->boolean('is_published')->default(false);
            $table->timestamp('publicado_em')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('noticias');
    }
};
