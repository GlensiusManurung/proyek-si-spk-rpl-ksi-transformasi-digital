<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Chat;
use App\Helpers\NotificationHelper; // TAMBAHKAN INI
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ChatController extends Controller
{
    /* ── Halaman chat ──────────────────────────────────────── */
    public function index()
    {
        if (Auth::check()) {
            Auth::user()->update(['last_seen' => now()]);
        }

        $users = User::where('user_id', '!=', Auth::id())
                     ->whereIn('role', ['superadmin', 'admin', 'driver'])
                     ->orderBy('nama', 'asc')
                     ->get();

        $view = match (Auth::user()->role) {
            'superadmin' => 'chat.superadmin',
            'admin'      => 'chat.admin',
            default      => 'chat.driver',
        };

        return view($view, compact('users'));
    }

    /* ── Ambil pesan ───────────────────────────────────────── */
    public function getMessages(Request $request, int $userId)
    {
        if (Auth::check()) {
            Auth::user()->update(['last_seen' => now()]);
        }

        $query = Chat::where(function ($q) use ($userId) {
                        $q->where('sender_id', Auth::id())
                          ->where('receiver_id', $userId);
                    })
                    ->orWhere(function ($q) use ($userId) {
                        $q->where('sender_id', $userId)
                          ->where('receiver_id', Auth::id());
                    })
                    ->with(['sender', 'receiver'])
                    ->orderBy('created_at', 'asc');

        if ($request->has('after_id') && $request->after_id > 0) {
            $query->where('id', '>', $request->after_id);
        }

        $messages = $query->get();

        if (!$request->has('after_id')) {
            Chat::where('sender_id', $userId)
                ->where('receiver_id', Auth::id())
                ->where('is_read', false)
                ->update(['is_read' => true, 'read_at' => now()]);
        }

        $messages->each(function ($msg) {
            if ($msg->file_path) {
                $msg->file_url = Storage::url($msg->file_path);
                $msg->is_image = str_starts_with($msg->file_type ?? '', 'image/');
                $msg->is_video = str_starts_with($msg->file_type ?? '', 'video/');
            }
            $msg->created_at_formatted = $msg->created_at->format('H:i');
        });

        return response()->json($messages);
    }

    /* ── Kirim pesan ───────────────────────────────────────── */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,user_id',
            'message'     => 'nullable|string|max:5000',
            'file'        => 'nullable|file|max:51200',
        ]);

        if (!$request->filled('message') && !$request->hasFile('file')) {
            return response()->json(['success' => false, 'error' => 'Pesan atau file wajib diisi'], 422);
        }

        $data = [
            'sender_id'   => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message'     => $request->message ?? '',
            'is_read'     => false,
        ];

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $safeName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $file->getClientOriginalName());
            $path = $file->storeAs('chat_files', $safeName, 'public');

            $data['file_path'] = $path;
            $data['file_type'] = $file->getMimeType();
            $data['file_name'] = $file->getClientOriginalName();
            $data['file_size'] = $this->formatFileSize($file->getSize());
        }

        $chat = Chat::create($data);
        $chat->load(['sender', 'receiver']);

        if ($chat->file_path) {
            $chat->file_url = Storage::url($chat->file_path);
            $chat->is_image = str_starts_with($chat->file_type ?? '', 'image/');
            $chat->is_video = str_starts_with($chat->file_type ?? '', 'video/');
        }
        
        $chat->created_at_formatted = $chat->created_at->format('H:i');

        // ==================== KIRIM NOTIFIKASI CHAT ====================
        $this->sendChatNotification($chat);
        // ==============================================================

        return response()->json([
            'success' => true,
            'message' => $chat,
        ]);
    }

    /**
     * KIRIM NOTIFIKASI CHAT KE PENERIMA YANG SESUAI
     */
    /**
 * KIRIM NOTIFIKASI CHAT KE PENERIMA YANG SESUAI
 */
