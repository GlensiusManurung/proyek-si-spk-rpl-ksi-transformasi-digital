<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kriterias', function (Blueprint $table) {
            // Ubah ke string (varchar) biar fleksibel
            $table->string('bobot', 20)->change();
        });
    }

    public function down(): void
    {
        Schema::table('kriterias', function (Blueprint $table) {
            $table->decimal('bobot', 5, 2)->change();
        });
    }
};