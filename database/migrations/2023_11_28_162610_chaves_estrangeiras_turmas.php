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
        #Devido a desorganização do banco de dados, 
        #foi necessário criar uma nova migration para adicionar as chaves estrangeiras
        
        Schema::table('turmas', function (Blueprint $table) {
            $table->foreign('turma_escola_id')->references('id')->on('escolas')->ondelete('cascade');
            $table->foreign('turma_tipo_id')->references('id')->on('turma_tipos')->ondelete('cascade');
            $table->foreign('matricula_id')->references('id')->on('matriculas')->ondelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('turmas', function (Blueprint $table) {
            $table->dropForeign('turmas_turma_escola_id_foreign');
            $table->dropForeign('turmas_turma_tipo_id_foreign');
            $table->dropForeign('turmas_matricula_id_foreign');
        });
    }
};
