<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Driver;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Exports\DriversExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class DataDriverController extends Controller
{
    // Cek akses admin
    private function checkAdmin()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Akses ditolak. Hanya admin yang dapat mengakses halaman ini.');
        }
    }
    
    // Index - Tampilkan semua driver
    public function index()
    {
        $this->checkAdmin();
        
        $drivers = Driver::with('user')->orderBy('created_at', 'desc')->get();
        
        return view('admin.drivers.index', compact('drivers'));
    }
    
    // Form tambah driver
    public function create()
    {
        $this->checkAdmin();
        
        // Ambil user dengan role driver yang belum punya data driver
        $availableUsers = User::where('role', 'driver')
                              ->whereDoesntHave('driver')
                              ->get();
        
        return view('admin.drivers.create', compact('availableUsers'));
    }
    
    // Simpan driver
    public function store(Request $request)
    {
        $this->checkAdmin();
        
        $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'nama' => 'required|string|max:255',
            'no_sim' => 'required|string|max:50|unique:drivers,no_sim',
            'nik' => 'required|string|max:20|unique:drivers,nik',
            'no_rek' => 'nullable|string|max:30',
            'nomor_kontak' => 'required|string|max:15',
            'alamat' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
        ]);
        
        $data = $request->only([
            'user_id', 'nama', 'no_sim', 'nik', 'no_rek', 'nomor_kontak', 'alamat', 'status'
        ]);
        
        Driver::create($data);
        
        return redirect()->route('admin.drivers.index')
                         ->with('success', 'Driver berhasil ditambahkan');
    }
    
    // Form edit driver
    public function edit($id)
    {
        $this->checkAdmin();
        
        $driver = Driver::with('user')->findOrFail($id);
        
        return view('admin.drivers.edit', compact('driver'));
    }
    
    // Update driver
    public function update(Request $request, $id)
    {
        $this->checkAdmin();
        
        $driver = Driver::findOrFail($id);
        
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_sim' => 'required|string|max:50|unique:drivers,no_sim,' . $id . ',driver_id',
            'nik' => 'required|string|max:20|unique:drivers,nik,' . $id . ',driver_id',
            'no_rek' => 'nullable|string|max:30',
            'nomor_kontak' => 'required|string|max:15',
            'alamat' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
        ]);
        
        $data = $request->only([
            'nama', 'no_sim', 'nik', 'no_rek', 'nomor_kontak', 'alamat', 'status'
        ]);
        
        $driver->update($data);
        
        return redirect()->route('admin.drivers.index')
                         ->with('success', 'Driver berhasil diupdate');
    }
    
    // Hapus driver
    public function destroy($id)
    {
        $this->checkAdmin();
        
        $driver = Driver::findOrFail($id);
        
        $driver->delete();
        
        return redirect()->route('admin.drivers.index')
                         ->with('success', 'Driver berhasil dihapus');
    }
    
    // Detail driver
    public function show($id)
    {
        $this->checkAdmin();
        
        $driver = Driver::with('user')->findOrFail($id);
        
        return view('admin.drivers.show', compact('driver'));
    }


    // Export ke Excel
public function exportExcel()
{
    return Excel::download(new DriversExport, 'data-driver-' . date('d-m-Y') . '.xlsx');
}

// Export ke PDF
public function exportPdf()
{
    $drivers = Driver::with('user')->orderBy('created_at', 'desc')->get();
    $pdf = Pdf::loadView('admin.drivers.export_pdf', compact('drivers'));
    return $pdf->download('data-driver-' . date('d-m-Y') . '.pdf');
}

// Export ke Word (DOC)
public function exportWord()
{
    $drivers = Driver::with('user')->orderBy('created_at', 'desc')->get();
    
    $html = view('admin.drivers.export_word', compact('drivers'))->render();
    
    header("Content-Type: application/msword");
    header("Content-Disposition: attachment; filename=data-driver-" . date('d-m-Y') . ".doc");
    header("Pragma: no-cache");
    header("Expires: 0");
    
    echo $html;
    exit;
}
}