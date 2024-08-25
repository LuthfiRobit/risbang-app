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
        Schema::create('kepakaran', function (Blueprint $table) {
            $table->integer('id_kepakaran')->autoIncrement()->unsigned();
            $table->integer('bidang_ilmu_id')->unsigned();
            $table->string('nama_kepakaran')->nullable();
            $table->enum('aktif', ['y', 't'])->default('y');
            $table->timestamps();
        });

        Schema::table('kepakaran', function (Blueprint $table) {
            $table->foreign('bidang_ilmu_id')->references('id_bidang_ilmu')->on('bidang_ilmu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kepakaran');
    }
};
