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
        Schema::create('report_links', function (Blueprint $table) {
            $table->id();
            $table->enum('kategori', ['visit', 'non_pots']); // Membedakan jenis data
            $table->string('periode_bulan'); // Menyimpan input bulan (ex: Maret 2026)
            $table->text('spreadsheet_url'); // Menyimpan link panjang asli
            $table->string('spreadsheet_id'); // Menyimpan ID spesifik yang akan dibaca API
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('report_links');
    }
};
