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
        Schema::create('escolas', function (Blueprint $table) {
            $table->id();
            $table->string('escola_nome')->nullable();
            $table->string('escola_endereco')->nullable();
            $table->unsignedbiginteger('escola_bairro_id')->nullable();
            $table->unsignedbiginteger('escola_distrito_id')->nullable();
            $table->integer('escola_vagas')->nullable();
            $table->integer('escola_vagas_especiais')->nullable();
            $table->year('escola_ano_leitivo')->nullable();
            $table->enum('escola_status', ['ativa', 'inativa'])->nullable();
            $table->timestamps();
        
            $table->foreign('escola_bairro_id', 'escolas_escola_bairro_id_foreign')->references('id')->on('bairros')->ondelete('cascade');

            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('escolas');
    }
};
