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
        Schema::create('users', function (Blueprint $table) {
            $table->integer('id_user')->autoIncrement()->unsigned();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('username')->nullable();
            $table->string('password');
            $table->string('phone_number', 30)->nullable();
            $table->enum('user_role', ['admin', 'dosen', 'reviewer', 'developer'])->nullable();
            $table->enum('dosen_role', ['dosen', 'kaprodi', 'dekan'])->nullable();
            $table->enum('active', ['y', 't'])->default('y');
            $table->string('profile_pict')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
