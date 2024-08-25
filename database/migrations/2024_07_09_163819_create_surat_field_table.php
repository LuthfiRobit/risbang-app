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
        Schema::create('surat_field', function (Blueprint $table) {
            $table->integer('id_surat_field')->autoIncrement()->unsigned();
            $table->integer('surat_template_id')->unsigned()->nullable();
            $table->string('field_name');
            $table->string('field_type');
            $table->string('field_placeholder');
            $table->string('field_required');
            $table->enum('status', ['y', 't'])->nullable();
            $table->timestamps();
        });

        Schema::table('surat_field', function (Blueprint $table) {
            $table->foreign('surat_template_id')->references('id_surat_template')->on('surat_template');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_field');
    }
};
