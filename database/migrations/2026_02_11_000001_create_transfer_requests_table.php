<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transfer_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('matricula_id');
            $table->unsignedBigInteger('from_escola_id');
            $table->unsignedBigInteger('to_escola_id');
            $table->unsignedBigInteger('requested_by');
            $table->unsignedBigInteger('authorized_by')->nullable();
            $table->string('status')->default('pending');
            $table->text('reason')->nullable();
            $table->timestamp('authorized_at')->nullable();
            $table->timestamps();
            $table->foreign('matricula_id')->references('id')->on('matriculas')->onDelete('cascade');
            $table->foreign('from_escola_id')->references('id')->on('escolas')->onDelete('cascade');
            $table->foreign('to_escola_id')->references('id')->on('escolas')->onDelete('cascade');
            $table->foreign('requested_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('authorized_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transfer_requests');
    }
};
