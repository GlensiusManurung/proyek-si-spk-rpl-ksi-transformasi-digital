<?php
// app/Models/BuktiPengiriman.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class BuktiPengiriman extends Model
{
    protected $table = 'bukti_pengirimans';
    protected $primaryKey = 'bukti_pengiriman_id';
    
    protected $fillable = [
        'pengiriman_id', 'tanggal_bukti', 'gambar', 'deskripsi', 'uploaded_by'
    ];
    
    protected $casts = [
        'tanggal_bukti' => 'date',
    ];
    
    // Relasi ke Pengiriman (belongs to)
    public function pengiriman()
    {
        return $this->belongsTo(Pengiriman::class, 'pengiriman_id', 'pengiriman_id');
    }
    
    // Akses Driver dari Pengiriman
    public function getDriverAttribute()
    {
        return $this->pengiriman->pengajuan->driver ?? null;
    }
    
    // URL gambar
    public function getGambarUrlAttribute()
    {
        return $this->gambar ? Storage::url($this->gambar) : null;
    }
}