<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id('customer_id');
            $table->string('nama_perusahaan', 100);
            $table->text('alamat');
            $table->string('nomor_kontak', 15);
            $table->string('email')->nullable();
            $table->string('pic')->nullable(); // Person In Charge
            $table->text('keterangan')->nullable();
            $table->timestamps();
            
            $table->index('nama_perusahaan');
            $table->index('nomor_kontak');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};