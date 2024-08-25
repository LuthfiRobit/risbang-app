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
        Schema::create('luaran_proposal', function (Blueprint $table) {
            $table->integer('id_luaran_proposal')->autoIncrement()->unsigned();
            $table->integer('proposal_id')->unsigned()->nullable();
            $table->integer('dosen_id')->unsigned()->nullable();
            $table->integer('tahun_akademik_id')->unsigned()->nullable();
            $table->enum('jenis', ['Penelitian', 'Pengabdian'])->nullable();
            $table->enum('status_review', ['Diterima', 'Ditolak', 'Direvisi'])->nullable();
            $table->enum('jenis_publikasi', ['Internasional', 'Nasional Terakreditasi', 'Nasional Tidak Terakreditasi'])->nullable();
            $table->string('judul')->nullable();
            $table->string('penerbit')->nullable();
            $table->year('tahun_pelaksanaan')->nullable();
            $table->string('volume')->nullable();
            $table->string('nomor')->nullable();
            $table->string('link')->nullable();
            $table->string('issn')->nullable();
            $table->string('file_luaran')->nullable();
            $table->timestamps();
        });

        Schema::table('luaran_proposal', function (Blueprint $table) {
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
        Schema::dropIfExists('luaran_proposal');
    }
};
