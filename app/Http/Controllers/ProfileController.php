<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ProfileController extends Controller
{
    // ==================== HELPER ====================
    private function uploadAvatar($request, $user)
    {
        if ($request->hasFile('avatar')) {
            if ($user->avatar && !str_contains($user->avatar, 'googleusercontent.com') && str_contains($user->avatar, 'cloudinary')) {
                $publicId = 'profile_photos/' . pathinfo(parse_url($user->avatar, PHP_URL_PATH), PATHINFO_FILENAME);
                Cloudinary::destroy($publicId);
            }

            $result = Cloudinary::upload($request->file('avatar')->getRealPath(), [
                'folder' => 'profile_photos',
            ]);

            $user->avatar = $result->getSecurePath();
        }

        return $user;
    }

    private function deleteAvatar($user)
    {
        if ($user->avatar && !str_contains($user->avatar, 'googleusercontent.com')) {
            if (str_contains($user->avatar, 'cloudinary')) {
                $publicId = 'profile_photos/' . pathinfo(parse_url($user->avatar, PHP_URL_PATH), PATHINFO_FILENAME);
                Cloudinary::destroy($publicId);
            }
        }

        $user->avatar = null;
        $user->save();

        return back()->with('success', 'Foto profile berhasil dihapus!');
    }

    private function changePassword($request)
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

    // ==================== SUPERADMIN ====================
    public function superadminProfile()
    {
        return view('superadmin.profile', ['user' => Auth::user()]);
    }

    public function superadminUpdate(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'nama' => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        $user->nama = $request->nama;
        $user = $this->uploadAvatar($request, $user);
        $user->save();
        return back()->with('success', 'Profil berhasil diupdate!');
    }

    public function superadminDeletePhoto()
    {
        return $this->deleteAvatar(Auth::user());
    }

    public function superadminChangePassword(Request $request)
    {
        return $this->changePassword($request);
    }

    // ==================== ADMIN ====================
    public function adminProfile()
    {
        return view('admin.profile', ['user' => Auth::user()]);
    }

    public function adminUpdate(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'nama' => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        $user->nama = $request->nama;
        $user = $this->uploadAvatar($request, $user);
        $user->save();
        return back()->with('success', 'Profil berhasil diupdate!');
    }

    public function adminDeletePhoto()
    {
        return $this->deleteAvatar(Auth::user());
    }

    public function adminChangePassword(Request $request)
    {
        return $this->changePassword($request);
    }

    // ==================== DRIVER ====================
    public function driverProfile()
    {
        return view('driver.profile', ['user' => Auth::user()]);
    }

    public function driverUpdate(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'nama' => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        $user->nama = $request->nama;
        $user = $this->uploadAvatar($request, $user);
        $user->save();
        return back()->with('success', 'Profil berhasil diupdate!');
    }

    public function driverDeletePhoto()
    {
        return $this->deleteAvatar(Auth::user());
    }

    public function driverChangePassword(Request $request)
    {
        return $this->changePassword($request);
    }
}