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
        Schema::create('dosen_lain', function (Blueprint $table) {
            $table->integer('id_dosen_lain')->autoIncrement()->unsigned();
            $table->string('nik')->nullable();
            $table->string('nama')->nullable();
            $table->text('alamat')->nullable();
            $table->enum('jk', ['l', 'p'])->nullable();
            $table->enum('pendidikan_terakhir', ['s1', 's2', 's3', 'prof'])->nullable();
            $table->string('no_tlpn', 30)->nullable();
            $table->string('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dosen_lain');
    }
};
