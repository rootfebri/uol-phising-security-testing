<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('visitors', static function (Blueprint $table) {
            if (!Schema::hasColumn('visitors', 'is_blocked')) {
                $table->boolean('is_blocked')->default(false);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('visitors', static function (Blueprint $table) {
            if (Schema::hasColumn('visitors', 'is_blocked')) {
                $table->dropColumn('is_blocked');
            }
        });
    }
};
