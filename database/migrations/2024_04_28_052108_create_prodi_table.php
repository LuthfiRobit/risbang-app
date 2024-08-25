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
        Schema::create('prodi', function (Blueprint $table) {
            $table->integer('id_prodi')->autoIncrement()->unsigned();
            $table->integer('fakultas_id')->unsigned();
            $table->integer('user_id')->unsigned()->nullable();
            $table->string('nama_prodi')->nullable();
            $table->string('singkatan')->nullable();
            $table->string('nama_kaprodi')->nullable();
            $table->string('image')->nullable();
            $table->integer('urut')->unsigned()->nullable();
            $table->enum('aktif', ['y', 't'])->default('y');
            $table->text('token_aktifasi_prodi')->nullable();
            $table->timestamps();
        });

        Schema::table('prodi', function (Blueprint $table) {
            $table->foreign('user_id')->references('id_user')->on('users');
            $table->foreign('fakultas_id')->references('id_fakultas')->on('fakultas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prodi');
    }
};
