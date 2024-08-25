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
        Schema::create('arsip_haki', function (Blueprint $table) {
            $table->integer('id_arsip_haki')->autoIncrement()->unsigned();
            $table->integer('proposal_id')->unsigned()->nullable();
            $table->integer('dosen_id')->unsigned()->nullable();
            $table->integer('tahun_akademik_id')->unsigned()->nullable();
            $table->enum('jenis', ['Penelitian', 'Pengabdian'])->nullable();
            $table->enum('publish', ['y', 't'])->nullable();
            $table->string('judul')->nullable();
            $table->enum('kategori_haki', ['Haki', 'Merk', 'Paten', 'Rahasia Dagang', 'Desain Industri', 'Indikasi Geografis', 'Desain Tata Letak Sirkuit Terpadu'])->nullable();
            $table->string('jenis_haki')->nullable();
            $table->year('tahun_pelaksanaan')->nullable();
            $table->string('pemegang')->nullable();
            $table->string('nomor')->nullable();
            $table->string('link')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('file_arsip_haki')->nullable();
            $table->string('created_by')->nullable();
            $table->timestamps();
        });

        Schema::table('arsip_haki', function (Blueprint $table) {
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
        Schema::dropIfExists('arsip_haki');
    }
};
