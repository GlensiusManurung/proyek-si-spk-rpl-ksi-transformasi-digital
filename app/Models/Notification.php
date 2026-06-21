<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Notification extends Model
{
    protected $table = 'notifications';
    
    protected $fillable = [
        'type', 'title', 'message', 'link',
        'user_id', 'role', 'source_id', 'source_type',
        'is_read', 'read_at'
    ];
    
    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];
    
    /**
     * Relasi ke user
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    /**
     * Tandai sebagai sudah dibaca
     */
    public function markAsRead()
    {
        $this->update([
            'is_read' => true,
            'read_at' => now()
        ]);
    }
    
    /**
     * KIRIM NOTIFIKASI KE USER TERTENTU
     */
    public static function sendToUser($userId, $data)
    {
        $data['user_id'] = $userId;
        $data['role'] = null;
        return self::create($data);
    }
    
    /**
     * KIRIM NOTIFIKASI KE SEMUA USER DENGAN ROLE TERTENTU
     */
    public static function sendToRole($role, $data)
    {
        $data['role'] = $role;
        $data['user_id'] = null;
        return self::create($data);
    }
    
    /**
     * KIRIM NOTIFIKASI KE SEMUA SUPERADMIN
     */
    public static function sendToSuperadmin($data)
    {
        return self::sendToRole('superadmin', $data);
    }
    
    /**
     * KIRIM NOTIFIKASI KE SEMUA ADMIN
     */
    public static function sendToAdmin($data)
    {
        return self::sendToRole('admin', $data);
    }
    
    /**
     * KIRIM NOTIFIKASI KE SEMUA DRIVER
     */
    public static function sendToAllDrivers($data)
    {
        return self::sendToRole('driver', $data);
    }
    
    /**
     * KIRIM NOTIFIKASI KE SEMUA ADMIN + SUPERADMIN
     */
    public static function sendToAllManagement($data)
    {
        self::sendToRole('superadmin', $data);
        self::sendToRole('admin', $data);
    }
    
    /**
     * KIRIM NOTIFIKASI KE DRIVER BERDASARKAN DRIVER_ID
     */
    public static function sendToDriverById($driverId, $data)
    {
        $driver = Driver::find($driverId);
        if ($driver && $driver->user_id) {
            $data['user_id'] = $driver->user_id;
            return self::create($data);
        }
        return null;
    }
    
    /**
     * AMBIL NOTIFIKASI UNTUK USER YANG SEDANG LOGIN (3 ROLE)
     */
    public static function getUserNotifications($userId, $userRole, $limit = 10)
    {
        $query = self::where(function($q) use ($userId, $userRole) {
            // Notifikasi khusus user ini
            $q->where('user_id', $userId);
            
            // Notifikasi untuk role user ini
            $q->orWhere('role', $userRole);
            
            // SUPERADMIN bisa lihat notifikasi untuk admin juga
            if ($userRole === 'superadmin') {
                $q->orWhere('role', 'admin');
            }
            
            // ADMIN bisa lihat notifikasi untuk superadmin? TIDAK, hanya superadmin yang bisa lihat semua
        });
        
        return $query->orderBy('created_at', 'desc')
                     ->limit($limit)
                     ->get();
    }
    
    /**
     * HITUNG NOTIFIKASI BELUM DIBACA (3 ROLE)
     */
    public static function countUnread($userId, $userRole)
    {
        $query = self::where(function($q) use ($userId, $userRole) {
            $q->where('user_id', $userId)
              ->orWhere('role', $userRole);
              
            if ($userRole === 'superadmin') {
                $q->orWhere('role', 'admin');
            }
        })
        ->where('is_read', false);
        
        return $query->count();
    }
    
    /**
     * AMBIL SEMUA NOTIFIKASI DENGAN PAGINATION (3 ROLE)
     */
    public static function getAllNotifications($userId, $userRole, $page = 1, $limit = 20)
    {
        $offset = ($page - 1) * $limit;
        
        $query = self::where(function($q) use ($userId, $userRole) {
            $q->where('user_id', $userId)
              ->orWhere('role', $userRole);
              
            if ($userRole === 'superadmin') {
                $q->orWhere('role', 'admin');
            }
        });
        
        $total = $query->count();
        $notifications = $query->orderBy('created_at', 'desc')
                              ->skip($offset)
                              ->take($limit + 1)
                              ->get();
        
        $hasMore = $notifications->count() > $limit;
        if ($hasMore) {
            $notifications = $notifications->slice(0, $limit);
        }
        
        return [
            'notifications' => $notifications,
            'has_more' => $hasMore,
            'total' => $total,
            'current_page' => $page
        ];
    }
}