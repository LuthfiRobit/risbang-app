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
        Schema::create('arsip_jurnal', function (Blueprint $table) {
            $table->integer('id_arsip_jurnal')->autoIncrement()->unsigned();
            $table->integer('proposal_id')->unsigned()->nullable();
            $table->integer('dosen_id')->unsigned()->nullable();
            $table->integer('tahun_akademik_id')->unsigned()->nullable();
            $table->enum('jenis', ['Penelitian', 'Pengabdian'])->nullable();
            $table->enum('publish', ['y', 't'])->nullable();
            $table->string('judul')->nullable();
            $table->string('penerbit')->nullable();
            $table->enum('kategori_publikasi', ['Internasional', 'Nasional Terakreditasi', 'Nasional Tidak Terakreditasi'])->nullable();
            $table->string('peringkat')->nullable();
            $table->string('halaman')->nullable();
            $table->string('issn')->nullable();
            $table->year('tahun_pelaksanaan')->nullable();
            $table->string('volume')->nullable();
            $table->string('nomor')->nullable();
            $table->string('link')->nullable();
            $table->text('abstrak')->nullable();
            $table->string('file_arsip_jurnal')->nullable();
            $table->string('created_by')->nullable();
            $table->timestamps();
        });

        Schema::table('arsip_jurnal', function (Blueprint $table) {
            $table->foreign('proposal_id')->references('id_proposal')->on('proposal');
            $table->foreign('dosen_id')->references('id_dosen')->on('dosen');
            $table->foreign('tahun_akademik_id')->references('id_tahun_akademik')->on('tahun_akademik');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('arsip_jurnal');
    }
};