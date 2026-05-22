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
        Schema::create('gerals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_escola');
            $table->unsignedBigInteger('id_turma');
            $table->unsignedBigInteger('id_turma_tipo');
            $table->unsignedBigInteger('id_matricula');
            $table->timestamps();

            $table->foreign('id_escola')->references('id')->on('escolas')->onDelete('cascade');
            $table->foreign('id_turma')->references('id')->on('turmas')->onDelete('cascade');
            $table->foreign('id_turma_tipo')->references('id')->on('turma_tipos')->onDelete('cascade');
            $table->foreign('id_matricula')->references('id')->on('matriculas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gerals');
    }
};
