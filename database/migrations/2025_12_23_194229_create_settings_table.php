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
        Schema::create('settings', function (Blueprint $table) {
        $table->id();
        // Dados da Rádio
        $table->string('radio_name')->default('Porto União FM');
        $table->string('slogan')->nullable();
        $table->string('frequency')->nullable(); // Ex: 107.5 FM ou "Web Only"
        
        // Streaming
        $table->string('streaming_url')->nullable();
        
        // Contato
        $table->string('contact_email')->nullable();
        $table->string('whatsapp_number')->nullable();
        
        $table->timestamps();
    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
