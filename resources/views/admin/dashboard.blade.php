@vite(['resources/css/admin-dashboard.css', 'resources/js/admin-dashboard.js'])
@vite(['public/css/adminlte.css', 'public/js/adminlte.js'])
@extends('layoutadmin.dashboard')

@section('title', 'Dashboard')



@section('content')
<div class="content-wrapper-custom">
    <div class="container-fluid">

        <!-- STATISTIK CARDS -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $totalDrivers ?? 0 }}</h3>
                        <p>Total Driver</p>
                    </div>
                    <div class="icon"><i class="bi bi-truck"></i></div>
                    <a href="{{ route('admin.drivers.index') }}" class="small-box-footer">More info <i class="bi bi-arrow-right-circle-fill ms-1"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $totalMobils ?? 0 }}</h3>
                        <p>Total Mobil</p>
                    </div>
                    <div class="icon"><i class="bi bi-car-front"></i></div>
                    <a href="{{ route('admin.mobils.index') }}" class="small-box-footer">More info <i class="bi bi-arrow-right-circle-fill ms-1"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $totalCustomers ?? 0 }}</h3>
                        <p>Total Customer</p>
                    </div>
                    <div class="icon"><i class="bi bi-person-plus-fill"></i></div>
                    <a href="{{ route('admin.customers.index') }}" class="small-box-footer" style="color: #1f2d3d !important;">More info <i class="bi bi-arrow-right-circle-fill ms-1"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $totalUsers ?? 0 }}</h3>
                        <p>Total Users</p>
                    </div>
                    <div class="icon"><i class="bi bi-people"></i></div>
                    <a href="{{ route('admin.users') }}" class="small-box-footer">More info <i class="bi bi-arrow-right-circle-fill ms-1"></i></a>
                </div>
            </div>
        </div>

        <!-- MAIN ROW -->
        <div class="row">
            <section class="col-lg-7">
                <div class="card card-adminlte">
                    <div class="card-header card-header-adminlte">
                        <h3 class="card-title-adminlte">
                            <i class="bi bi-pie-chart-fill me-1"></i> Pengajuan per Bulan
                        </h3>
                    </div>
                    <div class="card-body">
                        <canvas id="pengajuanAreaChart" 
                                data-labels='["Jan","Feb","Mar","Apr","Mei","Jun","Jul","Agu","Sep","Okt","Nov","Des"]'
                                data-data='{{ json_encode($bulanData ?? array_fill(0, 12, 0)) }}'
                                style="height: 300px; width: 100%;"></canvas>
                    </div>
                </div>

                <div class="row">
    <!-- Card 1: Nilai SAW Asli (Desimal) -->
    <div class="col-md-6">
        <div class="card card-adminlte">
            <div class="card-header card-header-adminlte">
                <h3 class="card-title-adminlte">
                    <i class="bi bi-clipboard-check me-1"></i> Top 5 Driver Terbaik (Nilai SAW)
                </h3>
            </div>
            <div class="card-body p-3">
                @if(isset($ranking) && count($ranking) > 0)
                    <ul class="todo-list">
                        @foreach($ranking as $index => $driver)
                        <li style="border-left-color: {{ $index == 0 ? '#dc3545' : ($index == 1 ? '#ffc107' : ($index == 2 ? '#28a745' : '#17a2b8')) }};">
                            <div class="d-flex align-items-center">
                                <span class="badge bg-secondary me-3 px-2 py-1 fs-6">{{ $index + 1 }}</span>
                                <span class="text fw-semibold">{{ $driver['nama'] }}</span>
                            </div>
                            <div class="tools">
                                <span class="badge bg-primary px-2 py-1 fs-6">{{ number_format($driver['nilai'], 4) }}</span>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                @else
                    <div class="text-center py-4 text-muted">Belum ada data driver</div>
                @endif
            </div>
        </div>
    </div>

    <!-- Card 2: Nilai SAW dalam Persen -->
    <div class="col-md-6">
        <div class="card card-adminlte">
            <div class="card-header card-header-adminlte">
                <h3 class="card-title-adminlte">
                    <i class="bi bi-pie-chart me-1"></i> Top 5 Driver Terbaik (Persen)
                </h3>
            </div>
            <div class="card-body p-3">
                @if(isset($ranking) && count($ranking) > 0)
                    <ul class="todo-list">
                        @foreach($ranking as $index => $driver)
                        <li style="border-left-color: {{ $index == 0 ? '#dc3545' : ($index == 1 ? '#ffc107' : ($index == 2 ? '#28a745' : '#17a2b8')) }};">
                            <div class="d-flex align-items-center">
                                <span class="badge bg-secondary me-3 px-2 py-1 fs-6">{{ $index + 1 }}</span>
                                <span class="text fw-semibold">{{ $driver['nama'] }}</span>
                            </div>
                            <div class="tools">
                                <span class="badge bg-success px-2 py-1 fs-6">{{ number_format($driver['nilai'] * 100, 2) }}%</span>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                @else
                    <div class="text-center py-4 text-muted">Belum ada data driver</div>
                @endif
            </div>
        </div>
    </div>
