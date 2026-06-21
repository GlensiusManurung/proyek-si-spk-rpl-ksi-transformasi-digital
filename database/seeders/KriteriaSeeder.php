<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kriteria;
use App\Models\Penilaian;
use Illuminate\Support\Facades\DB;

class KriteriaSeeder extends Seeder
{
    public function run(): void
    {
        // Nonaktifkan foreign key check
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
        // Hapus data pake DELETE, bukan TRUNCATE
        Penilaian::query()->delete();
        Kriteria::query()->delete();
        
        // Insert data kriteria (HANYA SEEDING AWAL)
        $kriterias = [
            ['kode_kriteria' => 'C1', 'nama_kriteria' => 'Jumlah Pengiriman Selesai', 'jenis' => 'benefit', 'bobot' => 35],
            ['kode_kriteria' => 'C2', 'nama_kriteria' => 'Kecepatan Upload Bukti', 'jenis' => 'benefit', 'bobot' => 25],
            ['kode_kriteria' => 'C3', 'nama_kriteria' => 'Pengiriman Tertunda', 'jenis' => 'cost', 'bobot' => 20],
            ['kode_kriteria' => 'C4', 'nama_kriteria' => 'Rating Driver', 'jenis' => 'benefit', 'bobot' => 20],
        ];
        
        foreach ($kriterias as $k) {
            Kriteria::create($k);
        }
        
        // Aktifkan kembali foreign key check
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        
        $this->command->info('Kriteria berhasil di-seed!');
    }
}