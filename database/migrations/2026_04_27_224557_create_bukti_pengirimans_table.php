<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bukti_pengirimans', function (Blueprint $table) {
            $table->id('bukti_pengiriman_id');
            
            $table->foreignId('pengiriman_id')
                  ->constrained('pengirimans', 'pengiriman_id')
                  ->onDelete('cascade');
            
            $table->date('tanggal_bukti');
            $table->string('gambar'); // foto / file bukti
            $table->text('deskripsi')->nullable();
            $table->string('uploaded_by')->nullable(); // siapa yang upload
            $table->timestamps();
            
            // Index
            $table->index('pengiriman_id');
            $table->index('tanggal_bukti');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bukti_pengirimans');
    }
};