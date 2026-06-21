<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // ==================== SUPERADMIN ====================
    public function superadminProfile()
    {
        $user = Auth::user();
        return view('superadmin.profile', compact('user'));
    }
    
    public function superadminUpdate(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'nama' => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        $user->nama = $request->nama;
        
        // Upload foto profile baru
        if ($request->hasFile('avatar')) {
            // Hapus foto lama jika ada
            if ($user->avatar && !str_contains($user->avatar, 'googleusercontent.com')) {
                if (Storage::disk('public')->exists($user->avatar)) {
                    Storage::disk('public')->delete($user->avatar);
                }
            }
            
            $file = $request->file('avatar');
            $filename = time() . '_' . $user->user_id . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('profile_photos', $filename, 'public');
            $user->avatar = $path;
        }
        
        $user->save();
        
        return back()->with('success', 'Profil berhasil diupdate!');
    }
    
    // Hapus foto profile
    public function superadminDeletePhoto()
    {
        $user = Auth::user();
        
        // Hapus file dari storage
        if ($user->avatar && !str_contains($user->avatar, 'googleusercontent.com')) {
            if (Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
        }
        
        // Kosongkan kolom avatar di database
        $user->avatar = null;
        $user->save();
        
        return back()->with('success', 'Foto profile berhasil dihapus!');
    }
    
    public function superadminChangePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);
        
        $user = Auth::user();
        
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Password saat ini salah!');
        }
        
        $user->password = Hash::make($request->new_password);
        $user->save();
        
        return back()->with('success', 'Password berhasil diubah!');
    }
    
    // ==================== ADMIN ====================
    public function adminProfile()
    {
        $user = Auth::user();
        return view('admin.profile', compact('user'));
    }
    
    public function adminUpdate(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'nama' => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        $user->nama = $request->nama;
        
        if ($request->hasFile('avatar')) {
            if ($user->avatar && !str_contains($user->avatar, 'googleusercontent.com')) {
                if (Storage::disk('public')->exists($user->avatar)) {
                    Storage::disk('public')->delete($user->avatar);
                }
            }
            
            $file = $request->file('avatar');
            $filename = time() . '_' . $user->user_id . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('profile_photos', $filename, 'public');
            $user->avatar = $path;
        }
        
        $user->save();
        
        return back()->with('success', 'Profil berhasil diupdate!');
    }
    
    public function adminDeletePhoto()
    {
        $user = Auth::user();
        
        if ($user->avatar && !str_contains($user->avatar, 'googleusercontent.com')) {
            if (Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
        }
        
        $user->avatar = null;
        $user->save();
        
        return back()->with('success', 'Foto profile berhasil dihapus!');
    }
    
    public function adminChangePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);
        
        $user = Auth::user();
        
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Password saat ini salah!');
        }
        
        $user->password = Hash::make($request->new_password);
        $user->save();
        
        return back()->with('success', 'Password berhasil diubah!');
    }
    
    // ==================== DRIVER ====================
    public function driverProfile()
    {
        $user = Auth::user();
        return view('driver.profile', compact('user'));
    }
    
    public function driverUpdate(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'nama' => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        $user->nama = $request->nama;
        
        if ($request->hasFile('avatar')) {
            if ($user->avatar && !str_contains($user->avatar, 'googleusercontent.com')) {
                if (Storage::disk('public')->exists($user->avatar)) {
                    Storage::disk('public')->delete($user->avatar);
                }
            }
            
            $file = $request->file('avatar');
            $filename = time() . '_' . $user->user_id . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('profile_photos', $filename, 'public');
            $user->avatar = $path;
        }
        
        $user->save();
        
        return back()->with('success', 'Profil berhasil diupdate!');
    }
    
    public function driverDeletePhoto()
    {
        $user = Auth::user();
        
        if ($user->avatar && !str_contains($user->avatar, 'googleusercontent.com')) {
            if (Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
        }
        
        $user->avatar = null;
        $user->save();
        
        return back()->with('success', 'Foto profile berhasil dihapus!');
    }
    
    public function driverChangePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);
        
        $user = Auth::user();
        
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Password saat ini salah!');
        }
        
        $user->password = Hash::make($request->new_password);
        $user->save();
        
        return back()->with('success', 'Password berhasil diubah!');
    }
}