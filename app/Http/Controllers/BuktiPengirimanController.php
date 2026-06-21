<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BuktiPengiriman;
use App\Models\Pengiriman;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BuktiPengirimanController extends Controller
{
    private function checkDriver()
    {
        if (!Auth::check() || Auth::user()->role !== 'driver') {
            abort(403, 'Akses ditolak. Hanya driver yang dapat mengakses halaman ini.');
        }
    }
    
    private function checkAdmin()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Akses ditolak. Hanya admin yang dapat mengakses halaman ini.');
        }
    }
    
    // ==================== DRIVER ====================
    
    // Driver - Tampilkan pengiriman yang bisa diupload bukti
    public function driverIndex()
    {
        $this->checkDriver();
        
        $driverId = Auth::user()->driver->driver_id ?? null;
        
        // Ambil pengiriman yang statusnya selesai dan belum ada bukti
        $pengirimans = Pengiriman::whereHas('pengajuan', function($q) use ($driverId) {
                                $q->where('driver_id', $driverId);
                            })
                            ->where('status', 'selesai')
                            ->whereDoesntHave('bukti')
                            ->with('pengajuan.mobil')
                            ->orderBy('created_at', 'desc')
                            ->get();
        
        // Ambil bukti yang sudah diupload
        $buktis = BuktiPengiriman::whereHas('pengiriman.pengajuan', function($q) use ($driverId) {
                                    $q->where('driver_id', $driverId);
                                })
                                ->with('pengiriman')
                                ->orderBy('created_at', 'desc')
                                ->get();
        
        return view('driver.bukti_pengiriman.index', compact('pengirimans', 'buktis'));
    }
    
    // Driver - Form upload bukti
    public function driverCreate($pengiriman_id)
    {
        $this->checkDriver();
        
        $pengiriman = Pengiriman::with('pengajuan.mobil')
                                ->whereHas('pengajuan', function($q) {
                                    $q->where('driver_id', Auth::user()->driver->driver_id ?? null);
                                })
                                ->findOrFail($pengiriman_id);
        
        return view('driver.bukti_pengiriman.create', compact('pengiriman'));
    }
    
    // Driver - Simpan bukti
    public function driverStore(Request $request, $pengiriman_id)
    {
        $this->checkDriver();
        
        $request->validate([
            'deskripsi' => 'nullable|string',
            'gambar' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);
        
        $pengiriman = Pengiriman::findOrFail($pengiriman_id);
        
        // Upload gambar
        $file = $request->file('gambar');
        $fileName = 'bukti_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('bukti_pengiriman', $fileName, 'public');
        
        BuktiPengiriman::create([
            'pengiriman_id' => $pengiriman_id,
            'tanggal_bukti' => now(),
            'gambar' => 'bukti_pengiriman/' . $fileName,
            'deskripsi' => $request->deskripsi,
            'uploaded_by' => Auth::user()->nama
        ]);
        
        return redirect()->route('driver.bukti-pengiriman.index')
                         ->with('success', 'Bukti pengiriman berhasil diupload');
    }
    
    // ==================== ADMIN ====================
    
    // Admin - Lihat semua bukti
    public function adminIndex()
    {
        $this->checkAdmin();
        
        $buktis = BuktiPengiriman::with('pengiriman.pengajuan.driver', 'pengiriman.pengajuan.mobil')
                                 ->orderBy('created_at', 'desc')
                                 ->get();
        
        return view('admin.bukti_pengiriman.index', compact('buktis'));
    }
    
    // Admin - Detail bukti
    public function show($id)
    {
        $this->checkAdmin();
        
        $bukti = BuktiPengiriman::with('pengiriman.pengajuan.driver', 'pengiriman.pengajuan.mobil')
                                ->findOrFail($id);
        
        return view('admin.bukti_pengiriman.show', compact('bukti'));
    }
    
    // Admin - Hapus bukti
    public function destroy($id)
    {
        $this->checkAdmin();
        
        $bukti = BuktiPengiriman::findOrFail($id);
        
        if ($bukti->gambar && Storage::disk('public')->exists($bukti->gambar)) {
            Storage::disk('public')->delete($bukti->gambar);
        }
        
        $bukti->delete();
        
        return redirect()->route('admin.bukti-pengiriman.index')
                         ->with('success', 'Bukti pengiriman berhasil dihapus');
    }
}