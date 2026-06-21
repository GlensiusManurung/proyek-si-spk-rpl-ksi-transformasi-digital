<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengajuans', function (Blueprint $table) {
            $table->id('pengajuan_id');
            
            $table->foreignId('driver_id')->constrained('drivers', 'driver_id')->onDelete('cascade');
            $table->foreignId('mobil_id')->constrained('mobils', 'mobil_id')->onDelete('cascade');
            
            $table->enum('status', ['pending', 'disetujui', 'ditolak'])->default('pending');
            $table->string('disetujui_oleh', 100)->nullable();
            
            $table->date('tanggal_pengajuan');
            $table->date('tanggal_disetujui')->nullable();
            
            $table->string('bukti_struk')->nullable(); // upload gambar/pdf
            $table->text('keterangan')->nullable();
            
            $table->timestamps();
            
            // Index
            $table->index('driver_id');
            $table->index('mobil_id');
            $table->index('status');
            $table->index('tanggal_pengajuan');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuans');
    }
};