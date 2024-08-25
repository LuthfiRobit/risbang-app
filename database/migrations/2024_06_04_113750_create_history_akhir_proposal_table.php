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
        Schema::create('history_akhir_proposal', function (Blueprint $table) {
            $table->integer('id_history_akhir_proposal')->autoIncrement()->unsigned();
            $table->integer('akhir_proposal_id')->unsigned()->nullable();
            $table->enum('status_review', ['Diterima', 'Ditolak', 'Direvisi'])->nullable();
            $table->enum('keaslian', ['y', 't'])->nullable();
            $table->text('link_drive')->nullable();
            $table->string('file_akhir')->nullable();
            $table->timestamps();
        });

        Schema::table('history_akhir_proposal', function (Blueprint $table) {
            $table->foreign('akhir_proposal_id')->references('id_akhir_proposal')->on('akhir_proposal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_akhir_proposal');
    }
};
