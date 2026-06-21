<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function index()
    {
        // Cek apakah superadmin sudah ada
        $superadminExists = User::where('role', 'superadmin')->exists();
        
        return view('halamanlogin.daftarakun', compact('superadminExists'));
    }

    public function store(Request $request)
    {
        // Cek apakah superadmin sudah ada
        $superadminExists = User::where('role', 'superadmin')->exists();
        
        if ($superadminExists) {
            return redirect()->back()->with('error', 'Pendaftaran ditutup! Hanya Superadmin yang dapat membuat akun. Silakan hubungi Superadmin.');
        }
        
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);

        // Buat akun SUPERADMIN
        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'superadmin',
            'is_superadmin_fixed' => true
        ]);

        // Langsung login setelah daftar
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->route('superadmin.dashboard')->with('success', 'Akun Superadmin berhasil dibuat!');
        }

        return redirect('/login')->with('success', 'Akun Superadmin berhasil dibuat! Silakan login.');
    }
}