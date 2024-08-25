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
        Schema::create('review_luaran_proposal', function (Blueprint $table) {
            $table->integer('id_review_luaran_proposal')->autoIncrement()->unsigned();
            $table->integer('luaran_proposal_id')->unsigned()->nullable();
            $table->integer('reviewer_id')->unsigned()->nullable();
            $table->text('komen')->nullable();
            $table->integer('nilai')->nullable();
            $table->timestamps();
        });

        Schema::table('review_luaran_proposal', function (Blueprint $table) {
            $table->foreign('luaran_proposal_id')->references('id_luaran_proposal')->on('luaran_proposal');
            $table->foreign('reviewer_id')->references('id_reviewer')->on('reviewer');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review_luaran_proposal');
    }
};
