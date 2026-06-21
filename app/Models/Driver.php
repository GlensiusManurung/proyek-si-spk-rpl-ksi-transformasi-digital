<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $table = 'drivers';
    protected $primaryKey = 'driver_id';
    
    protected $fillable = [
        'user_id', 'nama', 'no_sim', 'nik', 'no_rek', 
        'nomor_kontak', 'alamat', 'status'
    ];
    
    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
    
    // Relasi ke Pengajuan
    public function pengajuans()
    {
        return $this->hasMany(Pengajuan::class, 'driver_id', 'driver_id');
    }
    
     // Relasi ke Pengiriman (via pengajuan)
    public function pengirimans()
    {
        return $this->hasManyThrough(Pengiriman::class, Pengajuan::class, 'driver_id', 'pengajuan_id', 'driver_id', 'pengajuan_id');
    }
    // Helper status badge
    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'aktif' => '<span class="badge badge-success">Aktif</span>',
            'nonaktif' => '<span class="badge badge-danger">Nonaktif</span>',
            default => '<span class="badge badge-secondary">Unknown</span>',
        };
    }
}