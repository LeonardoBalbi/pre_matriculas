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
        Schema::create('turmas', function (Blueprint $table) {
            $table->id();
            $table->unsignedbiginteger('turma_escola_id');
            $table->unsignedbiginteger('turma_tipo_id');
            $table->unsignedbiginteger('matricula_id')->nullable();
            $table->string('turma_descricao')->nullable();
            $table->integer('turma_qtd_vagas')->nullable();
            $table->integer('turma_qtd_vagas_especiais')->nullable();
            $table->integer('turma_ano_letivo')->nullable();
            $table->integer('turma_idade_minima')->nullable();
            $table->integer('turma_idade_maxima')->nullable();
            $table->integer('turma_idade_anos')->nullable();
            $table->enum('turma_status', ['ativa', 'inativa'])->nullable();
            
            $table->timestamps();

          
        });
    }

    /**
     * reverse the migrations.
     */
    public function down(): void
    {
        schema::dropifexists('turmas');
    }
};

