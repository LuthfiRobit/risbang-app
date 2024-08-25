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
        Schema::create('kemajuan_proposal', function (Blueprint $table) {
            $table->integer('id_kemajuan_proposal')->autoIncrement()->unsigned();
            $table->integer('proposal_id')->unsigned()->nullable();
            $table->integer('dosen_id')->unsigned()->nullable();
            $table->integer('tahun_akademik_id')->unsigned()->nullable();
            $table->enum('jenis', ['Penelitian', 'Pengabdian'])->nullable();
            $table->enum('status_review', ['Diterima', 'Ditolak', 'Direvisi'])->nullable();
            $table->text('link_drive')->nullable();
            $table->string('file_kemajuan')->nullable();
            $table->timestamps();
        });

        Schema::table('kemajuan_proposal', function (Blueprint $table) {
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
        Schema::dropIfExists('kemajuan_proposal');
    }
};
