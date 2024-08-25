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
        Schema::create('history_kemajuan_proposal', function (Blueprint $table) {
            $table->integer('id_history_kemajuan_proposal')->autoIncrement()->unsigned();
            $table->integer('kemajuan_proposal_id')->unsigned()->nullable();
            $table->enum('status_review', ['Diterima', 'Ditolak', 'Direvisi'])->nullable();
            $table->text('link_drive')->nullable();
            $table->string('file_kemajuan')->nullable();
            $table->timestamps();
        });

        Schema::table('history_kemajuan_proposal', function (Blueprint $table) {
            $table->foreign('kemajuan_proposal_id')->references('id_kemajuan_proposal')->on('kemajuan_proposal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_kemajuan_proposal');
    }
};
