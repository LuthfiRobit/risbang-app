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
        Schema::create('reviewer', function (Blueprint $table) {
            $table->integer('id_reviewer')->autoIncrement()->unsigned();
            $table->integer('user_id')->unsigned()->nullable();
            $table->string('nama_reviewer')->nullable();
            $table->enum('aktif', ['y', 't'])->default('y');
            $table->text('token_aktifasi_reviewer')->nullable();
            $table->timestamps();
        });

        Schema::table('reviewer', function (Blueprint $table) {
            $table->foreign('user_id')->references('id_user')->on('users');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviewer');
    }
};
