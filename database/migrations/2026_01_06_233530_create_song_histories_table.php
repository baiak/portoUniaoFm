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
        Schema::create('song_histories', function (Blueprint $table) {
            $table->id();
            $table->string('artist');
            $table->string('title');
            $table->string('album')->nullable();
            $table->string('cover_url')->nullable(); // Para o futuro!
            $table->timestamp('played_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('song_histories');
    }
};