</div>
            </section>

            <section class="col-lg-5">
                <div class="card card-adminlte card-solid-primary" style="background: linear-gradient(180deg, #007bff 0%, #0069d9 100%);">
                    <div class="card-header card-header-adminlte border-0">
                        <h3 class="card-title-adminlte text-white">
                            <i class="bi bi-truck"></i> Status Pengiriman
                        </h3>
                    </div>
                    <div class="card-body bg-white rounded-bottom p-4">
                        <div class="row">
                            <div class="col-7">
                                <canvas id="statusPieChart" 
                                        data-proses="{{ $pengirimanProses ?? 0 }}"
                                        data-dikirim="{{ $pengirimanDikirim ?? 0 }}"
                                        data-selesai="{{ $pengirimanSelesai ?? 0 }}"
                                        style="height: 180px; width: 100%;"></canvas>
                            </div>
                            <div class="col-5 d-flex flex-column justify-content-center">
                                <div class="mb-2">
                                    <i class="bi bi-circle-fill text-warning me-1"></i> Proses
                                    <span class="float-end fw-bold">{{ $pengirimanProses ?? 0 }}</span>
                                </div>
                                <div class="mb-2">
                                    <i class="bi bi-circle-fill text-info me-1"></i> Dikirim
                                    <span class="float-end fw-bold">{{ $pengirimanDikirim ?? 0 }}</span>
                                </div>
                                <div>
                                    <i class="bi bi-circle-fill text-success me-1"></i> Selesai
                                    <span class="float-end fw-bold">{{ $pengirimanSelesai ?? 0 }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card card-adminlte" style="background: #17a2b8; color: #fff;">
                    <div class="card-header card-header-adminlte border-0">
                        <h3 class="card-title-adminlte text-white">
                            <i class="bi bi-graph-up me-1"></i> Grafik Pengiriman ({{ date('Y') }})
                        </h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="p-3">
                            <canvas id="pengirimanLineChart" 
                                    data-labels='{!! json_encode($pengirimanBulanLabels ?? ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des']) !!}'
                                    data-data='{{ json_encode($pengirimanBulanData ?? array_fill(0, 12, 0)) }}'
                                    style="height: 200px; width: 100%;"></canvas>
                        </div>
                    </div>
                </div>

                <div class="card card-adminlte">
                    <div class="card-header card-header-adminlte">
                        <h3 class="card-title-adminlte">Ringkasan Pengajuan</h3>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-4 border-end">
                                <h4 class="fw-bold mb-0 text-success">{{ $pengajuanDisetujui ?? 0 }}</h4>
                                <small class="text-muted text-uppercase">Disetujui</small>
                            </div>
                            <div class="col-4 border-end">
                                <h4 class="fw-bold mb-0 text-warning">{{ $pengajuanPending ?? 0 }}</h4>
                                <small class="text-muted text-uppercase">Pending</small>
                            </div>
                            <div class="col-4">
                                <h4 class="fw-bold mb-0 text-danger">{{ $pengajuanDitolak ?? 0 }}</h4>
                                <small class="text-muted text-uppercase">Ditolak</small>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    