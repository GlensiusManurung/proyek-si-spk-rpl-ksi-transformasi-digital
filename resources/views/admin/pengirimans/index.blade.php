
   @vite(['resources/css/admin-pengiriman.css', 'resources/js/admin-pengiriman.js'])
@extends('layoutadmin.dashboard')

@section('title', 'Data Pengiriman')

@push('styles')
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    @vite(['resources/css/admin-pengiriman.css'])
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5><i class="bi bi-box-seam me-2"></i> Data Pengiriman</h5>
                    <div class="d-flex gap-2">
                        <div class="btn-group-export">
                            <a href="{{ route('admin.pengirimans.export-excel') }}" class="btn btn-success btn-sm">
                                <i class="bi bi-file-earmark-excel"></i> Excel
                            </a>
                            <a href="{{ route('admin.pengirimans.export-pdf') }}" class="btn btn-danger btn-sm">
                                <i class="bi bi-file-earmark-pdf"></i> PDF
                            </a>
                            <a href="{{ route('admin.pengirimans.export-word') }}" class="btn btn-info btn-sm">
                                <i class="bi bi-file-earmark-word"></i> Word
                            </a>
                        </div>
                        <a href="{{ route('admin.pengirimans.create') }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-plus-circle"></i> Buat Pengiriman
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle"></i> {{ session('success') }}
                        </div>
                    @endif
                    
                    @if(session('error'))
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
                        </div>
                    @endif
                    
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover" id="pengirimanTable" width="100%">
                            <thead>
                                <tr>
                                    <th width="50">No</th>
                                    <th>No Surat Jalan</th>
                                    <th>Driver</th>
                                    <th>Mobil</th>
                                    <th>Tgl Pengiriman</th>
                                    <th width="100">Status</th>
                                    <th>Deskripsi</th>
                                    <th width="120">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pengirimans as $index => $pengiriman)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><strong>{{ $pengiriman->nomor_surat_jalan }}</strong></td>
                                    <td>
                                        {{ $pengiriman->pengajuan->driver->nama ?? '-' }}<br>
                                        <small class="text-muted">{{ $pengiriman->pengajuan->driver->nomor_kontak ?? '-' }}</small>
                                    </td>
                                    <td>
                                        {{ $pengiriman->pengajuan->mobil->no_plat ?? '-' }}<br>
                                        <small class="text-muted">{{ $pengiriman->pengajuan->mobil->jenis_mobil ?? '-' }}</small>
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
                                    <td>{{ Str::limit($pengiriman->deskripsi ?? '-', 50) }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.pengirimans.edit', $pengiriman->pengiriman_id) }}" class="btn btn-warning btn-sm" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.pengirimans.delete', $pengiriman->pengiriman_id) }}" method="POST" onsubmit="return confirm('Yakin hapus pengiriman ini?')" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <i class="bi bi-box-seam fs-1 text-secondary"></i>
                                        <p class="mt-3 mb-0">Belum ada data pengiriman</p>
                                        <a href="{{ route('admin.pengirimans.create') }}" class="btn btn-primary btn-sm mt-3">
                                            <i class="bi bi-plus-circle"></i> Buat Pengiriman
                                        </a>
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
    @vite(['resources/js/admin-pengiriman.js'])
@endpush