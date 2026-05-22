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
        Schema::create('candidato_xps', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_candidato');
            $table->unsignedBigInteger('id_vagas_xp');
            $table->unsignedBigInteger('id_vagas_xp_plus');
            $table->timestamps();

            $table->foreign('id_candidato')->references('id')->on('candidatos')->onDelete('cascade');
            $table->foreign('id_vagas_xp')->references('id')->on('vagas_xps')->onDelete('cascade');
            $table->foreign('id_vagas_xp_plus')->references('id')->on('vagas_xp_pluses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidato_xps');
    }
};
