<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        try {
            return Socialite::driver('google')->redirect();
        } catch (\Exception $e) {
            return redirect()->route('daftar')->with('error', 'Gagal terhubung ke Google: ' . $e->getMessage());
        }
    }
    
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            // Cek apakah superadmin sudah ada
            $superadminExists = User::where('role', 'superadmin')->exists();
            
            if ($superadminExists) {
                return redirect()->route('login')->with('error', 'Pendaftaran ditutup! Akun Superadmin sudah ada.');
            }
            
            // Cek apakah email sudah terdaftar
            $existingUser = User::where('email', $googleUser->getEmail())->first();
            
            if ($existingUser) {
                Auth::login($existingUser);
                return redirect()->route('superadmin.dashboard')->with('success', 'Selamat datang kembali!');
            }
            
            // Generate random password (8 karakter)
            $randomPassword = Str::random(8);
            
            // Ambil nama dari Google
            $googleName = $googleUser->getName();
            
            // Buat akun superadmin baru
            $user = User::create([
                'nama' => $googleName,
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
                'role' => 'superadmin',
                'is_superadmin_fixed' => true,
                'password' => Hash::make($randomPassword)
            ]);
            
            // Kirim email berisi NAMA dan PASSWORD (email gausah dikirim, udah jelas)
            $this->sendPasswordEmail($user, $randomPassword);
            
            Auth::login($user);
            return redirect()->route('superadmin.dashboard')->with('success', 'Akun Superadmin berhasil dibuat! Password telah dikirim ke email Anda.');
            
        } catch (\Exception $e) {
            return redirect()->route('daftar')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    private function sendPasswordEmail($user, $password)
    {
        $data = [
            'nama' => $user->nama,
            'password' => $password,
            'login_url' => route('login')
        ];
        
        Mail::send('emails.password-email', $data, function ($message) use ($user) {
            $message->to($user->email, $user->nama)
                    ->subject('Akun Superadmin - Password Anda');
        });
    }
}