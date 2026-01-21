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
        Schema::table('specials', function (Blueprint $table) {            
        $table->string('title'); 
        $table->string('slug')->unique();
        $table->string('cover_url')->nullable();
        $table->longText('playlist_html');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('specials', function (Blueprint $table) {
            //
        });
    }
};
