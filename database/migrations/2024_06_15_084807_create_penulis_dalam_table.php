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
        Schema::create('penulis_dalam', function (Blueprint $table) {
            $table->integer('id_penulis_dalam')->autoIncrement()->unsigned();
            $table->integer('dosen_id')->unsigned()->nullable();
            $table->integer('arsip_id')->unsigned()->nullable();
            $table->integer('arsip_jurnal_id')->unsigned()->nullable();
            $table->integer('arsip_haki_id')->unsigned()->nullable();
            $table->integer('arsip_buku_id')->unsigned()->nullable();
            $table->enum('peran_umum', ['Ketua', 'Anggota'])->nullable();
            $table->enum('peran_khusus', ['Penulis', 'Editor', 'Penerjemah', 'Penemu'])->nullable();
            $table->boolean('koresponden')->default(false);
            $table->string('afiliasi')->nullable();
            $table->timestamps();
        });

        Schema::table('penulis_dalam', function (Blueprint $table) {
            $table->foreign('dosen_id')->references('id_dosen')->on('dosen');
            $table->foreign('arsip_id')->references('id_arsip')->on('arsip');
            $table->foreign('arsip_jurnal_id')->references('id_arsip_jurnal')->on('arsip_jurnal');
            $table->foreign('arsip_haki_id')->references('id_arsip_haki')->on('arsip_haki');
            $table->foreign('arsip_buku_id')->references('id_arsip_buku')->on('arsip_buku');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penulis_dalam');
    }
};
