<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transfer_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('matricula_id');
            $table->unsignedBigInteger('from_escola_id')->nullable();
            $table->unsignedBigInteger('to_escola_id')->nullable();
            $table->string('action');
            $table->unsignedBigInteger('by_user_id')->nullable();
            $table->text('reason')->nullable();
            $table->timestamps();
            $table->foreign('matricula_id')->references('id')->on('matriculas')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transfer_logs');
    }
};
