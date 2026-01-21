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
        Schema::create('banners', function (Blueprint $table) {
        $table->id();
        $table->string('titulo')->nullable();
        $table->string('imagem_path'); // Onde o caminho da foto será guardado
        $table->string('link_url')->nullable(); // Link para onde o banner aponta
        $table->boolean('esta_ativo')->default(true);
        $table->integer('ordem')->default(0); // Para organizar a sequência
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
