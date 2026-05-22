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
        Schema::create('vagas', function (Blueprint $table) {
            $table->id();
            $table->string('num_edital');
            $table->string('titulo');
            $table->integer('vaga_ac')->nullable();
            $table->integer('vaga_pcd')->nullable();
            $table->integer('vaga_negro')->nullable();
            $table->integer('vaga_indios')->nullable();
            $table->enum('status',['publicado', 'pausado', 'cancelado', 'finalizado'])->default('publicado')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vagas');
    }
};
