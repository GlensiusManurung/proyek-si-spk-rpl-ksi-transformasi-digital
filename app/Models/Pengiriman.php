<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengiriman extends Model
{
    protected $table = 'pengirimans';
    protected $primaryKey = 'pengiriman_id';
    
    protected $fillable = [
        'pengajuan_id', 'nomor_surat_jalan', 'status', 
        'tanggal_pengiriman', 'deskripsi', 'gambar', 'catatan'
    ];
    
    protected $casts = [
        'tanggal_pengiriman' => 'date',
    ];
    
    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class, 'pengajuan_id', 'pengajuan_id');
    }
    
    public function bukti()
    {
        return $this->hasOne(BuktiPengiriman::class, 'pengiriman_id', 'pengiriman_id');
    }
    
    public function getDriverAttribute()
    {
        return $this->pengajuan->driver ?? null;
    }
    
    public function getMobilAttribute()
    {
        return $this->pengajuan->mobil ?? null;
    }
    
    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'proses' => '<span class="badge badge-warning">Proses</span>',
            'dikirim' => '<span class="badge badge-info">Dikirim</span>',
            'selesai' => '<span class="badge badge-success">Selesai</span>',
            default => '<span class="badge badge-secondary">Unknown</span>',
        };
    }
    
    // Generate nomor surat jalan otomatis (UNIK per BULAN)
    public static function generateNomorSuratJalan()
    {
        $year = date('Y');
        $month = date('m');
        $prefix = 'SJ/' . $year . '/' . $month . '/';
        
        // Ambil nomor urut terbesar untuk bulan ini
        $last = self::where('nomor_surat_jalan', 'LIKE', $prefix . '%')
                    ->orderBy('nomor_surat_jalan', 'desc')
                    ->first();
        
        if ($last) {
            $lastNumber = (int) substr($last->nomor_surat_jalan, -4);
            $noUrut = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $noUrut = '0001';
        }
        
        return $prefix . $noUrut;
    }
}