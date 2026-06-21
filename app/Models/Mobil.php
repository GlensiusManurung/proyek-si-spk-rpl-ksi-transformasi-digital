<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mobil extends Model
{
    protected $table = 'mobils';
    protected $primaryKey = 'mobil_id';
    
    protected $fillable = [
        'no_plat', 'merk', 'jenis_mobil', 'pajak_stnk', 'pajak_plat', 
        'kir', 'status', 'keterangan'
    ];
    
    protected $casts = [
        'pajak_stnk' => 'date',
        'pajak_plat' => 'date',
        'kir' => 'date',
    ];
    
    // TAMBAHKAN RELASI INI
    public function pengajuans()
    {
        return $this->hasMany(Pengajuan::class, 'mobil_id', 'mobil_id');
    }
    
    // Relasi ke Pengiriman (via pengajuan)
    public function pengirimans()
    {
        return $this->hasManyThrough(Pengiriman::class, Pengajuan::class, 'mobil_id', 'pengajuan_id', 'mobil_id', 'pengajuan_id');
    }
}