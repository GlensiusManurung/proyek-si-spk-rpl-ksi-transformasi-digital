<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;

class ForgotPasswordController extends Controller
{
    // Tampilkan form lupa password
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }
    
    // Kirim link reset password dengan rate limiting
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], [
            'email.exists' => 'Email tidak terdaftar di sistem kami.'
        ]);
        
        $email = $request->email;
        $ip = $request->ip();
        
        // Rate limiting berdasarkan IP (3x dalam 15 menit)
        $ipKey = 'reset_password_ip_' . $ip;
        $ipAttempts = Cache::get($ipKey, 0);
        
        if ($ipAttempts >= 3) {
            return back()->with('error', 'Terlalu banyak permintaan. Silakan coba lagi setelah 15 menit.');
        }
        
        // Rate limiting berdasarkan Email (2x dalam 1 jam)
        $emailKey = 'reset_password_email_' . $email;
        $emailAttempts = Cache::get($emailKey, 0);
        
        if ($emailAttempts >= 2) {
            return back()->with('error', 'Terlalu banyak permintaan untuk email ini. Silakan coba lagi setelah 1 jam.');
        }
        
        // Increment attempt counters
        Cache::put($ipKey, $ipAttempts + 1, now()->addMinutes(15));
        Cache::put($emailKey, $emailAttempts + 1, now()->addMinutes(60));
        
        // Generate token unik
        $token = Str::random(64);
        
        // Hapus token lama untuk email ini
        DB::table('password_resets')->where('email', $email)->delete();
        
        // Simpan token baru
        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $token,
            'ip_address' => $ip,
            'user_agent' => $request->userAgent(),
            'expires_at' => now()->addSeconds(60),
            'is_used' => false,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        // Buat link reset
        $resetLink = route('password.reset.form', ['token' => $token]);
        
        // Kirim email
        $this->sendResetEmail($email, $resetLink, $token);
        
        return back()->with('success', 'Link reset password telah dikirim ke email Anda. Link berlaku 60 detik.');
    }
    
    // Tampilkan form reset password
    public function showResetForm($token)
    {
        // Cek token valid
        $resetRecord = DB::table('password_resets')
            ->where('token', $token)
            ->where('is_used', false)
            ->where('expires_at', '>', now())
            ->first();
        
        if (!$resetRecord) {
            return redirect()->route('password.request')
                ->with('error', 'Link reset password tidak valid atau sudah kadaluarsa.');
        }
        
        // Ambil data user berdasarkan email
        $user = User::where('email', $resetRecord->email)->first();
        $nama = $user ? $user->nama : 'User';
        
        return view('auth.reset-password', [
            'token' => $token, 
            'email' => $resetRecord->email,
            'nama' => $nama
        ]);
    }
    
    // Proses reset password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
            'token' => 'required'
        ]);
        
        // Cek token valid
        $resetRecord = DB::table('password_resets')
            ->where('token', $request->token)
            ->where('email', $request->email)
            ->where('is_used', false)
            ->where('expires_at', '>', now())
            ->first();
        
        if (!$resetRecord) {
            return back()->with('error', 'Link reset password tidak valid atau sudah kadaluarsa.');
        }
        
        // Cek IP dan Browser (keamanan tambahan)
        if ($resetRecord->ip_address !== $request->ip()) {
            return back()->with('error', 'Link reset password tidak dapat digunakan dari perangkat berbeda.');
        }
        
        if ($resetRecord->user_agent !== $request->userAgent()) {
            return back()->with('error', 'Link reset password tidak dapat digunakan dari browser berbeda.');
        }
        
        // Update password user
        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();
        
        // Tandai token sudah digunakan
        DB::table('password_resets')
            ->where('token', $request->token)
            ->update(['is_used' => true]);
        
        // Hapus cache rate limiting untuk email ini
        Cache::forget('reset_password_email_' . $request->email);
        
        return redirect()->route('login')->with('success', 'Password berhasil direset! Silakan login dengan password baru.');
    }
    
    // Kirim email reset password
    private function sendResetEmail($email, $resetLink, $token)
    {
        // Ambil data user
        $user = User::where('email', $email)->first();
        $userName = $user ? $user->nama : 'User';
        
        // Konversi logo ke base64
        $logoPath = public_path('img/OPR-optiroute.png');
        $logoBase64 = '';
        
        if (file_exists($logoPath)) {
            $logoData = base64_encode(file_get_contents($logoPath));
            $logoBase64 = 'data:image/png;base64,' . $logoData;
        }
        
        $data = [
            'name' => $userName,
            'email' => $email,
            'reset_link' => $resetLink,
            'token' => $token,
            'expires_in' => '60 detik',
            'logo_base64' => $logoBase64
        ];
        
        Mail::send('emails.reset-password', $data, function ($message) use ($email) {
            $message->to($email)
                    ->subject('Reset Password - OPR Optiroute');
        });
    }
}