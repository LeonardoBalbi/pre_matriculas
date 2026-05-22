<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('escola_turma_tipo', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('escola_id');
            $table->unsignedBigInteger('turma_tipo_id');
            $table->timestamps();

            $table->foreign('escola_id')->references('id')->on('escolas')->onDelete('cascade');
            $table->foreign('turma_tipo_id')->references('id')->on('turma_tipos')->onDelete('cascade');
            $table->unique(['escola_id', 'turma_tipo_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('escola_turma_tipo');
    }
};
