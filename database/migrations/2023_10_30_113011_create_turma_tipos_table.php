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
        Schema::create('turma_tipos', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_descricao')->nullable();
            $table->enum('tipo_status', ['ativo', 'inativo'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * reverse the migrations.
     */
    public function down(): void
    {
        schema::dropifexists('turma_tipos');
    }
};
