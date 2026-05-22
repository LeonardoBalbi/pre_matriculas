<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cpf_autorizados', function (Blueprint $table) {
            $table->id();
            $table->string('cpf')->unique();
            $table->text('motivo')->nullable();
            $table->unsignedBigInteger('user_id')->nullable(); // Quem autorizou
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cpf_autorizados');
    }
};
