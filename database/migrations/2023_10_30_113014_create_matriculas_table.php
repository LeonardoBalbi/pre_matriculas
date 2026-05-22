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
        Schema::create('matriculas', function (Blueprint $table) {
            $table->id();
            $table->biginteger('protocolo')->unsigned()->default(0);
            $table->year('ano_letivo')->nullable();
            $table->string('data_nascimento')->nullable();
            $table->string('nome_candidato')->nullable();
            $table->string('cpf_candidato');
            $table->unsignedbiginteger('escola_nome_id')->nullable();
            $table->unsignedbiginteger('turma_id')->nullable();
            $table->string('observacao')->nullable();
            $table->string('data_inscricao')->nullable();
            $table->string('idade')->nullable();
            $table->string('idade_corte_meses')->nullable();
            $table->string('idade_data_corte')->nullable();
            $table->string('idade_data_corte_mes')->nullable();
            $table->string('idade_data_corte_dias')->nullable();
            $table->enum('sexo', ['feminino', 'masculino', 'outros'])->nullable();
            $table->enum('irmao_creche', ['sim', 'não'])->nullable();
            $table->enum('irmao_gemeo', ['sim', 'não'])->nullable();
            $table->string('nome_irmao_gemeo')->nullable();
            $table->enum('carteira_vacinacao', ['sim', 'não'])->nullable();
            $table->enum('cartao_sus', ['sim', 'não'])->nullable();
            $table->enum('bolsa_familia', ['sim', 'não'])->nullable();
            $table->enum('cad_unico', ['sim', 'não'])->nullable();
            $table->enum('vulneravel_social', ['sim', 'não'])->nullable();
            $table->enum('portador_deficiencia', ['sim', 'não'])->nullable();
            $table->unsignedBigInteger('tipo_deficiencia_id')->nullable();
            $table->unsignedBigInteger('distrito_id')->nullable();
            $table->string('endereco')->nullable();
            $table->unsignedbiginteger('escola_bairro_id',)->nullable();
            $table->enum('grau_parentesco', ['pai', 'mãe', 'responsável legal'])->nullable();
            $table->string('nome_responsavel')->nullable();
            $table->string('email_responsavel')->nullable();
            $table->date('data_nasc_responsavel')->nullable();
            $table->string('cpf_responsavel')->nullable();
            $table->string('rg_responsavel')->nullable();
            $table->enum('mae_menor', ['sim', 'não'])->nullable();
            $table->unsignedBigInteger('escolaridade_id')->nullable();
            $table->string('tel_fixo_responsavel')->nullable();
            $table->string('tel_cel_responsavel')->nullable();
            $table->string('pedido_transferencia')->nullable();
            $table->string('aceite_edital')->default('s');
            $table->string('acao_judicial_candidato')->nullable();
            $table->string('candidato_remanescente')->nullable();
            $table->string('tipo_formulario')->nullable();
            $table->string('data_reat_inscricao')->nullable();
            $table->string('inscricao_reativada')->nullable();
            $table->string('usr_login')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->timestamps();


        });
    }

    /**
     * reverse the migrations.
     */
    public function down(): void
    {
        schema::dropifexists('matriculas');
    }
};

