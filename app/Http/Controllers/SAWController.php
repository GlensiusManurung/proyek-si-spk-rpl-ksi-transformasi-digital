<?php
// app/Http/Controllers/SAWController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Driver;
use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\Pengiriman;
use App\Models\BuktiPengiriman;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SAWController extends Controller
{
    private function checkAdmin()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403);
        }
    }
    
    // ==================== CRUD KRITERIA ====================
    
    public function kriteriaIndex()
    {
        $this->checkAdmin();
        $kriterias = Kriteria::orderBy('kode_kriteria')->get();
        return view('admin.saw.kriteria_index', compact('kriterias'));
    }
    
    public function kriteriaStore(Request $request)
    {
        $this->checkAdmin();
        
        // VALIDASI: hanya required, tidak pake numeric dulu
        $request->validate([
            'kode_kriteria' => 'required|unique:kriterias,kode_kriteria',
            'nama_kriteria' => 'required',
            'jenis' => 'required|in:benefit,cost',
            'bobot' => 'required'
        ]);
        
        // Konversi koma ke titik (contoh: "0,25" -> "0.25")
        $bobot = str_replace(',', '.', $request->bobot);
        
        // Validasi manual apakah angka setelah konversi
        if (!is_numeric($bobot)) {
            return redirect()->back()->withErrors(['bobot' => 'Bobot harus berupa angka!'])->withInput();
        }
        
        if ((float)$bobot < 0) {
            return redirect()->back()->withErrors(['bobot' => 'Bobot tidak boleh negatif!'])->withInput();
        }
        
        // Hapus .00 di belakang jika angka bulat
        if ((float)$bobot == (int)$bobot) {
            $bobot = (string)(int)$bobot;
        }
        
        $data = $request->all();
        $data['bobot'] = $bobot;
        
        Kriteria::create($data);
        
        return redirect()->route('admin.saw.kriteria')->with('success', 'Kriteria berhasil ditambahkan!');
    }
    
    public function kriteriaUpdate(Request $request, $id)
    {
        $this->checkAdmin();
        
        $kriteria = Kriteria::findOrFail($id);
        
        // VALIDASI: hanya required
        $request->validate([
            'kode_kriteria' => 'required|unique:kriterias,kode_kriteria,' . $id . ',kriteria_id',
            'nama_kriteria' => 'required',
            'jenis' => 'required|in:benefit,cost',
            'bobot' => 'required'
        ]);
        
        // Konversi koma ke titik
        $bobot = str_replace(',', '.', $request->bobot);
        
        // Validasi manual
        if (!is_numeric($bobot)) {
            return redirect()->back()->withErrors(['bobot' => 'Bobot harus berupa angka!'])->withInput();
        }
        
        if ((float)$bobot < 0) {
            return redirect()->back()->withErrors(['bobot' => 'Bobot tidak boleh negatif!'])->withInput();
        }
        
        // Hapus .00 di belakang jika angka bulat
        if ((float)$bobot == (int)$bobot) {
            $bobot = (string)(int)$bobot;
        }
        
        $data = $request->all();
        $data['bobot'] = $bobot;
        
        $kriteria->update($data);
        
        return redirect()->route('admin.saw.kriteria')->with('success', 'Kriteria berhasil diupdate!');
    }
    
    public function kriteriaDestroy($id)
    {
        $this->checkAdmin();
        
        $kriteria = Kriteria::findOrFail($id);
        
        Penilaian::where('kriteria_id', $id)->delete();
        $kriteria->delete();
        
        return redirect()->route('admin.saw.kriteria')->with('success', 'Kriteria berhasil dihapus!');
    }
    
    public function kriteriaCreate()
    {
        $this->checkAdmin();
        return view('admin.saw.kriteria_create');
    }
    
    public function kriteriaEdit($id)
    {
        $this->checkAdmin();
        $kriteria = Kriteria::findOrFail($id);
        return view('admin.saw.kriteria_edit', compact('kriteria'));
    }
    
    // ==================== PENILAIAN DRIVER ====================
    
    public function penilaianIndex()
    {
        $this->checkAdmin();
        
        $drivers = Driver::with('user')->get();
        $kriterias = Kriteria::all();
        
        $penilaians = Penilaian::all()->keyBy(function($item) {
            return $item->driver_id . '_' . $item->kriteria_id;
        });
        
        return view('admin.saw.penilaian', compact('drivers', 'kriterias', 'penilaians'));
    }
    
    public function simpanPenilaian(Request $request)
    {
        $this->checkAdmin();
        
        $nilaiArray = $request->input('nilai', []);
        
        foreach ($nilaiArray as $driverId => $kriterias) {
            if (!is_array($kriterias)) {
                continue;
            }
            foreach ($kriterias as $kriteriaId => $nilai) {
                if (is_null($nilai) || $nilai === '') {
                    continue;
                }
                
                $kriteria = Kriteria::find($kriteriaId);
                if ($kriteria) {
                    if ($kriteria->jenis == 'cost') {
                        $nilai = max(1, min(5, (int)$nilai));
                    } else {
                        $nilai = max(0, min(100, (int)$nilai));
                    }
                }
                
                Penilaian::updateOrCreate(
                    ['driver_id' => $driverId, 'kriteria_id' => $kriteriaId],
                    ['nilai' => $nilai]
                );
            }
        }
        
        return redirect()->route('admin.saw.penilaian')->with('success', 'Penilaian berhasil disimpan!');
    }
    
    // ==================== RANKING SAW ====================
    
    public function hitungRanking()
    {
        $this->checkAdmin();
        
        $drivers = Driver::with('user')->get();
        $kriterias = Kriteria::orderBy('kode_kriteria')->get();
        $penilaians = Penilaian::all()->keyBy(function($item) {
            return $item->driver_id . '_' . $item->kriteria_id;
        });
        
        if ($drivers->isEmpty()) {
            return view('admin.saw.ranking', ['ranking' => [], 'kriterias' => $kriterias]);
        }
        
        $dataDriver = [];
        $semuaNilai = [];
        
        foreach ($drivers as $driver) {
            $nilaiKriteria = [];
            
            foreach ($kriterias as $kriteria) {
                $kode = $kriteria->kode_kriteria;
                $nilai = 0;
                
                if ($kode == 'C1') {
                    $nilai = Pengiriman::where('status', 'selesai')
                        ->whereHas('pengajuan', fn($q) => $q->where('driver_id', $driver->driver_id))
                        ->count();
                } 
                elseif ($kode == 'C2') {
                    $totalPengiriman = Pengiriman::whereHas('pengajuan', fn($q) => $q->where('driver_id', $driver->driver_id))->count();
                    $totalUpload = BuktiPengiriman::whereHas('pengiriman.pengajuan', fn($q) => $q->where('driver_id', $driver->driver_id))->count();
                    $nilai = $totalPengiriman > 0 ? round(($totalUpload / $totalPengiriman) * 100) : 0;
                } 
                elseif ($kode == 'C3') {
                    $nilai = Pengiriman::where('status', 'proses')
                        ->whereHas('pengajuan', fn($q) => $q->where('driver_id', $driver->driver_id))
                        ->count();
                    
                    if ($nilai == 0) {
                        $nilai = 1;
                    } elseif ($nilai == 1) {
                        $nilai = 2;
                    } elseif ($nilai == 2) {
                        $nilai = 3;
                    } elseif ($nilai == 3) {
                        $nilai = 4;
                    } else {
                        $nilai = 5;
                    }
                } 
                else {
                    $penilaian = $penilaians->get($driver->driver_id . '_' . $kriteria->kriteria_id);
                    $nilai = $penilaian->nilai ?? 0;
                    
                    if ($kriteria->jenis == 'cost' && $nilai == 0) {
                        $nilai = 1;
                    }
                }
                
                $nilaiKriteria[$kriteria->kriteria_id] = $nilai;
                $semuaNilai[$kriteria->kriteria_id][] = $nilai;
            }
            
            $dataDriver[$driver->driver_id] = [
                'nama' => $driver->nama,
                'email' => $driver->user->email ?? '-',
                'no_telp' => $driver->nomor_kontak,
                'nilai_kriteria' => $nilaiKriteria,
            ];
        }
        
        // Hitung max/min setiap kriteria
        $maxMin = [];
        foreach ($kriterias as $kriteria) {
            $values = $semuaNilai[$kriteria->kriteria_id] ?? [1];
            
            if ($kriteria->jenis == 'benefit') {
                $maxMin[$kriteria->kriteria_id] = max($values) ?: 1;
            } else {
                $maxMin[$kriteria->kriteria_id] = min($values) ?: 1;
            }
        }
        
        // Hitung total bobot
        $totalBobot = 0;
        foreach ($kriterias as $kriteria) {
            $totalBobot += (float)$kriteria->bobot;
        }
        
        // Hitung ranking
        $ranking = [];
        foreach ($drivers as $driver) {
            $data = $dataDriver[$driver->driver_id];
            $totalNilai = 0;
            $detailNilai = [];
            
            foreach ($kriterias as $kriteria) {
                $nilai = $data['nilai_kriteria'][$kriteria->kriteria_id] ?? 1;
                
                if ($kriteria->jenis == 'cost' && $nilai == 0) {
                    $nilai = 1;
                }
                
                // NORMALISASI NILAI
                if ($kriteria->jenis == 'benefit') {
                    $max = $maxMin[$kriteria->kriteria_id];
                    $norm = $max > 0 ? $nilai / $max : 1;
                } else {
                    $min = $maxMin[$kriteria->kriteria_id];
                    $norm = $nilai > 0 ? $min / $nilai : 1;
                }
                
                // NORMALISASI BOBOT (bobot / total_bobot)
                $bobotFloat = (float)$kriteria->bobot;
                $bobotNorm = $totalBobot > 0 ? $bobotFloat / $totalBobot : 0;
                $kontribusi = $norm * $bobotNorm;
                $totalNilai += $kontribusi;
                
                $detailNilai[$kriteria->kode_kriteria] = [
                    'nilai' => $nilai,
                    'norm' => round($norm, 4),
                    'bobot' => $kriteria->bobot,
                    'bobot_norm' => round($bobotNorm, 4),
                    'kontribusi' => round($kontribusi, 4)
                ];
            }
            
            $ranking[] = [
                'nama' => $data['nama'],
                'email' => $data['email'],
                'no_telp' => $data['no_telp'],
                'detail' => $detailNilai,
                'nilai' => round($totalNilai, 4),
            ];
        }
        
        // Urutkan dari tertinggi
        usort($ranking, fn($a, $b) => $b['nilai'] <=> $a['nilai']);
        
        // Shared ranking
        $result = [];
        $rank = 1;
        $prevNilai = null;
        $skip = 0;
        
        foreach ($ranking as $item) {
            if ($prevNilai !== null && $item['nilai'] < $prevNilai) {
                $rank += $skip + 1;
                $skip = 0;
            } elseif ($prevNilai !== null && $item['nilai'] == $prevNilai) {
                $skip++;
            }
            $item['peringkat'] = $rank;
            $result[] = $item;
            $prevNilai = $item['nilai'];
        }
        
        $ranking = $result;
        
        return view('admin.saw.ranking', compact('ranking', 'kriterias', 'totalBobot'));
    }
}