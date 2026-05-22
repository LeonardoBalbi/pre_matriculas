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
        Schema::create('vagas_xps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_vagas')->nullable();
            $table->string('titulo');
            $table->timestamps();

            $table->foreign('id_vagas')->references('id')->on('vagas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vagas_xps');
    }
};
