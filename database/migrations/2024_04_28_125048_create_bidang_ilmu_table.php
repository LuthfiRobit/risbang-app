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
        Schema::create('bidang_ilmu', function (Blueprint $table) {
            $table->integer('id_bidang_ilmu')->autoIncrement()->unsigned();
            $table->string('nama_bidang_ilmu')->nullable();
            $table->enum('aktif', ['y', 't'])->default('y');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bidang_ilmu');
    }
};
