<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengiriman;

class DriverController extends Controller
{
    public function dashboard()
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }
        
        // Cek apakah role-nya driver
        if (Auth::user()->role !== 'driver') {
            return redirect()->route('login')->with('error', 'Anda tidak memiliki akses ke halaman ini');
        }
        
        // Ambil driver_id
        $driverId = Auth::user()->driver->driver_id ?? null;
        
        // Data untuk dashboard driver
        $totalDeliveries = 0;
        $completedDeliveries = 0;
        $pendingDeliveries = 0;
        
        if ($driverId) {
            // Hitung total pengiriman driver ini
            $totalDeliveries = Pengiriman::whereHas('pengajuan', function($q) use ($driverId) {
                                    $q->where('driver_id', $driverId);
                                })->count();
            
            // Hitung pengiriman selesai
            $completedDeliveries = Pengiriman::whereHas('pengajuan', function($q) use ($driverId) {
                                        $q->where('driver_id', $driverId);
                                    })->where('status', 'selesai')->count();
            
            // Hitung pengiriman dalam proses
            $pendingDeliveries = Pengiriman::whereHas('pengajuan', function($q) use ($driverId) {
                                        $q->where('driver_id', $driverId);
                                    })->where('status', '!=', 'selesai')->count();
        }
        
        return view('driver.dashboard', compact('totalDeliveries', 'completedDeliveries', 'pendingDeliveries'));
    }
    
    // ========== PENGIRIMAN SAYA (DRIVER) ==========
    
    // Daftar pengiriman untuk driver yang login
    public function pengirimanSaya()
    {
        // Cek role driver
        if (Auth::user()->role !== 'driver') {
            abort(403, 'Akses ditolak');
        }
        
        // Ambil driver_id dari relasi user->driver
        $driverId = Auth::user()->driver->driver_id ?? null;
        
        if (!$driverId) {
            return view('driver.pengiriman', ['pengirimans' => collect()])
                   ->with('error', 'Data driver tidak ditemukan. Hubungi admin.');
        }
        
        // Ambil pengiriman melalui relasi: pengiriman → pengajuan → driver
        $pengirimans = Pengiriman::whereHas('pengajuan', function($query) use ($driverId) {
                                $query->where('driver_id', $driverId);
                            })
                            ->with(['pengajuan.mobil', 'bukti'])
                            ->orderBy('created_at', 'desc')
                            ->get();
        
        return view('driver.pengiriman', compact('pengirimans'));
    }
    
    // Detail pengiriman
    public function detailPengiriman($id)
    {
        if (Auth::user()->role !== 'driver') {
            abort(403, 'Akses ditolak');
        }
        
        $driverId = Auth::user()->driver->driver_id ?? null;
        
        $pengiriman = Pengiriman::whereHas('pengajuan', function($query) use ($driverId) {
                                $query->where('driver_id', $driverId);
                            })
                            ->with(['pengajuan.mobil', 'pengajuan.driver', 'bukti'])
                            ->findOrFail($id);
        
        return view('driver.detail_pengiriman', compact('pengiriman'));
    }

// Update status pengiriman oleh driver
public function updateStatusPengiriman(Request $request, $id)
{
    if (Auth::user()->role !== 'driver') {
        abort(403, 'Akses ditolak');
    }
    
    $driverId = Auth::user()->driver->driver_id ?? null;
    
    $pengiriman = Pengiriman::whereHas('pengajuan', function($query) use ($driverId) {
                            $query->where('driver_id', $driverId);
                        })
                        ->findOrFail($id);
    
    $request->validate([
        'status' => 'required|in:proses,dikirim,selesai'
    ]);
    
    // Logika perubahan status
    $oldStatus = $pengiriman->status;
    $newStatus = $request->status;
    
    // Validasi urutan status
    $allowedTransitions = [
        'proses' => ['dikirim'],
        'dikirim' => ['selesai'],
        'selesai' => []
    ];
    
    if (!in_array($newStatus, $allowedTransitions[$oldStatus])) {
        return redirect()->back()->with('error', 'Tidak dapat mengubah status dari ' . $oldStatus . ' ke ' . $newStatus);
    }
    
    $pengiriman->status = $newStatus;
    $pengiriman->save();
    
    $statusText = [
        'proses' => 'Proses',
        'dikirim' => 'Dikirim',
        'selesai' => 'Selesai'
    ];
    
    return redirect()->back()->with('success', 'Status berhasil diubah menjadi ' . $statusText[$newStatus]);
}

// Riwayat pengiriman untuk driver (hanya miliknya)
// app/Http/Controllers/DriverController.php

// app/Http/Controllers/DriverController.php

public function riwayatPengiriman()
{
    if (Auth::user()->role !== 'driver') {
        abort(403, 'Akses ditolak');
    }
    
    $driverId = Auth::user()->driver->driver_id ?? null;
    
    if (!$driverId) {
        return view('driver.riwayat_pengiriman', [
            'pengirimans' => collect(),
            'totalPengiriman' => 0,
            'totalSelesai' => 0
        ])->with('error', 'Data driver tidak ditemukan.');
    }
    
    // PAKAI PAGINATE, BUKAN GET()
    $pengirimans = Pengiriman::whereHas('pengajuan', function($query) use ($driverId) {
                            $query->where('driver_id', $driverId);
                        })
                        ->where('status', 'selesai')
                        ->with(['pengajuan.mobil', 'bukti'])
                        ->orderBy('updated_at', 'desc')
                        ->paginate(10);  // ← pakai paginate, bukan get()
    
    // Hitung total semua pengiriman driver ini
    $totalPengiriman = Pengiriman::whereHas('pengajuan', function($query) use ($driverId) {
                            $query->where('driver_id', $driverId);
                        })->count();
    
    // Hitung total pengiriman selesai
    $totalSelesai = Pengiriman::whereHas('pengajuan', function($query) use ($driverId) {
                            $query->where('driver_id', $driverId);
                        })
                        ->where('status', 'selesai')
                        ->count();
    
    return view('driver.riwayat_pengiriman', compact('pengirimans', 'totalPengiriman', 'totalSelesai'));
}


// Driver melihat map tracking sendiri
public function trackingMap($id)
{
    $driverId = Auth::user()->driver->driver_id ?? null;
    
    $pengiriman = Pengiriman::whereHas('pengajuan', function($q) use ($driverId) {
                            $q->where('driver_id', $driverId);
                        })
                        ->with(['pengajuan.mobil', 'pengajuan.customer'])
                        ->findOrFail($id);
    
    return view('driver.tracking', compact('pengiriman'));
}
}