<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mobil;
use Illuminate\Support\Facades\Auth;
use App\Exports\MobilsExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class DataMobilController extends Controller
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
        $mobils = Mobil::orderBy('created_at', 'desc')->get();
        return view('admin.mobils.index', compact('mobils'));
    }
    
    public function create()
    {
        $this->checkAdmin();
        return view('admin.mobils.create');
    }
    
    public function store(Request $request)
    {
        $this->checkAdmin();
        
        $request->validate([
            'no_plat' => 'required|string|max:20|unique:mobils,no_plat',
            'merk' => 'nullable|string|max:50',
            'jenis_mobil' => 'required|string|max:100',
            'pajak_stnk' => 'nullable|date',
            'pajak_plat' => 'nullable|date',
            'kir' => 'nullable|date',
            'status' => 'required|in:aktif,perbaikan,nonaktif',
            'keterangan' => 'nullable|string',
        ]);
        
        Mobil::create($request->all());
        
        return redirect()->route('admin.mobils.index')
                         ->with('success', 'Mobil berhasil ditambahkan');
    }
    
    public function edit($id)
    {
        $this->checkAdmin();
        $mobil = Mobil::findOrFail($id);
        return view('admin.mobils.edit', compact('mobil'));
    }
    
    public function update(Request $request, $id)
    {
        $this->checkAdmin();
        
        $mobil = Mobil::findOrFail($id);
        
        $request->validate([
            'no_plat' => 'required|string|max:20|unique:mobils,no_plat,' . $id . ',mobil_id',
            'merk' => 'nullable|string|max:50',
            'jenis_mobil' => 'required|string|max:100',
            'pajak_stnk' => 'nullable|date',
            'pajak_plat' => 'nullable|date',
            'kir' => 'nullable|date',
            'status' => 'required|in:aktif,perbaikan,nonaktif',
            'keterangan' => 'nullable|string',
        ]);
        
        $mobil->update($request->all());
        
        return redirect()->route('admin.mobils.index')
                         ->with('success', 'Mobil berhasil diupdate');
    }
    
    public function destroy($id)
    {
        $this->checkAdmin();
        $mobil = Mobil::findOrFail($id);
        $mobil->delete();
        
        return redirect()->route('admin.mobils.index')
                         ->with('success', 'Mobil berhasil dihapus');
    }

// Export ke Excel
public function exportExcel()
{
    return Excel::download(new MobilsExport, 'data-mobil-' . date('d-m-Y') . '.xlsx');
}

// Export ke PDF
public function exportPdf()
{
    $mobils = Mobil::orderBy('created_at', 'desc')->get();
    $pdf = Pdf::loadView('admin.mobils.export_pdf', compact('mobils'));
    return $pdf->download('data-mobil-' . date('d-m-Y') . '.pdf');
}

// Export ke Word (DOC)
public function exportWord()
{
    $mobils = Mobil::orderBy('created_at', 'desc')->get();
    
    $html = view('admin.mobils.export_word', compact('mobils'))->render();
    
    header("Content-Type: application/msword");
    header("Content-Disposition: attachment; filename=data-mobil-" . date('d-m-Y') . ".doc");
    header("Pragma: no-cache");
    header("Expires: 0");
    
    echo $html;
    exit;
}

}