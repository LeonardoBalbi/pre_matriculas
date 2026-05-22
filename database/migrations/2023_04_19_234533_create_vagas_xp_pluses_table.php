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
        Schema::create('vagas_xp_pluses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_vagas_xps')->nullable();
            $table->string('titulo');
            $table->string('pontos')->nullable();
            $table->timestamps();

            $table->foreign('id_vagas_xps')->references('id')->on('vagas_xps')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vagas_xp_pluses');
    }
};
