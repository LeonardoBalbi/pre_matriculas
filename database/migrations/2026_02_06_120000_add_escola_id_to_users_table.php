<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'escola_id')) {
                $table->unsignedBigInteger('escola_id')->nullable()->after('current_team_id');
                $table->foreign('escola_id')->references('id')->on('escolas')->onDelete('set null');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'escola_id')) {
                $table->dropForeign(['escola_id']);
                $table->dropColumn('escola_id');
            }
        });
    }
};
