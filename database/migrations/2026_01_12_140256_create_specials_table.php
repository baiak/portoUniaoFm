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
        Schema::create('specials', function (Blueprint $table) {
$table->id();
        $table->string('title'); // Ex: "Especial Queen"
        $table->string('slug')->unique(); // Ex: "especial-queen"
        $table->string('cover_url')->nullable(); // Capa do especial
        $table->longText('playlist_html'); // <--- Aqui vai o código que eu vou gerar pra você
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('specials');
    }
};
