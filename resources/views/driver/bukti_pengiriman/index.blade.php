
@extends('layoutdriver.dashboard')

@section('title', 'Bukti Pengiriman')

@push('styles')
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    @vite(['resources/css/bukti-pengiriman.css'])
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Pengiriman yang perlu upload bukti -->
            <div class="card">
                <div class="card-header">
                    <h5><i class="bi bi-upload me-2"></i> Upload Bukti Pengiriman</h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No Surat Jalan</th>
                                    <th>Mobil</th>
                                    <th>Tanggal Pengiriman</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pengirimans as $index => $pengiriman)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $pengiriman->nomor_surat_jalan }}</td>
                                    <td>{{ $pengiriman->pengajuan->mobil->no_plat ?? '-' }}<br>
                                        <small>{{ $pengiriman->pengajuan->mobil->jenis_mobil ?? '-' }}</small>
                                    </td>
                                    <td>{{ date('d/m/Y', strtotime($pengiriman->tanggal_pengiriman)) }}</td>
                                    <td>
                                        <a href="{{ route('driver.bukti-pengiriman.create', $pengiriman->pengiriman_id) }}" class="btn btn-primary btn-sm">
                                            <i class="bi bi-upload"></i> Upload Bukti
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <i class="bi bi-inbox fs-1 text-secondary"></i>
                                        <p class="mt-3">Tidak ada pengiriman yang perlu upload bukti</p>
                                        <p class="text-muted small">Pengiriman dengan status "Selesai" akan muncul di sini</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <!-- Riwayat Bukti yang sudah diupload -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5><i class="bi bi-clock-history me-2"></i> Riwayat Bukti Pengiriman</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="buktiTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>No Surat Jalan</th>
                                    <th>Tanggal Bukti</th>
                                    <th>Deskripsi</th>
                                    <th>Gambar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($buktis as $index => $bukti)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $bukti->pengiriman->nomor_surat_jalan ?? '-' }}</td>
                                    <td>{{ date('d/m/Y', strtotime($bukti->tanggal_bukti)) }}</td>
                                    <td>{{ $bukti->deskripsi ?? '-' }}</td>
                                    <td>
                                        <a href="{{ Storage::url($bukti->gambar) }}" target="_blank" class="btn btn-info btn-sm">
                                            <i class="bi bi-eye"></i> Lihat
                                        </a>
                                     </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <i class="bi bi-folder fs-1 text-secondary"></i>
                                        <p class="mt-3">Belum ada riwayat bukti pengiriman</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    @vite(['resources/js/bukti-pengiriman.js'])
@endpush