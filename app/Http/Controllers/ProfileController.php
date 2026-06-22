<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Cloudinary\Cloudinary;
use Cloudinary\Configuration\Configuration;

class ProfileController extends Controller
{
    // ==================== HELPER ====================
    private function uploadAvatar($request, $user)
    {
        if ($request->hasFile('avatar')) {
            $cloudinary = new Cloudinary(
                Configuration::instance([
                    'cloud' => [
                        'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                        'api_key'    => env('CLOUDINARY_API_KEY'),
                        'api_secret' => env('CLOUDINARY_API_SECRET'),
                    ],
                    'url' => ['secure' => true]
                ])
            );

            $result = $cloudinary->uploadApi()->upload(
                $request->file('avatar')->getRealPath(),
                ['folder' => 'profile_photos']
            );

            $user->avatar = $result['secure_url'];
        }

        return $user;
    }

    private function deleteAvatar($user)
    {
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