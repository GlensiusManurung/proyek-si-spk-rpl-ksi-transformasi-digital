<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';
    protected $primaryKey = 'customer_id';
    
    protected $fillable = [
        'nama_perusahaan', 
        'alamat', 
        'nomor_kontak', 
        'email', 
        'pic', 
        'keterangan'  // ← sesuai migration lo
    ];
    
    // Relasi ke Pengajuan (karena pengajuan punya customer_id)
    public function pengajuans()
    {
        return $this->hasMany(Pengajuan::class, 'customer_id', 'customer_id');
    }
    
    // Relasi ke Pengiriman (via pengajuan, bukan langsung)
    // Ini tidak perlu karena pengiriman -> pengajuan -> customer
    // Tapi boleh disimpan untuk akses cepat
    public function pengirimans()
    {
        return $this->hasManyThrough(
            Pengiriman::class,
            Pengajuan::class,
            'customer_id',  // foreign key di pengajuans
            'pengajuan_id', // foreign key di pengirimans
            'customer_id',  // local key di customers
            'pengajuan_id'  // local key di pengajuans
        );
    }
}