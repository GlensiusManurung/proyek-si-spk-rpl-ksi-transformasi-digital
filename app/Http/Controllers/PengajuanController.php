<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengajuan;
use App\Models\Driver;
use App\Models\Mobil;
use App\Models\Customer;
use App\Models\Pengiriman;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PengajuanController extends Controller
{
    private function checkAdmin()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Akses ditolak. Hanya admin yang dapat mengakses halaman ini.');
        }
    }
    
    public function index()
    {
        $this->checkAdmin();
        $pengajuans = Pengajuan::with(['driver', 'mobil', 'customer'])->orderBy('created_at', 'desc')->get();
        return view('admin.pengajuans.index', compact('pengajuans'));
    }
    
    // CREATE - ambil data driver & mobil yang TERSEDIA (tidak sibuk)
   public function create()
{
    $this->checkAdmin();
    
    // Driver yang TIDAK punya pengiriman dengan status PROSES atau DIKIRIM
    $drivers = Driver::where('status', 'aktif')
                    ->whereNotIn('driver_id', function($q) {
                        $q->select('driver_id')
                          ->from('pengajuans')
                          ->whereIn('pengajuan_id', function($sub) {
                              $sub->select('pengajuan_id')
                                  ->from('pengirimans')
                                  ->whereIn('status', ['proses', 'dikirim']);
                          });
                    })
                    ->get();
    
    // Mobil yang TIDAK punya pengiriman dengan status PROSES atau DIKIRIM
    $mobils = Mobil::where('status', 'aktif')
                    ->whereNotIn('mobil_id', function($q) {
                        $q->select('mobil_id')
                          ->from('pengajuans')
                          ->whereIn('pengajuan_id', function($sub) {
                              $sub->select('pengajuan_id')
                                  ->from('pengirimans')
                                  ->whereIn('status', ['proses', 'dikirim']);
                          });
                    })
                    ->get();
    
    $customers = Customer::all();
    
    return view('admin.pengajuans.create', compact('drivers', 'mobils', 'customers'));
}
   public function store(Request $request)
{
    $this->checkAdmin();
    
    $request->validate([
        'driver_id' => 'required|exists:drivers,driver_id',
        'mobil_id' => 'required|exists:mobils,mobil_id',
        'customer_id' => 'required|exists:customers,customer_id',
        'tanggal_pengajuan' => 'required|date',
        'keterangan' => 'nullable|string',
        'bukti_struk' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048'
    ]);
    
    // ========== VALIDASI DRIVER ==========
    // Cek apakah driver punya pengiriman aktif (proses/dikirim)
    $driverAktif = Pengiriman::whereHas('pengajuan', function($q) use ($request) {
                        $q->where('driver_id', $request->driver_id);
                    })
                    ->whereIn('status', ['proses', 'dikirim'])
                    ->exists();
    
    if ($driverAktif) {
        return redirect()->back()
            ->with('error', '❌ Driver ini masih memiliki pengiriman aktif! Harap selesaikan pengiriman terlebih dahulu.')
            ->withInput();
    }
    
    // ========== VALIDASI MOBIL ==========
    // Cek apakah mobil punya pengiriman aktif (proses/dikirim)
    $mobilAktif = Pengiriman::whereHas('pengajuan', function($q) use ($request) {
                        $q->where('mobil_id', $request->mobil_id);
                    })
                    ->whereIn('status', ['proses', 'dikirim'])
                    ->exists();
    
    if ($mobilAktif) {
        return redirect()->back()
            ->with('error', '❌ Mobil ini sedang digunakan pada pengiriman aktif!')
            ->withInput();
    }
    
    // ========== SIMPAN PENGAJUAN ==========
    $data = $request->except(['bukti_struk']);
    $data['status'] = 'pending';
    
    if ($request->hasFile('bukti_struk')) {
        $file = $request->file('bukti_struk');
        $fileName = 'struk_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('pengajuans/struk', $fileName, 'public');
        $data['bukti_struk'] = 'pengajuans/struk/' . $fileName;
    }
    
    Pengajuan::create($data);
    
    return redirect()->route('admin.pengajuans.index')
        ->with('success', 'Pengajuan berhasil ditambahkan!');
}
    
    public function edit($id)
    {
        $this->checkAdmin();
        
        $pengajuan = Pengajuan::with(['driver', 'mobil', 'customer'])->findOrFail($id);
        
        // Ambil driver yang tersedia (termasuk driver saat ini)
        $drivers = Driver::where(function($q) use ($pengajuan) {
                        $q->whereDoesntHave('pengajuans', function($sub) use ($pengajuan) {
                                $sub->whereIn('status', ['pending', 'disetujui'])
                                    ->where('pengajuan_id', '!=', $pengajuan->pengajuan_id);
                            })
                            ->whereDoesntHave('pengajuans.pengiriman', function($sub) use ($pengajuan) {
                                $sub->whereIn('status', ['proses', 'dikirim'])
                                    ->where('pengajuan_id', '!=', $pengajuan->pengajuan_id);
                            });
                    })
                    ->orWhere('driver_id', $pengajuan->driver_id)
                    ->where('status', 'aktif')
                    ->get();
        
        // Ambil mobil yang tersedia (termasuk mobil saat ini)
        $mobils = Mobil::where(function($q) use ($pengajuan) {
                        $q->whereDoesntHave('pengajuans', function($sub) use ($pengajuan) {
                                $sub->whereIn('status', ['pending', 'disetujui'])
                                    ->where('pengajuan_id', '!=', $pengajuan->pengajuan_id);
                            })
                            ->whereDoesntHave('pengajuans.pengiriman', function($sub) use ($pengajuan) {
                                $sub->whereIn('status', ['proses', 'dikirim'])
                                    ->where('pengajuan_id', '!=', $pengajuan->pengajuan_id);
                            });
                    })
                    ->orWhere('mobil_id', $pengajuan->mobil_id)
                    ->where('status', 'aktif')
                    ->get();
        
        $customers = Customer::all();
        
        return view('admin.pengajuans.edit', compact('pengajuan', 'drivers', 'mobils', 'customers'));
    }
    
    public function update(Request $request, $id)
    {
        $this->checkAdmin();
        
        $pengajuan = Pengajuan::findOrFail($id);
        
        $request->validate([
            'driver_id' => 'required|exists:drivers,driver_id',
            'mobil_id' => 'required|exists:mobils,mobil_id',
            'customer_id' => 'required|exists:customers,customer_id',
            'tanggal_pengajuan' => 'required|date',
            'keterangan' => 'nullable|string',
            'bukti_struk' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);
        
        // ========== VALIDASI DRIVER (kecuali pengajuan ini) ==========
        $pengajuanAktif = Pengajuan::where('driver_id', $request->driver_id)
            ->whereIn('status', ['pending', 'disetujui'])
            ->where('pengajuan_id', '!=', $id)
            ->exists();
        
        if ($pengajuanAktif) {
            return redirect()->back()
                ->with('error', '❌ Driver ini masih memiliki pengajuan aktif lain!')
                ->withInput();
        }
        
        $pengirimanBelumSelesai = Pengiriman::whereHas('pengajuan', function($q) use ($request, $id) {
                $q->where('driver_id', $request->driver_id)
                  ->where('pengajuan_id', '!=', $id);
            })
            ->whereIn('status', ['proses', 'dikirim'])
            ->exists();
        
        if ($pengirimanBelumSelesai) {
            return redirect()->back()
                ->with('error', '❌ Driver ini masih memiliki pengiriman yang belum selesai!')
                ->withInput();
        }
        
        // ========== VALIDASI MOBIL (kecuali pengajuan ini) ==========
        $mobilPengajuanAktif = Pengajuan::where('mobil_id', $request->mobil_id)
            ->whereIn('status', ['pending', 'disetujui'])
            ->where('pengajuan_id', '!=', $id)
            ->exists();
        
        if ($mobilPengajuanAktif) {
            return redirect()->back()
                ->with('error', '❌ Mobil ini sedang diajukan pada pengajuan lain yang masih aktif!')
                ->withInput();
        }
        
        $mobilPengirimanAktif = Pengiriman::whereHas('pengajuan', function($q) use ($request, $id) {
                $q->where('mobil_id', $request->mobil_id)
                  ->where('pengajuan_id', '!=', $id);
            })
            ->whereIn('status', ['proses', 'dikirim'])
            ->exists();
        
        if ($mobilPengirimanAktif) {
            return redirect()->back()
                ->with('error', '❌ Mobil ini sedang digunakan pada pengiriman yang belum selesai!')
                ->withInput();
        }
        
        // ========== UPDATE PENGAJUAN ==========
        $data = $request->except(['bukti_struk']);
        
        if ($request->hasFile('bukti_struk')) {
            if ($pengajuan->bukti_struk && Storage::disk('public')->exists($pengajuan->bukti_struk)) {
                Storage::disk('public')->delete($pengajuan->bukti_struk);
            }
            $file = $request->file('bukti_struk');
            $fileName = 'struk_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('pengajuans/struk', $fileName, 'public');
            $data['bukti_struk'] = 'pengajuans/struk/' . $fileName;
        }
        
        $pengajuan->update($data);
        
        return redirect()->route('admin.pengajuans.index')
            ->with('success', '✅ Pengajuan berhasil diupdate!');
    }
    
  public function destroy($id)
{
    try {
        $this->checkAdmin();
        
        \Log::info('Mencoba hapus pengajuan ID: ' . $id);
        
        $pengajuan = Pengajuan::findOrFail($id);
        
        \Log::info('Pengajuan ditemukan: ' . $pengajuan->pengajuan_id);
        
        // Hapus file
        if ($pengajuan->bukti_struk && Storage::disk('public')->exists($pengajuan->bukti_struk)) {
            Storage::disk('public')->delete($pengajuan->bukti_struk);
        }
        
        $pengajuan->delete();
        
        \Log::info('Pengajuan berhasil dihapus');
        
        return redirect()->route('admin.pengajuans.index')
            ->with('success', '✅ Pengajuan berhasil dihapus!');
            
    } catch (\Exception $e) {
        \Log::error('Error hapus pengajuan: ' . $e->getMessage());
        return redirect()->back()
            ->with('error', '❌ Gagal menghapus: ' . $e->getMessage());
    }
}
    
    public function approve($id)
    {
        $this->checkAdmin();
        
        $pengajuan = Pengajuan::findOrFail($id);
        
        if ($pengajuan->status != 'pending') {
            return redirect()->back()->with('error', '❌ Pengajuan sudah diproses sebelumnya!');
        }
        
        $pengajuan->status = 'disetujui';
        $pengajuan->disetujui_oleh = Auth::user()->nama;
        $pengajuan->tanggal_disetujui = now();
        $pengajuan->save();
        
        return redirect()->route('admin.pengajuans.index')
            ->with('success', '✅ Pengajuan berhasil disetujui!');
    }
    
    public function reject($id)
    {
        $this->checkAdmin();
        
        $pengajuan = Pengajuan::findOrFail($id);
        
        if ($pengajuan->status != 'pending') {
            return redirect()->back()->with('error', '❌ Pengajuan sudah diproses sebelumnya!');
        }
        
        $pengajuan->status = 'ditolak';
        $pengajuan->save();
        
        return redirect()->route('admin.pengajuans.index')
            ->with('success', '✅ Pengajuan ditolak!');
    }
}