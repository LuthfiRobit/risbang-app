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
        Schema::create('proposal', function (Blueprint $table) {
            $table->integer('id_proposal')->autoIncrement()->unsigned();
            $table->integer('dosen_id')->unsigned()->nullable();
            $table->integer('tahun_akademik_id')->unsigned()->nullable();
            $table->enum('jenis', ['Penelitian', 'Pengabdian'])->nullable();
            $table->enum('status', ['Pengajuan', 'Kemajuan', 'Pelaksanaan', 'Selesai', 'Terhenti'])->default('Pengajuan');
            $table->enum('status_review', ['Diterima', 'Ditolak', 'Direvisi'])->nullable();
            $table->enum('jenis_penelitian', ['Dasar', 'Terapan', 'Strategis Nasional'])->nullable();
            $table->enum('jenis_pengabdian', ['Layanan', 'Pendampingan', 'Pemberdayaan', 'Pengembangan Produk'])->nullable();
            $table->integer('dana')->nullable();
            $table->string('judul')->nullable();
            $table->text('abstrak')->nullable();
            $table->string('kata_kunci')->nullable();
            $table->text('latar_belakang')->nullable();
            $table->text('metode')->nullable();
            $table->text('rencana')->nullable();
            $table->text('dapus')->nullable();
            $table->string('file_proposal')->nullable();
            $table->timestamps();
        });

        Schema::table('proposal', function (Blueprint $table) {
            $table->foreign('dosen_id')->references('id_dosen')->on('dosen');
            $table->foreign('tahun_akademik_id')->references('id_tahun_akademik')->on('tahun_akademik');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposal');
    }
};
