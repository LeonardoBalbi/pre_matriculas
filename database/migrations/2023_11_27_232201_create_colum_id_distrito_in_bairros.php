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
        Schema::table('bairros', function (Blueprint $table) {            
            $table->unsignedBigInteger('distrito_id')->nullable()->after('descricao');
            $table->foreign('distrito_id')->references('id')->on('distritos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bairros', function (Blueprint $table) {
            $table->dropForeign('bairros_distrito_id_foreign');
            $table->dropColumn('distrito_id');
        });
    }
};
