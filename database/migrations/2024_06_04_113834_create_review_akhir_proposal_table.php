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
        Schema::create('review_akhir_proposal', function (Blueprint $table) {
            $table->integer('id_review_akhir_proposal')->autoIncrement()->unsigned();
            $table->integer('akhir_proposal_id')->unsigned()->nullable();
            $table->integer('reviewer_id')->unsigned()->nullable();
            $table->text('komen')->nullable();
            $table->integer('nilai')->nullable();
            $table->timestamps();
        });

        Schema::table('review_akhir_proposal', function (Blueprint $table) {
            $table->foreign('akhir_proposal_id')->references('id_akhir_proposal')->on('akhir_proposal');
            $table->foreign('reviewer_id')->references('id_reviewer')->on('reviewer');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review_akhir_proposal');
    }
};
