@extends('layoutdriver.dashboard')

@section('title', 'Pengiriman Saya')

@push('styles')
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <style>
        .badge-warning { background: #f39c12; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; }
        .badge-info { background: #00c0ef; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; }
        .badge-success { background: #00a65a; color: white; padding: 4px 8px; border-radius: 3px; font-size: 11px; }
        .btn-status { padding: 4px 10px; font-size: 11px; margin: 2px; }
        .status-form { display: inline-block; }
        .btn-dikirim { background: #00c0ef; color: white; border: none; }
        .btn-selesai { background: #00a65a; color: white; border: none; }
        .btn-status-sm { padding: 5px 12px; font-size: 12px; border-radius: 3px; cursor: pointer; }
        .info-box { padding: 15px; border-radius: 4px; }
        .bg-blue { background: #3c8dbc; }
        .bg-green { background: #00a65a; }
        .bg-yellow { background: #f39c12; }
        .alert-success { background: #d4edda; color: #155724; padding: 12px; border-radius: 4px; margin-bottom: 20px; }
        .alert-danger { background: #f8d7da; color: #721c24; padding: 12px; border-radius: 4px; margin-bottom: 20px; }
        .table th { background: #f9f9f9; }
        .tujuan-cell { max-width: 250px; }
    </style>
@endpush

@section('content')
<div class="container-fluid">

    

    <!-- CARD DAFTAR PENGIRIMAN -->
    <div class="card">
        <div class="card-header">
            <h5><i class="bi bi-truck me-2"></i> Daftar Pengiriman Saya</h5>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="pengirimanTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No Surat Jalan</th>
                            <th>Mobil</th>
                            <th>Tujuan</th>
                            <th>Tgl Pengiriman</th>
                            <th>Status</th>
                            <th>Update Status</th>
                            <th>Bukti</th>
                            <th>Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengirimans as $index => $pengiriman)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td><strong>{{ $pengiriman->nomor_surat_jalan }}</strong></td>
                            <td>
                                {{ $pengiriman->pengajuan->mobil->no_plat ?? '-' }}<br>
                                <small>{{ $pengiriman->pengajuan->mobil->jenis_mobil ?? '-' }}</small>
                            </td>
                            <td class="tujuan-cell">
                                @if($pengiriman->pengajuan->customer)
                                    <strong>{{ $pengiriman->pengajuan->customer->nama_perusahaan }}</strong><br>
                                    <small class="text-muted">
                                        <i class="bi bi-geo-alt"></i> {{ Str::limit($pengiriman->pengajuan->customer->alamat, 50) }}
                                    </small><br>
                                    <small><i class="bi bi-telephone"></i> {{ $pengiriman->pengajuan->customer->nomor_kontak }}</small>
                                @else
                                    <span class="text-warning">
                                        <i class="bi bi-exclamation-triangle"></i> Tujuan belum diisi
                                    </span>
                                @endif
                            </td>
                            <td>{{ date('d/m/Y', strtotime($pengiriman->tanggal_pengiriman)) }}</td>
                            <td>
                                @if($pengiriman->status == 'proses')
                                    <span class="badge-warning">Proses</span>
                                @elseif($pengiriman->status == 'dikirim')
                                    <span class="badge-info">Dikirim</span>
                                @else
                                    <span class="badge-success">Selesai</span>
                                @endif
                            </td>
                            <td>
                                @if($pengiriman->status == 'proses')
                                    <form action="{{ route('driver.pengiriman.update-status', $pengiriman->pengiriman_id) }}" method="POST" class="status-form">
                                        @csrf
                                        <input type="hidden" name="status" value="dikirim">
                                        <button type="submit" class="btn btn-status btn-dikirim btn-status-sm" onclick="return confirm('Mulai pengiriman? Status akan berubah menjadi DIKIRIM')">
                                            <i class="bi bi-truck"></i> Mulai Kirim
                                        </button>
                                    </form>
                                @elseif($pengiriman->status == 'dikirim')
                                    <form action="{{ route('driver.pengiriman.update-status', $pengiriman->pengiriman_id) }}" method="POST" class="status-form">
                                        @csrf
                                        <input type="hidden" name="status" value="selesai">
                                        <button type="submit" class="btn btn-status btn-selesai btn-status-sm" onclick="return confirm('Selesaikan pengiriman? Status akan berubah menjadi SELESAI')">
                                            <i class="bi bi-check-circle"></i> Selesai
                                        </button>
                                    </form>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($pengiriman->bukti)
                                    <a href="{{ Storage::url($pengiriman->bukti->gambar) }}" target="_blank" class="btn btn-info btn-sm">Lihat</a>
                                @elseif($pengiriman->status == 'dikirim')
                                    <a href="{{ route('driver.bukti-pengiriman.create', $pengiriman->pengiriman_id) }}" class="btn btn-primary btn-sm">Upload</a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('driver.pengiriman-saya.detail', $pengiriman->pengiriman_id) }}" class="btn btn-info btn-sm">Detail</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-5">
                                <i class="bi bi-inbox fs-1 text-secondary"></i>
                                <p class="mt-3">Belum ada pengiriman</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#pengirimanTable').DataTable({
                language: { url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json' },
                pageLength: 10,
                order: [[0, 'desc']],
                columnDefs: [
                    { orderable: false, targets: [6, 7, 8] }
                ]
            });
        });
    </script>
@endpush