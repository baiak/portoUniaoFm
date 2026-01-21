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
        Schema::table('pedido_musicas', function (Blueprint $table) {
            // 1. Primeiro removemos a chave estrangeira (Constraint)
            // O Laravel usa o padrão: nome_tabela_nome_coluna_foreign
            $table->dropForeign(['user_id']);

            // 2. Agora que ela está solta, podemos apagar a coluna
            $table->dropColumn('user_id');
        });

        Schema::table('pedido_musicas', function (Blueprint $table) {
            // 3. Criamos a nova coluna como UUID e já refazemos a ligação
            $table->foreignUuid('user_id')
                ->nullable()
                ->after('id')
                ->constrained('ouvintes')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pedido_musicas', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
        Schema::table('pedido_musicas', function (Blueprint $table) {
            $table->bigInteger('user_id')->after('id');
        });
    }
};
