<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengirimans', function (Blueprint $table) {
            $table->id('pengiriman_id');
            
            $table->foreignId('pengajuan_id')
                  ->constrained('pengajuans', 'pengajuan_id')
                  ->onDelete('cascade');
            
            $table->string('nomor_surat_jalan', 50)->unique();
            $table->enum('status', ['proses', 'dikirim', 'selesai'])->default('proses');
            $table->date('tanggal_pengiriman');
            $table->text('deskripsi')->nullable();
            $table->string('gambar')->nullable(); // upload gambar bukti
            $table->text('catatan')->nullable();
            
            $table->timestamps();
            
            // Index
            $table->index('pengajuan_id');
            $table->index('nomor_surat_jalan');
            $table->index('status');
            $table->index('tanggal_pengiriman');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengirimans');
    }
};