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
        Schema::create('matriculas_deleted_log', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('matricula_id')->comment('ID da matrícula excluída');
            $table->unsignedBigInteger('deleted_by')->nullable()->comment('ID do usuário que excluiu');
            $table->string('deleted_by_name')->nullable()->comment('Nome do usuário que excluiu');
            $table->text('motivo_exclusao')->nullable()->comment('Motivo da exclusão');
            $table->json('dados_matricula')->nullable()->comment('Dados da matrícula em formato JSON');
            $table->timestamps();

            // Chave estrangeira para o usuário que excluiu
            $table->foreign('deleted_by')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matriculas_deleted_log');
    }
};
