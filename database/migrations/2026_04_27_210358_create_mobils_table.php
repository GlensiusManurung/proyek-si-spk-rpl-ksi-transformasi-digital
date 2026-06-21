<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mobils', function (Blueprint $table) {
            $table->id('mobil_id');
            $table->string('no_plat', 20)->unique();

            $table->string('merk')->nullable();
            $table->string('jenis_mobil', 100);

            $table->date('pajak_stnk')->nullable();
            $table->date('pajak_plat')->nullable();
            $table->date('kir')->nullable();

            $table->enum('status', ['aktif', 'perbaikan', 'nonaktif'])
                  ->default('aktif');

            $table->text('keterangan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mobils');
    }
};