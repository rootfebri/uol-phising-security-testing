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
        Schema::table('settings', static function (Blueprint $table) {
            if (!Schema::hasColumn('settings', 'ipify_key')) {
                $table->string('ipify_key')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', static function (Blueprint $table) {
            if (Schema::hasColumn('settings', 'ipify_key')) {
                $table->dropColumn('ipify_key');
            }
        });
    }
};
