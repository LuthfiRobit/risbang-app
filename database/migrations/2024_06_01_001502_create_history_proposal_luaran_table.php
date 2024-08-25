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
        Schema::create('history_proposal_luaran', function (Blueprint $table) {
            $table->integer('id_history_proposal_luaran')->autoIncrement()->unsigned();
            $table->integer('proposal_luaran_id')->unsigned()->nullable();
            $table->string('judul')->nullable();
            $table->string('penerbit')->nullable();
            $table->timestamps();
        });

        Schema::table('history_proposal_luaran', function (Blueprint $table) {
            $table->foreign('proposal_luaran_id')->references('id_proposal_luaran')->on('proposal_luaran');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_proposal_luaran');
    }
};
