<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    protected $table = 'pengajuans';
    protected $primaryKey = 'pengajuan_id';
    
    protected $fillable = [
        'driver_id', 'mobil_id', 'customer_id', 'status', 'disetujui_oleh',
        'tanggal_pengajuan', 'tanggal_disetujui', 'bukti_struk', 'keterangan'
    ];
    
    protected $casts = [
        'tanggal_pengajuan' => 'date',
        'tanggal_disetujui' => 'date',
    ];
    
    // Relasi ke Driver
    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id', 'driver_id');
    }
    
    // Relasi ke Mobil
    public function mobil()
    {
        return $this->belongsTo(Mobil::class, 'mobil_id', 'mobil_id');
    }
    
    // Relasi ke Pengiriman (nanti)
    public function pengiriman()
    {
        return $this->hasOne(Pengiriman::class, 'pengajuan_id', 'pengajuan_id');
    }
    
    // Helper status badge
    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'pending' => '<span class="badge badge-warning">Pending</span>',
            'disetujui' => '<span class="badge badge-success">Disetujui</span>',
            'ditolak' => '<span class="badge badge-danger">Ditolak</span>',
            default => '<span class="badge badge-secondary">Unknown</span>',
        };
    }
    // TAMBAHKAN RELASI INI
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'customer_id');
    }
}