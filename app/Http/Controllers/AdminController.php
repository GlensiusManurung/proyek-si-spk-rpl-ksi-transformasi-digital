<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Driver;
use App\Models\Mobil;
use App\Models\Customer;
use App\Models\Pengajuan;
use App\Models\Pengiriman;
use App\Models\BuktiPengiriman;
use App\Models\Kriteria;
use App\Models\Penilaian;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }
        
        // Cek apakah role-nya admin
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Anda tidak memiliki akses ke halaman ini');
        }
        
        // ========== STATISTIK UTAMA ==========
        $totalDrivers = Driver::count();
        $totalMobils = Mobil::count();
        $totalCustomers = Customer::count();
        $totalUsers = User::whereIn('role', ['admin', 'driver'])->count();
        
        // ========== STATISTIK PENGAJUAN ==========
        $totalPengajuan = Pengajuan::count();
        $pengajuanPending = Pengajuan::where('status', 'pending')->count();
        $pengajuanDisetujui = Pengajuan::where('status', 'disetujui')->count();
        $pengajuanDitolak = Pengajuan::where('status', 'ditolak')->count();
        
        // ========== STATISTIK PENGIRIMAN ==========
        $totalPengiriman = Pengiriman::count();
        $pengirimanProses = Pengiriman::where('status', 'proses')->count();
        $pengirimanDikirim = Pengiriman::where('status', 'dikirim')->count();
        $pengirimanSelesai = Pengiriman::where('status', 'selesai')->count();
        
        // ========== DATA CHART PENGAJUAN PER BULAN ==========
        $pengajuanPerBulan = Pengajuan::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
            ->whereYear('created_at', date('Y'))
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();
        
        $bulanLabels = [];
        $bulanData = [];
        for ($i = 1; $i <= 12; $i++) {
            $bulanLabels[] = $this->bulanIndonesia($i);
            $found = $pengajuanPerBulan->where('bulan', $i)->first();
            $bulanData[] = $found ? $found->total : 0;
        }
        
// Di method dashboard(), tambahkan data untuk chart pengiriman per bulan
$pengirimanPerBulan = Pengiriman::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total')
    ->whereYear('created_at', date('Y'))
    ->groupBy('bulan')
    ->orderBy('bulan')
    ->get();

