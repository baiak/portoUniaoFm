<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
    {
        // 1. Tabela de Classificação (O Placar)
        Schema::create('rated_songs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('artist');
            $table->string('cover_url')->nullable();
            
            // Contadores (BigInt para garantir)
            $table->bigInteger('likes')->default(0);
            $table->bigInteger('dislikes')->default(0);
            
            $table->timestamps();

            // Garante que não duplica a mesma música no placar
            $table->unique(['artist', 'title']); 
        });

        // 2. Tabela de Votos Individuais (Os Comprovantes)
        Schema::create('song_votes', function (Blueprint $table) {
            $table->id();
            
            // Liga o voto à música
            $table->foreignId('rated_song_id')->constrained('rated_songs')->onDelete('cascade');
            
            //ID do Visitante
            $table->string('visitor_id', 64); 
            
            $table->enum('vote_type', ['like', 'dislike']);
            $table->timestamps();

            // Regra: Um visitante só tem 1 voto por música
            $table->unique(['rated_song_id', 'visitor_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voting_system_tables');
    }
};
