<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminController extends Controller
{
    public function index()
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }
        
        // Cek apakah role-nya superadmin
        if (Auth::user()->role !== 'superadmin') {
            return redirect()->route('login')->with('error', 'Anda tidak memiliki akses');
        }
        
        // Data untuk dashboard
        $totalUsers = User::count();
        $totalDrivers = User::where('role', 'driver')->count();
        $totalAdmins = User::where('role', 'admin')->count();
        $totalCustomers = 0; // Sesuaikan dengan model Customer nanti
        $totalDeliveries = 0; // Sesuaikan dengan model Pengiriman nanti
        
        // Recent users (5 terakhir)
        $recentUsers = User::orderBy('created_at', 'desc')->limit(5)->get();
        
        return view('superadmin.dashboard', compact(
            'totalUsers', 
            'totalDrivers', 
            'totalAdmins',
            'totalCustomers', 
            'totalDeliveries', 
            'recentUsers'
        ));
    }
    
    // Method untuk halaman semua user
    public function users()
    {
        if (!Auth::check() || Auth::user()->role !== 'superadmin') {
            return redirect()->route('login')->with('error', 'Akses ditolak!');
        }
        
        $users = User::all();
        return view('superadmin.users', compact('users'));
    }
    
    // Method untuk form tambah akun
    public function createAkun()
    {
        if (!Auth::check() || Auth::user()->role !== 'superadmin') {
            return redirect()->route('login')->with('error', 'Akses ditolak!');
        }
        
        return view('superadmin.create-akun');
    }
    
    // Method untuk menyimpan akun baru
    public function storeAkun(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'superadmin') {
            return redirect()->route('login')->with('error', 'Akses ditolak!');
        }
        
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:admin,driver',
            'password' => 'required|min:6'
        ]);
        
        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_superadmin_fixed' => false
        ]);
        
        return redirect()->route('superadmin.users')->with('success', 'Akun ' . $request->role . ' berhasil dibuat!');
    }
    
    // Method untuk form edit akun
    public function editAkun($id)
    {
        if (!Auth::check() || Auth::user()->role !== 'superadmin') {
            return redirect()->route('login')->with('error', 'Akses ditolak!');
        }
        
        $user = User::findOrFail($id);
        
        if ($user->role == 'superadmin') {
            return redirect()->route('superadmin.users')->with('error', 'Tidak dapat mengedit akun Superadmin!');
        }
        
        return view('superadmin.edit-akun', compact('user'));
    }
    
    // Method untuk update akun
    public function updateAkun(Request $request, $id)
    {
        if (!Auth::check() || Auth::user()->role !== 'superadmin') {
            return redirect()->route('login')->with('error', 'Akses ditolak!');
        }
        
        $user = User::findOrFail($id);
        
        if ($user->role == 'superadmin') {
            return redirect()->route('superadmin.users')->with('error', 'Tidak dapat mengupdate akun Superadmin!');
        }
        
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id . ',user_id',
            'role' => 'required|in:admin,driver'
        ]);
        
        $updateData = [
            'nama' => $request->nama,
            'email' => $request->email,
            'role' => $request->role
        ];
        
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }
        
        $user->update($updateData);
        
        return redirect()->route('superadmin.users')->with('success', 'Akun berhasil diupdate!');
    }
    
    // Method untuk hapus akun
    public function deleteAkun($id)
    {
        if (!Auth::check() || Auth::user()->role !== 'superadmin') {
            return redirect()->route('login')->with('error', 'Akses ditolak!');
        }
        
        $user = User::findOrFail($id);
        
        if ($user->role == 'superadmin') {
            return redirect()->route('superadmin.users')->with('error', 'Tidak dapat menghapus akun Superadmin!');
        }
        
        $user->delete();
        
        return redirect()->route('superadmin.users')->with('success', 'Akun berhasil dihapus!');
    }
}