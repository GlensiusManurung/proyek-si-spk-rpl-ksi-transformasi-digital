@extends('layoutdriver.dashboard')

@section('title', 'Riwayat Pengiriman')

@push('styles')
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <style>
        .card { margin-bottom: 20px; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .card-header { background: #fff; border-bottom: 1px solid #e5e5e5; padding: 15px 20px; }
        .card-header h5 { margin: 0; font-size: 16px; font-weight: 600; }
        .table th { background: #f9f9f9; }
        .info-box { background: #fff; padding: 20px; border-radius: 4px; text-align: center; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .info-box h3 { margin: 0; font-size: 28px; font-weight: 600; }
        .info-box p { margin: 0; color: #777; }
        .bg-blue { background: #3c8dbc; color: white; }
        .bg-green { background: #00a65a; color: white; }
        .alert { padding: 12px 15px; border-radius: 4px; margin-bottom: 20px; }
        .alert-success { background: #dff0d8; color: #3c763d; }
        .alert-danger { background: #f2dede; color: #a94442; }
    </style>
@endpush

@section('content')
<div class="container-fluid">
   

    <div class="card">
        <div class="card-header">
            <h5><i class="bi bi-clock-history me-2"></i> Riwayat Pengiriman Selesai</h5>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="riwayatTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No Surat Jalan</th>
                            <th>Mobil</th>
                            <th>Tgl Pengiriman</th>
                            <th>Tgl Selesai</th>
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
                            <td>{{ date('d/m/Y', strtotime($pengiriman->tanggal_pengiriman)) }}</td>
                            <td>{{ $pengiriman->updated_at ? date('d/m/Y H:i', strtotime($pengiriman->updated_at)) : '-' }}</td>
                            <td>
                                @if($pengiriman->bukti)
                                    <a href="{{ Storage::url($pengiriman->bukti->gambar) }}" target="_blank" class="btn btn-info btn-sm">
                                        <i class="bi bi-eye"></i> Lihat
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                             </td>
                            <td>
                                <a href="{{ route('driver.pengiriman-saya.detail', $pengiriman->pengiriman_id) }}" class="btn btn-info btn-sm">
                                    <i class="bi bi-eye"></i> Detail
                                </a>
                             </td>
                         </tr>
                        @empty
                         <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="bi bi-inbox fs-1 text-secondary"></i>
                                <p class="mt-3">Belum ada riwayat pengiriman selesai</p>
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
            $('#riwayatTable').DataTable({
                language: { url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json' },
                pageLength: 10,
                order: [[0, 'desc']]
            });
        });
    </script>
@endpush