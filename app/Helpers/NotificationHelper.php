<?php

namespace App\Helpers;

use App\Models\Notification;
use App\Models\Driver;
use App\Models\User;

class NotificationHelper
{
    // ==================== NOTIFIKASI KE SUPERADMIN ====================
    public static function toSuperadmin($title, $message, $link = null, $type = 'sistem')
    {
        return Notification::sendToSuperadmin([
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'link' => $link,
        ]);
    }
    
    // ==================== NOTIFIKASI KE ADMIN ====================
    public static function toAdmin($title, $message, $link = null, $type = 'sistem')
    {
        return Notification::sendToAdmin([
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'link' => $link,
        ]);
    }
    
    // ==================== NOTIFIKASI KE SEMUA MANAGEMENT (SUPERADMIN + ADMIN) ====================
    public static function toAllManagement($title, $message, $link = null, $type = 'sistem')
    {
        return Notification::sendToAllManagement([
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'link' => $link,
        ]);
    }
    
    // ==================== NOTIFIKASI KE SEMUA DRIVER ====================
    public static function toAllDrivers($title, $message, $link = null, $type = 'sistem')
    {
        return Notification::sendToAllDrivers([
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'link' => $link,
        ]);
    }
    
    // ==================== NOTIFIKASI KE DRIVER TERTENTU ====================
    public static function toDriver($driverId, $title, $message, $link = null, $type = 'sistem')
    {
        return Notification::sendToDriverById($driverId, [
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'link' => $link,
        ]);
    }
    
    // ==================== NOTIFIKASI CHAT ====================
    
    /**
     * Chat ke superadmin (dari driver atau customer)
     */
    public static function chatToSuperadmin($senderName, $message, $chatId)
    {
        $shortMsg = strlen($message) > 50 ? substr($message, 0, 50) . '...' : $message;
        return self::toSuperadmin(
            '💬 Pesan Baru',
            "{$senderName}: {$shortMsg}",
            "/chat?room={$chatId}",
            'chat'
        );
    }
    
    /**
     * Chat ke admin (dari driver atau customer)
     */
    public static function chatToAdmin($senderName, $message, $chatId)
    {
        $shortMsg = strlen($message) > 50 ? substr($message, 0, 50) . '...' : $message;
        return self::toAdmin(
            '💬 Pesan Baru',
            "{$senderName}: {$shortMsg}",
            "/chat?room={$chatId}",
            'chat'
        );
    }
    
    /**
     * Chat ke semua management
     */
    public static function chatToAllManagement($senderName, $message, $chatId)
    {
        $shortMsg = strlen($message) > 50 ? substr($message, 0, 50) . '...' : $message;
        return self::toAllManagement(
            '💬 Pesan Baru',
            "{$senderName}: {$shortMsg}",
            "/chat?room={$chatId}",
            'chat'
        );
    }
    
    /**
     * Chat ke driver (dari admin/superadmin)
     */
    public static function chatToDriver($driverId, $adminName, $message, $chatId)
    {
        $shortMsg = strlen($message) > 50 ? substr($message, 0, 50) . '...' : $message;
        return self::toDriver(
            $driverId,
            '💬 Pesan dari Admin',
            "Admin {$adminName}: {$shortMsg}",
            "/chat?room={$chatId}",
            'chat'
        );
    }
    
    // ==================== NOTIFIKASI PENGIRIMAN ====================
    
    /**
     * Pengiriman update ke superadmin
     */
    public static function pengirimanToSuperadmin($driverName, $status, $nomorSuratJalan, $pengirimanId)
    {
        $statusText = ['proses' => 'memulai', 'dikirim' => 'sedang mengirim', 'selesai' => 'menyelesaikan'];
        $action = $statusText[$status] ?? $status;
        
        return self::toSuperadmin(
            '🚚 Update Pengiriman',
            "Driver {$driverName} {$action} pengiriman ({$nomorSuratJalan})",
            "/admin/pengirimans/{$pengirimanId}",
            'pengiriman'
        );
    }
    
