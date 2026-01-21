<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ouvintes', function (Blueprint $table) {
            // 1. Remove o ID incremental antigo
            $table->dropColumn('id');
        });

        Schema::table('ouvintes', function (Blueprint $table) {
            // 2. Cria o novo ID como UUID e define como Chave Primária
            $table->uuid('id')->primary()->first();

            // 3. Adiciona os campos de autenticação simples
            $table->string('telefone')->nullable()->after('email');
            $table->string('password')->after('telefone');
        });

        // 4. Se houver registros antigos, gera UUIDs para eles não ficarem vazios
        $ouvintes = DB::table('ouvintes')->get();
        foreach ($ouvintes as $ouvinte) {
            DB::table('ouvintes')
                ->where('email', $ouvinte->email)
                ->update(['id' => (string) Str::uuid()]);
        }
    }

    public function down(): void
    {
        Schema::table('ouvintes', function (Blueprint $table) {
            $table->dropColumn(['id', 'telefone', 'password']);
        });
        Schema::table('ouvintes', function (Blueprint $table) {
            $table->id()->first();
        });
    }
};