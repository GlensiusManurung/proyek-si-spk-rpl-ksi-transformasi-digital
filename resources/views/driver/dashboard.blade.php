
@extends('layoutdriver.dashboard')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    
    <!-- Welcome Section -->
    <div class="welcome-card">
        <h3>Selamat Datang, {{ Auth::user()->nama }}!</h3>
        <p>Anda login sebagai <strong>Driver</strong> di sistem Optimasi Pengiriman.</p>
    </div>

    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-info">
                <h3>{{ $totalDeliveries ?? 0 }}</h3>
                <p>Total Pengiriman</p>
            </div>
            <div class="stat-icon">
                <i class="bi bi-box-seam"></i>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-info">
                <h3>{{ $completedDeliveries ?? 0 }}</h3>
                <p>Selesai</p>
            </div>
            <div class="stat-icon">
                <i class="bi bi-check-circle"></i>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-info">
                <h3>{{ $pendingDeliveries ?? 0 }}</h3>
                <p>Pending</p>
            </div>
            <div class="stat-icon">
                <i class="bi bi-clock-history"></i>
            </div>
        </div>
    </div>

    <!-- Menu Cepat -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Menu Cepat</h3>
        </div>
        <div class="card-body">
            <div class="quick-menu">
                <a href="{{ url('/driver/pengiriman') }}" class="quick-btn">
                    <i class="bi bi-box-seam"></i>
                    <span>Lihat Pengiriman</span>
                </a>
                <a href="{{ url('/driver/riwayat') }}" class="quick-btn">
                    <i class="bi bi-clock-history"></i>
                    <span>Riwayat</span>
                </a>
                <a href="{{ route('driver.profile') }}" class="quick-btn">
                    <i class="bi bi-person-circle"></i>
                    <span>Profile Saya</span>
                </a>
            </div>
        </div>
    </div>

</div>

<style>
.welcome-card {
    background: linear-gradient(135deg, #281c96 0%, #060874ab 100%);
    color: white;
    border-radius: 10px;
    padding: 25px;
    margin-bottom: 25px;
}
.welcome-card h3 {
    margin-bottom: 10px;
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
    color: #333;
}
.stat-info p {
    color: #6c757d;
    margin: 0;
}
.stat-icon {
    font-size: 3rem;
    opacity: 0.3;
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
    background: #092510;
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