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
        Schema::create('anunciantes', function (Blueprint $table) {
            Schema::create('anunciantes', function (Blueprint $table) {
                $table->id();
                $table->string('nome');
                $table->string('logo');
                $table->text('descricao')->nullable();
                $table->string('link_url')->nullable();
                $table->integer('ordem')->default(0);
                $table->boolean('ativo')->default(true);
                $table->timestamps();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anunciantes');
    }
};
