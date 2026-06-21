<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Get notifications for dropdown (API) - Support 3 Role
     */
    public function index(Request $request)
    {
        $userId = Auth::id();
        $userRole = Auth::user()->role;
        
        $notifications = Notification::getUserNotifications($userId, $userRole, 10);
        $unreadCount = Notification::countUnread($userId, $userRole);
        
        return response()->json([
            'success' => true,
            'notifications' => $notifications,
            'unread_count' => $unreadCount,
            'user_role' => $userRole
        ]);
    }
    
    /**
     * Get all notifications with pagination (API) - Support 3 Role
     */
    public function all(Request $request)
    {
        $page = $request->get('page', 1);
        $limit = $request->get('limit', 20);
        
        $userId = Auth::id();
        $userRole = Auth::user()->role;
        
        $result = Notification::getAllNotifications($userId, $userRole, $page, $limit);
        
        return response()->json([
            'success' => true,
            'notifications' => $result['notifications'],
            'has_more' => $result['has_more'],
            'total' => $result['total'],
            'current_page' => $result['current_page'],
            'user_role' => $userRole
        ]);
    }
    
    /**
     * Check for new notifications (API) - Support 3 Role
     */
    public function newNotifications(Request $request)
    {
        $since = $request->get('since', now()->subDay());
        $userId = Auth::id();
        $userRole = Auth::user()->role;
        
        $notifications = Notification::where(function($q) use ($userId, $userRole) {
                $q->where('user_id', $userId)
                  ->orWhere('role', $userRole);
                  
                if ($userRole === 'superadmin') {
                    $q->orWhere('role', 'admin');
                }
            })
            ->where('created_at', '>', $since)
            ->orderBy('created_at', 'desc')
            ->get();
        
        return response()->json([
            'success' => true,
            'notifications' => $notifications,
            'count' => $notifications->count()
        ]);
    }
    
    /**
     * Mark notification as read (API)
     */
    public function markAsRead($id)
    {
        $userId = Auth::id();
        $userRole = Auth::user()->role;
        
        $notification = Notification::where(function($q) use ($userId, $userRole) {
                $q->where('user_id', $userId)
                  ->orWhere('role', $userRole);
                  
                if ($userRole === 'superadmin') {
                    $q->orWhere('role', 'admin');
                }
            })
            ->where('id', $id)
            ->first();
        
        if ($notification) {
            $notification->markAsRead();
            return response()->json(['success' => true]);
        }
        
        return response()->json(['success' => false, 'message' => 'Notifikasi tidak ditemukan'], 404);
    }
    
    /**
     * Mark all notifications as read (API)
     */
    public function markAllRead()
    {
        $userId = Auth::id();
        $userRole = Auth::user()->role;
        
        Notification::where(function($q) use ($userId, $userRole) {
                $q->where('user_id', $userId)
                  ->orWhere('role', $userRole);
                  
                if ($userRole === 'superadmin') {
                    $q->orWhere('role', 'admin');
                }
            })
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now()
            ]);
        
        return response()->json(['success' => true]);
    }
    
    /**
     * Halaman semua notifikasi (Web) - Support 3 Role
     */
    public function indexPage()
    {
        $userRole = Auth::user()->role;
        
        // Redirect berdasarkan role
        if ($userRole === 'driver') {
            return view('driver.notifikasi.index');
        }
        
        return view('admin.notifikasi.index');
    }


public function destroy(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:notifications,id'
        ]);
        
        $userId = Auth::id();
        
        // Pastikan notifikasi milik user yang sedang login
        $deleted = Notification::where('user_id', $userId)
            ->whereIn('id', $request->ids)
            ->forceDelete(); // forceDelete untuk hard delete
        
        return response()->json([
            'success' => true,
            'deleted_count' => $deleted,
            'message' => $deleted . ' notifikasi berhasil dihapus permanen'
        ]);
    }
    
    /**
     * Hapus SEMUA notifikasi (hard delete) untuk user yang login
     */
    public function destroyAll()
    {
        $userId = Auth::id();
        
        $deleted = Notification::where('user_id', $userId)
            ->forceDelete(); // hard delete semua
        
        return response()->json([
            'success' => true,
            'deleted_count' => $deleted,
            'message' => 'Semua notifikasi berhasil dihapus permanen'
        ]);
    }
}

