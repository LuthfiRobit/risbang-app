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
        Schema::create('fakultas', function (Blueprint $table) {
            $table->integer('id_fakultas')->autoIncrement()->unsigned();
            $table->integer('user_id')->unsigned()->nullable();
            $table->string('nama_fakultas')->nullable();
            $table->string('singkatan')->nullable();
            $table->string('nama_dekan')->nullable();
            $table->string('image')->nullable();
            $table->integer('urut')->unsigned()->nullable();
            $table->enum('aktif', ['y', 't'])->default('y');
            $table->text('token_aktifasi_fakultas')->nullable();
            $table->timestamps();
        });

        Schema::table('fakultas', function (Blueprint $table) {
            $table->foreign('user_id')->references('id_user')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fakultas');
    }
};
