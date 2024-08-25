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
        Schema::create('review_proposal', function (Blueprint $table) {
            $table->integer('id_review_proposal')->autoIncrement()->unsigned();
            $table->integer('reviewer_id')->unsigned()->nullable();
            $table->integer('dosen_id')->unsigned()->nullable();
            $table->integer('proposal_id')->unsigned()->nullable();
            $table->text('komen_judul')->nullable();
            $table->integer('nilai_judul')->nullable();
            $table->text('komen_abstrak')->nullable();
            $table->integer('nilai_abstrak')->nullable();
            $table->text('komen_kata_kunci')->nullable();
            $table->integer('nilai_kata_kunci')->nullable();
            $table->text('komen_latar_belakang')->nullable();
            $table->integer('nilai_latar_belakang')->nullable();
            $table->text('komen_metode')->nullable();
            $table->integer('nilai_metode')->nullable();
            $table->text('komen_rencana')->nullable();
            $table->integer('nilai_rencana')->nullable();
            $table->text('komen_dapus')->nullable();
            $table->integer('nilai_dapus')->nullable();
            $table->timestamps();
        });

        Schema::table('review_proposal', function (Blueprint $table) {
            $table->foreign('reviewer_id')->references('id_reviewer')->on('reviewer');
            $table->foreign('dosen_id')->references('id_dosen')->on('dosen');
            $table->foreign('proposal_id')->references('id_proposal')->on('proposal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review_proposal');
    }
};
