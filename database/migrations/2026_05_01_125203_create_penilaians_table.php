<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penilaians', function (Blueprint $table) {
            $table->id('penilaian_id');
            $table->foreignId('driver_id')->constrained('drivers', 'driver_id')->onDelete('cascade');
            $table->foreignId('kriteria_id')->constrained('kriterias', 'kriteria_id')->onDelete('cascade');
            $table->integer('nilai')->default(0);
            $table->timestamps();
            
            $table->unique(['driver_id', 'kriteria_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penilaians');
    }
};