@extends('layouts.superadmin')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    
    <!-- Welcome Section -->
    <div class="welcome-card">
        <h3>Selamat Datang, {{ Auth::user()->nama }}!</h3>
        <p>Anda login sebagai <strong>{{ ucfirst(Auth::user()->role) }}</strong> di sistem SPK Optimasi Pengiriman.</p>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-info">
                <h3>{{ $totalUsers ?? 0 }}</h3>
                <p>Total Users</p>
                <a href="{{ route('superadmin.users') }}" class="stat-link">More info <i class="bi bi-arrow-right"></i></a>
            </div>
            <div class="stat-icon">
                <i class="bi bi-people"></i>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-info">
                <h3>{{ $totalDrivers ?? 0 }}</h3>
                <p>Total Driver</p>
                <a href="{{ url('/superadmin/driver') }}" class="stat-link">More info <i class="bi bi-arrow-right"></i></a>
            </div>
            <div class="stat-icon">
                <i class="bi bi-truck"></i>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-info">
                <h3>{{ $totalCustomers ?? 0 }}</h3>
                <p>Total Customer</p>
                <a href="{{ url('/superadmin/customer') }}" class="stat-link">More info <i class="bi bi-arrow-right"></i></a>
            </div>
            <div class="stat-icon">
                <i class="bi bi-people-fill"></i>
            </div>
        </div>
    </div>

    <!-- Recent Users Table -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Akun Terbaru</h3>
            <a href="{{ route('superadmin.create-akun') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle"></i> Tambah Akun
            </a>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentUsers ?? [] as $index => $user)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $user->nama }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->role == 'superadmin')
                                <span class="badge bg-danger">Superadmin</span>
                            @elseif($user->role == 'admin')
                                <span class="badge bg-warning">Admin</span>
                            @else
                                <span class="badge bg-info">Driver</span>
                            @endif
                        </td>
                        <td>{{ $user->created_at->diffForHumans() }}</td>
                        <td>
                            @if($user->role != 'superadmin')
                                <a href="{{ route('superadmin.edit-akun', $user->user_id) }}" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('superadmin.delete-akun', $user->user_id) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada data user</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Quick Menu -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Menu Cepat</h3>
        </div>
        <div class="card-body">
            <div class="quick-menu">
                <a href="{{ route('superadmin.create-akun') }}" class="quick-btn">
                    <i class="bi bi-person-plus"></i>
                    <span>Tambah Akun</span>
                </a>
                <a href="{{ url('/superadmin/driver') }}" class="quick-btn">
                    <i class="bi bi-truck"></i>
                    <span>Data Driver</span>
                </a>
                <a href="{{ url('/superadmin/mobil') }}" class="quick-btn">
                    <i class="bi bi-car-front"></i>
                    <span>Data Mobil</span>
                </a>
                <a href="{{ url('/superadmin/customer') }}" class="quick-btn">
                    <i class="bi bi-people-fill"></i>
                    <span>Data Customer</span>
                </a>
            </div>
        </div>
    </div>

</div>

<style>
.welcome-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 10px;
    padding: 25px;
    margin-bottom: 25px;
}
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}
.stat-card {
    background: white;
    border-radius: 10px;
    padding: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    transition: transform 0.3s;
}
.stat-card:hover {
    transform: translateY(-5px);
}
.stat-info h3 {
    font-size: 2rem;
    margin-bottom: 5px;
}
.stat-info p {
    color: #6c757d;
    margin: 0;
}
.stat-icon {
    font-size: 3rem;
    opacity: 0.3;
}
.stat-link {
    display: inline-block;
    margin-top: 10px;
    color: #3498db;
    text-decoration: none;
    font-size: 0.85rem;
}
.quick-menu {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px;
}
.quick-btn {
    background: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: 20px;
    text-align: center;
    text-decoration: none;
    color: #333;
    transition: all 0.3s;
}
.quick-btn:hover {
    background: #3498db;
    color: white;
    transform: translateY(-3px);
}
.quick-btn i {
    font-size: 2rem;
    margin-bottom: 10px;
    display: block;
}
</style>
@endsection