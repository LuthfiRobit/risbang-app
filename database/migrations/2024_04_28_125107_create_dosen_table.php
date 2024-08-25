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
        Schema::create('dosen', function (Blueprint $table) {
            $table->integer('id_dosen')->autoIncrement()->unsigned();
            $table->integer('user_id')->unsigned();
            $table->integer('prodi_id')->unsigned();
            $table->integer('bidang_ilmu_id')->unsigned()->nullable();
            $table->integer('kepakaran_id')->unsigned()->nullable();
            $table->string('nidn')->unique()->nullable();
            $table->string('nik')->unique()->nullable();
            $table->string('no_tlpn', 30)->nullable();
            $table->string('email')->nullable();
            $table->string('nama_dosen')->nullable();
            $table->enum('jk', ['l', 'p'])->nullable();
            $table->string('kode_pos')->nullable();
            $table->text('alamat')->nullable();
            $table->enum('status_dosen', ['tetap', 'tidak tetap'])->nullable();
            $table->enum('jabatan', ['lecture', 'asisten ahli', 'lektor', 'lektor kepala', 'guru besar'])->default('lecture');
            $table->enum('status_serdos', ['belum terferifikasi', 'terferifikasi'])->nullable();
            $table->enum('pendidikan_terakhir', ['s1', 's2', 's3', 'prof'])->nullable();
            $table->string('instansi_pendidikan_terakhir')->nullable();
            $table->string('rekening')->nullable();
            $table->string('namabank_kantorcabang')->nullable();
            $table->string('nama_akunbank')->nullable();
            $table->string('link_google_scholar')->nullable();
            $table->string('link_sinta')->nullable();
            $table->string('link_scopus')->nullable();
            $table->string('link_orcid')->nullable();
            $table->string('link_publons')->nullable();
            $table->string('link_garuda')->nullable();
            $table->string('no_npwp')->nullable();
            $table->text('file_ktp')->nullable();
            $table->text('file_sk_dosen')->nullable();
            $table->text('file_npwp')->nullable();
            $table->text('img_ttd')->nullable();
            $table->text('img_profil')->nullable();
            $table->text('token_aktifasi_dosen')->nullable();
            $table->timestamps();
        });

        Schema::table('dosen', function (Blueprint $table) {
            $table->foreign('user_id')->references('id_user')->on('users');
            $table->foreign('prodi_id')->references('id_prodi')->on('prodi');
            $table->foreign('bidang_ilmu_id')->references('id_bidang_ilmu')->on('bidang_ilmu');
            $table->foreign('kepakaran_id')->references('id_kepakaran')->on('kepakaran');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dosen');
    }
};
