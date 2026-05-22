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
        Schema::create('candidatos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_vagas')->nullable();
            $table->string('nome', 255);
            $table->string('cpf')->nullable();
            $table->date('data_nasc')->nullable();
            $table->string('cor_raca')->nullable();
            $table->string('nacionalidade')->nullable();
            $table->string('naturalidade')->nullable();
            $table->string('sexo')->nullable();
            $table->string('estado_civil')->nullable();
            $table->boolean('deficiencia')->default(false);
            $table->string('tipo_deficiencia')->nullable();
            $table->string('nome_pai')->nullable();
            $table->string('nome_mae')->nullable();
            $table->string('escolaridade')->nullable();
            $table->string('rg')->nullable();
            $table->string('rg_emissor')->nullable();
            $table->string('rg_estado')->nullable();
            $table->date('rg_data_emissao')->nullable();
            $table->string('cep')->nullable();
            $table->string('endereco')->nullable();
            $table->string('numero')->nullable();
            $table->string('complemento')->nullable();
            $table->string('bairro')->nullable();
            $table->string('cidade')->nullable();
            $table->string('uf')->nullable();
            $table->string('telefone')->nullable();
            $table->string('celular')->nullable();
            $table->string('email')->nullable();
            $table->double('pontos')->nullable();
            $table->string('status')->default('Em análise')->nullable();
            $table->timestamps();

            $table->foreign('id_vagas')->references('id')->on('vagas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidatos');
    }
};
