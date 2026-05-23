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
        if (Schema::hasColumn('escolas', 'escola_foto')) {
            return;
        }

        Schema::table('escolas', function (Blueprint $table) {
            $table->string('escola_foto')->nullable()->after('escola_endereco');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasColumn('escolas', 'escola_foto')) {
            return;
        }

        Schema::table('escolas', function (Blueprint $table) {
            $table->dropColumn('escola_foto');
        });
    }
};
