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
        Schema::create('arsip_produk', function (Blueprint $table) {
            $table->integer('id_arsip_produk')->autoIncrement()->unsigned();
            $table->integer('arsip_id')->unsigned()->nullable();
            $table->integer('dosen_id')->unsigned()->nullable();
            $table->integer('tahun_akademik_id')->unsigned()->nullable();
            $table->enum('jenis', ['Penelitian', 'Pengabdian'])->nullable();
            $table->enum('publish', ['y', 't'])->nullable();
            $table->string('judul')->nullable();
            $table->enum('tkt', ['Seni', 'Alkes', 'Vaksin', 'Software', 'Obat/Farmasi', 'Sosial Humaniora', 'Engeneering/Umum', 'Pertanian/Perikanan/Peternakan'])->nullable();
            $table->enum('level', ['1', '2', '3', '4', '5', '6', '7', '8', '9'])->nullable();
            $table->year('tahun_pelaksanaan')->nullable();
            $table->string('link')->nullable();
            $table->string('mitra')->nullable();
            $table->string('jenis_mitra')->nullable();
            $table->string('negara_mitra')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('file_arsip_produk')->nullable();
            $table->string('cover_arsip_produk')->nullable();
            $table->string('created_by')->nullable();
            $table->timestamps();
        });

        Schema::table('arsip_produk', function (Blueprint $table) {
            $table->foreign('arsip_id')->references('id_arsip')->on('arsip');
            $table->foreign('dosen_id')->references('id_dosen')->on('dosen');
            $table->foreign('tahun_akademik_id')->references('id_tahun_akademik')->on('tahun_akademik');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('arsip_produk');
    }
};
