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
        Schema::create('detail_reviewer', function (Blueprint $table) {
            $table->integer('id_detail_reviewer')->autoIncrement()->unsigned();
            $table->integer('reviewer_id')->unsigned()->nullable();
            $table->integer('dosen_id')->unsigned()->nullable();
            $table->integer('tahun_akademik_id')->unsigned()->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

        Schema::table('detail_reviewer', function (Blueprint $table) {
            $table->foreign('tahun_akademik_id')->references('id_tahun_akademik')->on('tahun_akademik');
            $table->foreign('reviewer_id')->references('id_reviewer')->on('reviewer');
            $table->foreign('dosen_id')->references('id_dosen')->on('dosen');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_reviewer');
    }
};
