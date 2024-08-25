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
        Schema::create('surat_template', function (Blueprint $table) {
            $table->integer('id_surat_template')->autoIncrement()->unsigned();
            $table->enum('status', ['y', 't'])->nullable();
            $table->string('nama_template')->nullable();
            $table->text('deskripsi')->nullable();
            $table->text('template')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_template');
    }
};
