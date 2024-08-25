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
        Schema::create('surat', function (Blueprint $table) {
            $table->integer('id_surat')->autoIncrement()->unsigned();
            $table->integer('surat_template_id')->unsigned()->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->integer('dosen_id')->unsigned()->nullable();
            $table->string('nomor_surat')->nullable();
            $table->text('data')->nullable();
            $table->enum('status', ['y', 't'])->nullable();
            $table->timestamps();
        });

        Schema::table('surat', function (Blueprint $table) {
            $table->foreign('surat_template_id')->references('id_surat_template')->on('surat_template');
            $table->foreign('user_id')->references('id_user')->on('users');
            $table->foreign('dosen_id')->references('id_dosen')->on('dosen');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat');
    }
};
