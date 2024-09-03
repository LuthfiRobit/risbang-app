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
        Schema::create('history_pelaksanaan_proposal', function (Blueprint $table) {
            $table->integer('id_history_pelaksanaan_proposal')->autoIncrement()->unsigned();
            $table->integer('pelaksanaan_proposal_id')->unsigned()->nullable();
            $table->string('nama_kegiatan')->nullable();
            $table->string('tempat_kegiatan')->nullable();
            $table->text('keterangan')->nullable();
            $table->date('tanggal')->nullable();
            $table->timestamps();
        });

        Schema::table('history_pelaksanaan_proposal', function (Blueprint $table) {
            $table->foreign('pelaksanaan_proposal_id')->references('id_pelaksanaan_proposal')->on('pelaksanaan_proposal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_pelaksanaan_proposal');
    }
};
