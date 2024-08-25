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
        Schema::create('history_proposal', function (Blueprint $table) {
            $table->integer('id_history_proposal')->autoIncrement()->unsigned();
            $table->integer('proposal_id')->unsigned()->nullable();
            $table->string('judul')->nullable();
            $table->text('abstrak')->nullable();
            $table->string('kata_kunci')->nullable();
            $table->text('latar_belakang')->nullable();
            $table->text('metode')->nullable();
            $table->text('rencana')->nullable();
            $table->text('dapus')->nullable();
            $table->string('file_proposal')->nullable();
            $table->timestamps();
        });

        Schema::table('history_proposal', function (Blueprint $table) {
            $table->foreign('proposal_id')->references('id_proposal')->on('proposal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_proposal');
    }
};
