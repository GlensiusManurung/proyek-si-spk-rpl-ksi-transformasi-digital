<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            
            // Jenis notifikasi
            $table->enum('type', ['chat', 'pengiriman', 'pengajuan', 'sistem'])->default('sistem');
            
            // Konten notifikasi
            $table->string('title');
            $table->text('message');
            $table->string('link')->nullable();
            
            // Penerima notifikasi (support 3 role)
            $table->unsignedBigInteger('user_id')->nullable();
            $table->enum('role', ['superadmin', 'admin', 'driver'])->nullable();
            
            // Sumber notifikasi
            $table->unsignedBigInteger('source_id')->nullable();
            $table->string('source_type')->nullable();
            
            // Status
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            
            $table->timestamps();
            
            // Index untuk query cepat
            $table->index(['user_id', 'is_read']);
            $table->index(['role', 'is_read']);
            $table->index('created_at');
            $table->index(['user_id', 'role']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('notifications');
    }
};