$pengirimanBulanLabels = [];
$pengirimanBulanData = [];
for ($i = 1; $i <= 12; $i++) {
    $pengirimanBulanLabels[] = $this->bulanIndonesia($i);
    $found = $pengirimanPerBulan->where('bulan', $i)->first();
    $pengirimanBulanData[] = $found ? $found->total : 0;
}

        // ========== DATA STATUS PENGIRIMAN UNTUK PIE CHART ==========
        $statusPengiriman = [
            'Proses' => $pengirimanProses,
            'Dikirim' => $pengirimanDikirim,
            'Selesai' => $pengirimanSelesai,
        ];
        
        // ========== RANKING 5 DRIVER TERBAIK (SAW) ==========
        $ranking = $this->hitungRankingSAW();
        
       return view('admin.dashboard', compact(
    'totalDrivers', 'totalMobils', 'totalCustomers', 'totalUsers',
    'totalPengajuan', 'pengajuanPending', 'pengajuanDisetujui', 'pengajuanDitolak',
    'totalPengiriman', 'pengirimanProses', 'pengirimanDikirim', 'pengirimanSelesai',
    'bulanLabels', 'bulanData', 'statusPengiriman', 'ranking',
    'pengirimanBulanLabels', 'pengirimanBulanData'  
));
    }
    
    private function bulanIndonesia($bulan)
    {
        $namaBulan = [
            1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun',
            7 => 'Jul', 8 => 'Agu', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
        ];
        return $namaBulan[$bulan];
    }
    
    private function hitungRankingSAW()
{
    $drivers = Driver::with('user')->get();
    $kriterias = Kriteria::all();
    $penilaians = Penilaian::all()->keyBy(function($item) {
        return $item->driver_id . '_' . $item->kriteria_id;
    });
    
    if ($drivers->isEmpty()) {
        return [];
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
            } 
            else {
                $penilaian = $penilaians->get($driver->driver_id . '_' . $kriteria->kriteria_id);
                $nilai = $penilaian->nilai ?? 0;
            }
            
            $nilaiKriteria[$kriteria->kriteria_id] = $nilai;
            $semuaNilai[$kriteria->kriteria_id][] = $nilai;
        }
        
        $dataDriver[$driver->driver_id] = [
            'nama' => $driver->nama,
            'nilai_kriteria' => $nilaiKriteria,
        ];
    }
    
    // Hitung max/min setiap kriteria
    $maxMin = [];
    foreach ($kriterias as $kriteria) {
        $values = $semuaNilai[$kriteria->kriteria_id] ?? [0];
        if ($kriteria->jenis == 'benefit') {
            $maxMin[$kriteria->kriteria_id] = max($values) ?: 1;
        } else {
            $maxMin[$kriteria->kriteria_id] = min($values) ?: 1; // Ubah default jadi 1
        }
    }
    
    // Hitung total bobot
    $totalBobot = $kriterias->sum('bobot');
    
    // Hitung ranking
    $ranking = [];
    foreach ($drivers as $driver) {
        $totalNilai = 0;
        $detail = [];
        
        foreach ($kriterias as $kriteria) {
            $nilai = $dataDriver[$driver->driver_id]['nilai_kriteria'][$kriteria->kriteria_id] ?? 0;
            
            // Pastikan nilai tidak 0 untuk cost
            if ($kriteria->jenis == 'cost' && $nilai == 0) {
                $nilai = 1;
            }
            
            // Normalisasi nilai
            if ($kriteria->jenis == 'benefit') {
                $max = $maxMin[$kriteria->kriteria_id];
                $norm = $max > 0 ? $nilai / $max : 1;
            } else {
                $min = $maxMin[$kriteria->kriteria_id];
                $norm = $nilai > 0 ? $min / $nilai : 1;
            }
            
            // Normalisasi bobot (bobot / total_bobot)
            $bobotNorm = $totalBobot > 0 ? $kriteria->bobot / $totalBobot : 0;
            $kontribusi = $norm * $bobotNorm;
            $totalNilai += $kontribusi;
        }
        
        $ranking[] = [
            'nama' => $dataDriver[$driver->driver_id]['nama'],
            'nilai' => round($totalNilai, 4), // KEMBALIKAN KE DESIMAL (tanpa dikali 100)
        ];
    }
    
    usort($ranking, fn($a, $b) => $b['nilai'] <=> $a['nilai']);
    
    return array_slice($ranking, 0, 5);
}
    
    // ==================== CRUD USERS ====================
    
    public function users()
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Akses ditolak');
        }
        
        $users = User::whereIn('role', ['admin', 'driver'])
                     ->orderBy('created_at', 'desc')
                     ->get();
        
        return view('admin.users.index', compact('users'));
    }
    
    public function createUser()
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Akses ditolak');
        }
        
        return view('admin.users.create');
    }
    
    public function storeUser(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Akses ditolak');
        }
        
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:admin,driver',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        $data = [
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_online' => false,
        ];
        
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatarName = time() . '_' . uniqid() . '.' . $avatar->getClientOriginalExtension();
            $avatar->storeAs('avatars', $avatarName, 'public');
            $data['avatar'] = 'avatars/' . $avatarName;
        }
        
        User::create($data);
        
        return redirect()->route('admin.users')
                         ->with('success', 'User berhasil ditambahkan');
    }
    
    public function editUser($id)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Akses ditolak');
        }
        
        $user = User::findOrFail($id);
        
        if ($user->role == 'superadmin') {
            return redirect()->route('admin.users')
                             ->with('error', 'Tidak dapat mengedit user superadmin');
        }
        
        return view('admin.users.edit', compact('user'));
    }
    
    public function updateUser(Request $request, $id)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'Akses ditolak');
        }
        
        $user = User::findOrFail($id);
        
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id . ',user_id',
            'role' => 'required|in:admin,driver',
            'password' => 'nullable|min:6|confirmed',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        $data = [
            'nama' => $request->nama,
            'email' => $request->email,
            'role' => $request->role,
        ];
        
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        
        if ($request->hasFile('avatar')) {
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            
            $avatar = $request->file('avatar');
            $avatarName = time() . '_' . uniqid() . '.' . $avatar->getClientOriginalExtension();
            $avatar->storeAs('avatars', $avatarName, 'public');
            $data['avatar'] = 'avatars/' . $avatarName;
        }
        
        $user->update($data);
        
        return redirect()->route('admin.users')
                         ->with('success', 'User berhasil diupdate');
    }
    
    public function deleteUser($id)
    {
        try {
            if (Auth::user()->role !== 'admin') {
                return response()->json(['error' => 'Akses ditolak'], 403);
            }
            
            $user = User::findOrFail($id);
            
            if ($user->role == 'superadmin') {
                return response()->json(['error' => 'Tidak dapat menghapus user superadmin'], 403);
            }
            
            if ($user->user_id == Auth::id()) {
                return response()->json(['error' => 'Tidak dapat menghapus akun sendiri'], 403);
            }
            
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            
            $user->delete();
            
            return response()->json([
                'success' => true, 
                'message' => 'User berhasil dihapus'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}