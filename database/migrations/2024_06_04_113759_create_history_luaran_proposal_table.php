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
        Schema::create('history_luaran_proposal', function (Blueprint $table) {
            $table->integer('id_history_luaran_proposal')->autoIncrement()->unsigned();
            $table->integer('luaran_proposal_id')->unsigned()->nullable();
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

        Schema::table('history_luaran_proposal', function (Blueprint $table) {
            $table->foreign('luaran_proposal_id')->references('id_luaran_proposal')->on('luaran_proposal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_luaran_proposal');
    }
};
