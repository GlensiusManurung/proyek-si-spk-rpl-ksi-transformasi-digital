<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->id('driver_id');
            $table->foreignId('user_id')->constrained('users', 'user_id')->onDelete('cascade');
            $table->string('nama');
            $table->string('no_sim', 50)->unique();
            $table->string('nik', 20)->unique();
            $table->string('no_rek', 30)->nullable();
            $table->string('nomor_kontak', 15);
            $table->text('alamat')->nullable();
            $table->timestamps();
            
            // Index
            $table->index('user_id');
            $table->index('no_sim');
            $table->index('nik');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};