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
        Schema::create('berita', function (Blueprint $table) {
            $table->integer('id_berita')->autoIncrement()->unsigned();
            $table->enum('publish', ['y', 't'])->nullable();
            $table->string('judul')->nullable();
            $table->string('slug')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('img_berita')->nullable();
            $table->string('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berita');
    }
};
