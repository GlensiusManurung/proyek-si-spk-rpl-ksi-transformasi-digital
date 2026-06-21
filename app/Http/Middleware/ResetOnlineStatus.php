<?php
// app/Http/Middleware/ResetOnlineStatus.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ResetOnlineStatus
{
    public function handle(Request $request, Closure $next)
    {
        // Reset semua user yang sudah tidak aktif > 30 menit
        User::where('is_online', true)
            ->where('updated_at', '<', now()->subMinutes(30))
            ->update(['is_online' => false]);
        
        // Set user yang sedang login jadi online
        if (Auth::check()) {
            $user = Auth::user();
            $user->is_online = true;
            $user->updated_at = now();
            $user->save();
        }
        
        return $next($request);
    }
}