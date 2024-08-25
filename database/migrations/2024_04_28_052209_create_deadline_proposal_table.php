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
        Schema::create('deadline_proposal', function (Blueprint $table) {
            $table->integer('id_deadline_proposal')->autoIncrement()->unsigned();
            $table->integer('tahun_akademik_id')->unsigned();
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_akhir')->nullable();
            $table->string('nama_deadline_proposal')->nullable();
            $table->enum('jenis', ['Penelitian', 'Pengabdian', 'Prosiding', 'Buku', 'Laporan', 'Haki'])->nullable();
            $table->enum('keterangan', ['Proposal', 'Kemajuan', 'Akhir', 'Luaran'])->nullable();
            $table->text('deskripsi')->nullable();
            $table->enum('aktif', ['y', 't'])->default('t');
            $table->timestamps();
        });

        Schema::table('deadline_proposal', function (Blueprint $table) {
            $table->foreign('tahun_akademik_id')->references('id_tahun_akademik')->on('tahun_akademik');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deadline_proposal');
    }
};
