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
        Schema::create('rentan_waktu', function (Blueprint $table) {
            $table->integer('id_rentan_waktu')->autoIncrement()->unsigned();
            $table->year('tahun_awal');
            $table->year('tahun_akhir');
            $table->string('nama_rentan_waktu')->nullable();
            $table->enum('aktif', ['y', 't'])->default('t');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rentan_waktu');
    }
};
