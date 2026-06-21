<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengiriman;
use App\Models\Pengajuan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Exports\PengirimansExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class PengirimanController extends Controller
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
        $pengirimans = Pengiriman::with('pengajuan.driver', 'pengajuan.mobil')
                                 ->orderBy('created_at', 'desc')
                                 ->get();
        return view('admin.pengirimans.index', compact('pengirimans'));
    }
    
    public function create()
    {
        $this->checkAdmin();
        
        // Ambil pengajuan yang sudah disetujui dan BELUM PERNAH ada pengiriman
        $pengajuans = Pengajuan::where('status', 'disetujui')
            ->whereDoesntHave('pengiriman') // HARUS BELUM PERNAH ADA PENGIRIMAN
            ->whereHas('customer') // HARUS PUNYA CUSTOMER
            ->whereHas('driver', function($q) {
                $q->where('status', 'aktif');
            })
            ->whereHas('mobil', function($q) {
                $q->where('status', 'aktif');
            })
            ->with(['driver', 'mobil', 'customer'])
            ->get()
            ->filter(function($pengajuan) {
                // Cek driver sedang sibuk (ada pengiriman aktif)
                $driverBusy = Pengiriman::whereHas('pengajuan', function($q) use ($pengajuan) {
                        $q->where('driver_id', $pengajuan->driver_id);
                    })
                    ->whereIn('status', ['proses', 'dikirim'])
                    ->exists();
                
                if ($driverBusy) {
                    return false;
                }
                
                // Cek mobil sedang sibuk (ada pengiriman aktif)
                $mobilBusy = Pengiriman::whereHas('pengajuan', function($q) use ($pengajuan) {
                        $q->where('mobil_id', $pengajuan->mobil_id);
                    })
                    ->whereIn('status', ['proses', 'dikirim'])
                    ->exists();
                
                if ($mobilBusy) {
                    return false;
                }
                
                return true;
            });
        
        return view('admin.pengirimans.create', compact('pengajuans'));
    }
    
    public function store(Request $request)
    {
        $this->checkAdmin();
        
        $request->validate([
            'pengajuan_id' => 'required|exists:pengajuans,pengajuan_id',
            'tanggal_pengiriman' => 'required|date',
            'deskripsi' => 'nullable|string',
            'catatan' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);
        
        $pengajuan = Pengajuan::findOrFail($request->pengajuan_id);
        
        // ========== VALIDASI SEBELUM MEMBUAT PENGIRIMAN ==========
        
        // 1. Cek pengajuan sudah disetujui
        if ($pengajuan->status !== 'disetujui') {
            return redirect()->back()
                ->with('error', '❌ Pengajuan harus berstatus DISETUJUI terlebih dahulu!')
                ->withInput();
        }
        
        // 2. Cek apakah sudah pernah ada pengiriman
        if ($pengajuan->pengiriman()->exists()) {
            return redirect()->back()
                ->with('error', '❌ Pengajuan ini sudah pernah dibuat pengiriman! Silakan buat pengajuan baru.')
                ->withInput();
        }
        
        // 3. Cek customer harus ada
        if (!$pengajuan->customer) {
            return redirect()->back()
                ->with('error', '❌ Pengajuan tidak memiliki customer yang valid!')
                ->withInput();
        }
        
        // 4. Cek driver sedang sibuk?
        $driverBusy = Pengiriman::whereHas('pengajuan', function($q) use ($pengajuan) {
                $q->where('driver_id', $pengajuan->driver_id);
            })
            ->whereIn('status', ['proses', 'dikirim'])
            ->exists();
        
        if ($driverBusy) {
            return redirect()->back()
                ->with('error', '❌ Driver ' . ($pengajuan->driver->nama ?? '-') . ' sedang ada pengiriman aktif!')
                ->withInput();
        }
        
        // 5. Cek mobil sedang dipakai?
        $mobilBusy = Pengiriman::whereHas('pengajuan', function($q) use ($pengajuan) {
                $q->where('mobil_id', $pengajuan->mobil_id);
            })
            ->whereIn('status', ['proses', 'dikirim'])
            ->exists();
        
        if ($mobilBusy) {
            return redirect()->back()
                ->with('error', '❌ Mobil ' . ($pengajuan->mobil->no_plat ?? '-') . ' sedang digunakan untuk pengiriman!')
                ->withInput();
        }
        
        // ========== SIMPAN PENGIRIMAN ==========
        $data = $request->except(['gambar']);
        $data['nomor_surat_jalan'] = Pengiriman::generateNomorSuratJalan();
        $data['status'] = 'proses';
        
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $fileName = 'pengiriman_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('pengirimans', $fileName, 'public');
            $data['gambar'] = 'pengirimans/' . $fileName;
        }
        
        Pengiriman::create($data);
        
        return redirect()->route('admin.pengirimans.index')
            ->with('success', '✅ Pengiriman berhasil dibuat!');
    }
    
    public function edit($id)
    {
        $this->checkAdmin();
        
        $pengiriman = Pengiriman::with('pengajuan.driver', 'pengajuan.mobil')->findOrFail($id);
        
        return view('admin.pengirimans.edit', compact('pengiriman'));
    }
    
    public function update(Request $request, $id)
    {
        $this->checkAdmin();
        
        $pengiriman = Pengiriman::findOrFail($id);
        
        $request->validate([
            'tanggal_pengiriman' => 'required|date',
            'status' => 'required|in:proses,dikirim,selesai',
            'deskripsi' => 'nullable|string',
            'catatan' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);
        
        $data = $request->except(['gambar']);
        
        if ($request->hasFile('gambar')) {
            if ($pengiriman->gambar && Storage::disk('public')->exists($pengiriman->gambar)) {
                Storage::disk('public')->delete($pengiriman->gambar);
            }
            $file = $request->file('gambar');
            $fileName = 'pengiriman_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('pengirimans', $fileName, 'public');
            $data['gambar'] = 'pengirimans/' . $fileName;
        }
        
        $pengiriman->update($data);
        
        return redirect()->route('admin.pengirimans.index')
            ->with('success', '✅ Pengiriman berhasil diupdate');
    }
    
    public function destroy($id)
    {
        $this->checkAdmin();
        
        $pengiriman = Pengiriman::findOrFail($id);
        
        // Hapus file gambar jika ada
        if ($pengiriman->gambar && Storage::disk('public')->exists($pengiriman->gambar)) {
            Storage::disk('public')->delete($pengiriman->gambar);
        }
        
        // Simpan ID pengajuan sebelum hapus
        $pengajuanId = $pengiriman->pengajuan_id;
        
        // Hapus pengiriman
        $pengiriman->delete();
        
        // RESET STATUS PENGAJUAN MENJADI 'pending' AGAR HARUS DISETUJUI ULANG
        $pengajuan = Pengajuan::find($pengajuanId);
        if ($pengajuan) {
            $pengajuan->status = 'pending';
            $pengajuan->disetujui_oleh = null;
            $pengajuan->tanggal_disetujui = null;
            $pengajuan->save();
        }
        
        return redirect()->route('admin.pengirimans.index')
            ->with('success', '✅ Pengiriman dihapus! Status pengajuan direset ke PENDING. Silakan setujui ulang jika ingin membuat pengiriman baru.');
    }
    
    // Update status
    public function updateStatus(Request $request, $id)
    {
        $this->checkAdmin();
        
        $request->validate([
            'status' => 'required|in:proses,dikirim,selesai'
        ]);
        
        $pengiriman = Pengiriman::findOrFail($id);
        $pengiriman->status = $request->status;
        $pengiriman->save();
        
        return redirect()->route('admin.pengirimans.index')
            ->with('success', '✅ Status pengiriman berhasil diupdate');
    }
    
    // Riwayat pengiriman untuk admin (semua data)
    public function riwayat()
    {
        $this->checkAdmin();
        
        $pengirimans = Pengiriman::with(['pengajuan.driver', 'pengajuan.mobil', 'bukti'])
                                 ->where('status', 'selesai')
                                 ->orderBy('updated_at', 'desc')
                                 ->paginate(15);
        
        $totalPengiriman = Pengiriman::count();
        $totalSelesai = Pengiriman::where('status', 'selesai')->count();
        
        return view('admin.riwayat_pengiriman', compact('pengirimans', 'totalPengiriman', 'totalSelesai'));
    }
    
    // Export ke Excel
    public function exportExcel()
    {
        return Excel::download(new PengirimansExport, 'data-pengiriman-' . date('d-m-Y') . '.xlsx');
    }
    
    // Export ke PDF
    public function exportPdf()
    {
        $pengirimans = Pengiriman::with(['pengajuan.driver', 'pengajuan.mobil'])->orderBy('created_at', 'desc')->get();
        $pdf = Pdf::loadView('admin.pengirimans.export_pdf', compact('pengirimans'));
        return $pdf->download('data-pengiriman-' . date('d-m-Y') . '.pdf');
    }
    
    // Export ke Word
    public function exportWord()
    {
        $pengirimans = Pengiriman::with(['pengajuan.driver', 'pengajuan.mobil'])->orderBy('created_at', 'desc')->get();
        $html = view('admin.pengirimans.export_word', compact('pengirimans'))->render();
        
        header("Content-Type: application/msword");
        header("Content-Disposition: attachment; filename=data-pengiriman-" . date('d-m-Y') . ".doc");
        header("Pragma: no-cache");
        header("Expires: 0");
        
        echo $html;
        exit;
    }
}