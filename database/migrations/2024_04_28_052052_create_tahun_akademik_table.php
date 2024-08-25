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
        Schema::create('tahun_akademik', function (Blueprint $table) {
            $table->integer('id_tahun_akademik')->autoIncrement()->unsigned();
            $table->year('tahun_awal');
            $table->year('tahun_akhir');
            $table->string('nama_tahun_akademik')->nullable();
            $table->enum('aktif', ['y', 't'])->default('t');
            $table->enum('buku', ['y', 't'])->default('t');
            $table->enum('haki', ['y', 't'])->default('t');
            $table->enum('nilai_baru', ['y', 't'])->default('t');
            $table->text('token_aktifasi_tahun_akademik')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tahun_akademik');
    }
};
