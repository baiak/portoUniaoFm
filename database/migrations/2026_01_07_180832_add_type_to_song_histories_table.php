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
        Schema::table('song_histories', function (Blueprint $table) {
            // Cria a coluna 'type' que por padrão é 'song'
            $table->string('type')->default('song')->after('cover_url')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('song_histories', function (Blueprint $table) {
            //
        });
    }
};
