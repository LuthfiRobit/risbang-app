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
        Schema::create('review_proposal_luaran', function (Blueprint $table) {
            $table->integer('id_review_proposal_luaran')->autoIncrement()->unsigned();
            $table->integer('reviewer_id')->unsigned()->nullable();
            $table->integer('dosen_id')->unsigned()->nullable();
            $table->integer('proposal_luaran_id')->unsigned()->nullable();
            $table->text('komen')->nullable();
            $table->integer('nilai')->nullable();
            $table->timestamps();
        });

        Schema::table('review_proposal_luaran', function (Blueprint $table) {
            $table->foreign('reviewer_id')->references('id_reviewer')->on('reviewer');
            $table->foreign('dosen_id')->references('id_dosen')->on('dosen');
            $table->foreign('proposal_luaran_id')->references('id_proposal_luaran')->on('proposal_luaran');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review_proposal_luaran');
    }
};
