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
        Schema::create('review_kemajuan_proposal', function (Blueprint $table) {
            $table->integer('id_review_kemajuan_proposal')->autoIncrement()->unsigned();
            $table->integer('kemajuan_proposal_id')->unsigned()->nullable();
            $table->integer('reviewer_id')->unsigned()->nullable();
            $table->text('komen')->nullable();
            $table->integer('skor_publikasi')->nullable();
            $table->integer('skor_pemakalah')->nullable();
            $table->integer('skor_bahan')->nullable();
            $table->integer('skor_ttg')->nullable();
            $table->integer('nilai')->nullable();
            $table->timestamps();
        });

        Schema::table('review_kemajuan_proposal', function (Blueprint $table) {
            $table->foreign('kemajuan_proposal_id')->references('id_kemajuan_proposal')->on('kemajuan_proposal');
            $table->foreign('reviewer_id')->references('id_reviewer')->on('reviewer');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review_kemajuan_proposal');
    }
};
