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
        Schema::create('proposal_luaran', function (Blueprint $table) {
            $table->integer('id_proposal_luaran')->autoIncrement()->unsigned();
            $table->integer('dosen_id')->unsigned()->nullable();
            $table->integer('tahun_akademik_id')->unsigned()->nullable();
            // $table->integer('proposal_id')->unsigned()->nullable(); 
            $table->enum('jenis_luaran', ['Jurnal Penelitian', 'Jurnal Pengabdian', 'Haki', 'Buku'])->nullable();
            $table->enum('jenis_publikasi', ['Internasional', 'Nasional Terakreditasi', 'Nasional Tidak Terakreditasi'])->nullable();
            $table->enum('jenis_haki', ['Haki', 'Merk', 'Paten', 'Rahasia Dagang', 'Desain Industri', 'Indikasi Geografis', 'Desain Tata Letak Sirkuit Terpadu'])->nullable();
            $table->enum('jenis_buku', ['Buku Ajar', 'Buku Referensi', 'Monograf', 'Modul Ajar'])->nullable();
            $table->enum('status', ['Pengajuan', 'Kemajuan', 'Pelaksanaan', 'Selesai', 'Terhenti'])->default('Pengajuan');
            $table->enum('status_review', ['Diterima', 'Ditolak', 'Direvisi'])->nullable();
            $table->string('judul')->nullable();
            $table->string('penerbit')->nullable();
            $table->timestamps();
        });

        Schema::table('proposal_luaran', function (Blueprint $table) {
            $table->foreign('tahun_akademik_id')->references('id_tahun_akademik')->on('tahun_akademik');
            $table->foreign('dosen_id')->references('id_dosen')->on('dosen');
            // $table->foreign('proposal_id')->references('id_proposal')->on('proposal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposal_luaran');
    }
};