private function sendChatNotification($chat)
{
    $sender = $chat->sender;
    $receiver = $chat->receiver;
    $senderRole = $sender->role;
    $messageText = $chat->message ?: '[Mengirim file]';
    $shortMessage = strlen($messageText) > 50 ? substr($messageText, 0, 50) . '...' : $messageText;
    $chatId = $chat->id;
    
    \Illuminate\Support\Facades\Log::info('=== SEND CHAT NOTIFICATION ===');
    \Illuminate\Support\Facades\Log::info('Sender: ' . $sender->nama . ' (' . $senderRole . ')');
    \Illuminate\Support\Facades\Log::info('Receiver: ' . $receiver->nama . ' (' . $receiver->role . ')');
    \Illuminate\Support\Facades\Log::info('Receiver user_id: ' . $receiver->user_id);
    
    // KASUS 1: DRIVER ke ADMIN/SUPERADMIN
    if ($senderRole === 'driver' && in_array($receiver->role, ['admin', 'superadmin'])) {
        $result = NotificationHelper::sendToUser($receiver->user_id, [
            'type' => 'chat',
            'title' => '💬 Pesan dari Driver',
            'message' => "Driver {$sender->nama}: {$shortMessage}",
            'link' => "/chat?room={$chatId}",
        ]);
        \Illuminate\Support\Facades\Log::info('Notifikasi dikirim ke ' . $receiver->role . ' ID: ' . $receiver->user_id);
    }
    
    // KASUS 2: DRIVER ke DRIVER
    elseif ($senderRole === 'driver' && $receiver->role === 'driver') {
        $result = NotificationHelper::sendToUser($receiver->user_id, [
            'type' => 'chat',
            'title' => '💬 Pesan dari Driver',
            'message' => "Driver {$sender->nama}: {$shortMessage}",
            'link' => "/chat?room={$chatId}",
        ]);
        \Illuminate\Support\Facades\Log::info('Notifikasi dikirim ke driver lain ID: ' . $receiver->user_id);
    }
    
    // KASUS 3: ADMIN/SUPERADMIN ke DRIVER
    elseif (in_array($senderRole, ['admin', 'superadmin']) && $receiver->role === 'driver') {
        $result = NotificationHelper::sendToUser($receiver->user_id, [
            'type' => 'chat',
            'title' => '💬 Pesan dari ' . ucfirst($senderRole),
            'message' => ucfirst($senderRole) . " {$sender->nama}: {$shortMessage}",
            'link' => "/chat?room={$chatId}",
        ]);
        \Illuminate\Support\Facades\Log::info('Notifikasi dikirim ke driver ID: ' . $receiver->user_id);
    }
    
    // KASUS 4: ADMIN ke ADMIN (TAMBAHKAN!)
    elseif ($senderRole === 'admin' && $receiver->role === 'admin') {
        $result = NotificationHelper::sendToUser($receiver->user_id, [
            'type' => 'chat',
            'title' => '💬 Pesan dari Admin',
            'message' => "Admin {$sender->nama}: {$shortMessage}",
            'link' => "/chat?room={$chatId}",
        ]);
        \Illuminate\Support\Facades\Log::info('Notifikasi dikirim ke admin lain ID: ' . $receiver->user_id);
    }
    
    // KASUS 5: SUPERADMIN ke SUPERADMIN (TAMBAHKAN!)
    elseif ($senderRole === 'superadmin' && $receiver->role === 'superadmin') {
        $result = NotificationHelper::sendToUser($receiver->user_id, [
            'type' => 'chat',
            'title' => '💬 Pesan dari Superadmin',
            'message' => "Superadmin {$sender->nama}: {$shortMessage}",
            'link' => "/chat?room={$chatId}",
        ]);
        \Illuminate\Support\Facades\Log::info('Notifikasi dikirim ke superadmin lain ID: ' . $receiver->user_id);
    }
    
    // KASUS 6: ADMIN ke SUPERADMIN
    elseif ($senderRole === 'admin' && $receiver->role === 'superadmin') {
        $result = NotificationHelper::sendToUser($receiver->user_id, [
            'type' => 'chat',
            'title' => '💬 Pesan dari Admin',
            'message' => "Admin {$sender->nama}: {$shortMessage}",
            'link' => "/chat?room={$chatId}",
        ]);
        \Illuminate\Support\Facades\Log::info('Notifikasi dikirim ke superadmin ID: ' . $receiver->user_id);
    }
    
    // KASUS 7: SUPERADMIN ke ADMIN
    elseif ($senderRole === 'superadmin' && $receiver->role === 'admin') {
        $result = NotificationHelper::sendToUser($receiver->user_id, [
            'type' => 'chat',
            'title' => '💬 Pesan dari Superadmin',
            'message' => "Superadmin {$sender->nama}: {$shortMessage}",
            'link' => "/chat?room={$chatId}",
        ]);
        \Illuminate\Support\Facades\Log::info('Notifikasi dikirim ke admin ID: ' . $receiver->user_id);
    }
}

    /* ── Jumlah pesan belum dibaca ─────────────────────────── */
    public function getUnreadCount()
    {
        $count = Chat::where('receiver_id', Auth::id())
                     ->where('is_read', false)
                     ->count();

        return response()->json(['unread_count' => $count]);
    }

    /* ── Daftar user yang sedang online ────────────────────── */
    public function onlineUsers()
    {
        $onlineIds = User::where('is_online', true)
                         ->where('user_id', '!=', Auth::id())
                         ->pluck('user_id')
                         ->toArray();

        return response()->json([
            'online_ids' => $onlineIds,
            'current_time' => now()->toDateTimeString()
        ]);
    }

    /* ── Update status online ──────────────────────────────── */
    public function updateOnlineStatus()
    {
        if (Auth::check()) {
            Auth::user()->update(['is_online' => true]);
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }

    /* ── Helper format file size ───────────────────────────── */
    private function formatFileSize(int $bytes): string
    {
        if ($bytes >= 1073741824) return number_format($bytes / 1073741824, 2) . ' GB';
        if ($bytes >= 1048576) return number_format($bytes / 1048576, 2) . ' MB';
        if ($bytes >= 1024) return number_format($bytes / 1024, 2) . ' KB';
        return $bytes . ' bytes';
    }

    public function markAllAsRead(Request $request)
    {
        $request->validate(['sender_id' => 'required|exists:users,user_id']);
        
        Chat::where('sender_id', $request->sender_id)
            ->where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);
        
        return response()->json(['success' => true]);
    }
}