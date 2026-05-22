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

        Schema::table('matriculas', function (Blueprint $table) {
            $table->foreign('escola_nome_id','matriculas_escola_nome_foreign')->references('id')->on('escolas')->ondelete('cascade');
            $table->foreign('turma_id')->references('id')->on('turmas')->ondelete('cascade');
            $table->foreign('escola_bairro_id')->references('id')->on('bairros')->ondelete('cascade');          
            $table->foreign('distrito_id')->references('id')->on('distritos')->ondelete('cascade');
            $table->foreign('escolaridade_id')->references('id')->on('escolaridades')->ondelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('matriculas', function (Blueprint $table) {
            $table->dropForeign('matriculas_escola_nome_foreign');
            $table->dropForeign('matriculas_turma_id_foreign');
            $table->dropForeign('matriculas_escola_bairro_id_foreign');      
            $table->dropForeign('matriculas_distrito_id_foreign');
            $table->dropForeign('matriculas_escolaridade_id_foreign');
                        
        });
    }
};
