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
        Schema::create('roadmap', function (Blueprint $table) {
            $table->integer('id_roadmap')->autoIncrement()->unsigned();
            $table->integer('dosen_id')->unsigned()->nullable();
            $table->integer('prodi_id')->unsigned()->nullable();
            $table->integer('rentan_waktu_id')->unsigned()->nullable();
            $table->enum('jenis', ['Penelitian', 'Pengabdian'])->nullable();
            $table->string('nama_roadmap')->nullable();
            $table->text('berkas')->nullable();
            $table->enum('status', ['Pengajuan', 'Revisi', 'Acc'])->default('Pengajuan');
            $table->date('tanggal_upload')->nullable();
            $table->text('komentar')->nullable();
            $table->timestamps();
        });

        Schema::table('roadmap', function (Blueprint $table) {
            $table->foreign('dosen_id')->references('id_dosen')->on('dosen');
            $table->foreign('prodi_id')->references('id_prodi')->on('prodi');
            $table->foreign('rentan_waktu_id')->references('id_rentan_waktu')->on('rentan_waktu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roadmap');
    }
};