    /**
     * Pengiriman update ke semua management
     */
    public static function pengirimanToManagement($driverName, $status, $nomorSuratJalan, $pengirimanId)
    {
        $statusText = ['proses' => 'memulai', 'dikirim' => 'sedang mengirim', 'selesai' => 'menyelesaikan'];
        $action = $statusText[$status] ?? $status;
        
        return self::toAllManagement(
            '🚚 Update Pengiriman',
            "Driver {$driverName} {$action} pengiriman ({$nomorSuratJalan})",
            "/admin/pengirimans/{$pengirimanId}",
            'pengiriman'
        );
    }
    
    /**
     * Pengiriman update ke driver (pengirimannya sendiri)
     */
    public static function pengirimanToDriver($driverId, $status, $nomorSuratJalan)
    {
        $statusText = ['proses' => 'telah dimulai', 'dikirim' => 'sedang dalam perjalanan', 'selesai' => 'telah selesai'];
        
        return self::toDriver(
            $driverId,
            '🚚 Status Pengiriman',
            "Pengiriman {$nomorSuratJalan} {$statusText[$status]}",
            "/driver/pengirimans",
            'pengiriman'
        );
    }
    
    // ==================== NOTIFIKASI PENGAJUAN ====================
    
    /**
     * Pengajuan ke superadmin
     */
    public static function pengajuanToSuperadmin($customerName, $status, $pengajuanId)
    {
        $statusText = ['pending' => 'mengajukan', 'disetujui' => 'menyetujui', 'ditolak' => 'menolak'];
        
        return self::toSuperadmin(
            '📄 Pengajuan Driver',
            "Customer {$customerName} {$statusText[$status]} pengajuan driver",
            "/admin/pengajuans/{$pengajuanId}",
            'pengajuan'
        );
    }
    
    /**
     * Pengajuan ke semua management
     */
    public static function pengajuanToManagement($customerName, $status, $pengajuanId)
    {
        $statusText = ['pending' => 'mengajukan', 'disetujui' => 'menyetujui', 'ditolak' => 'menolak'];
        
        return self::toAllManagement(
            '📄 Pengajuan Driver',
            "Customer {$customerName} {$statusText[$status]} pengajuan driver",
            "/admin/pengajuans/{$pengajuanId}",
            'pengajuan'
        );
    }
    
    /**
     * Hasil pengajuan ke driver
     */
    public static function pengajuanResultToDriver($driverId, $customerName, $status, $pengajuanId)
    {
        $statusText = ['disetujui' => 'disetujui ✅', 'ditolak' => 'ditolak ❌'];
        
        if (isset($statusText[$status])) {
            return self::toDriver(
                $driverId,
                '📄 Status Pengajuan',
                "Pengajuan dari customer {$customerName} telah {$statusText[$status]}",
                "/driver/pengajuans/{$pengajuanId}",
                'pengajuan'
            );
        }
        return null;
    }

// ==================== NOTIFIKASI KE USER TERTENTU ====================
/**
 * Kirim notifikasi langsung ke user berdasarkan user_id
 */
public static function sendToUser($userId, $data)
{
    return Notification::create([
        'user_id' => $userId,
        'type' => $data['type'] ?? 'sistem',
        'title' => $data['title'],
        'message' => $data['message'],
        'link' => $data['link'] ?? null,
        'is_read' => false,
    ]);
}



// ==================== NOTIFIKASI KE ROLE TERTENTU ====================
/**
 * Kirim notifikasi ke semua user dengan role tertentu
 */
public static function sendToRole($role, $data)
{
    return Notification::create([
        'role' => $role,
        'type' => $data['type'] ?? 'sistem',
        'title' => $data['title'],
        'message' => $data['message'],
        'link' => $data['link'] ?? null,
        'is_read' => false,
    ]);
}


}