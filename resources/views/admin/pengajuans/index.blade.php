

@vite(['resources/css/admin-pengajuan.css', 'resources/js/admin-pengajuan.js'])

@extends('layoutadmin.dashboard')

@section('title', 'Pengajuan')


@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5><i class="bi bi-file-text me-2"></i> Data Pengajuan</h5>
                    <a href="{{ route('admin.pengajuans.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle"></i> Tambah Pengajuan
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle"></i> {{ session('success') }}
                        </div>
                    @endif
                    
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="pengajuanTable">
                            <thead>
                                <tr>
                                    <th width="50">No</th>
                                    <th>Driver</th>
                                    <th>Mobil</th>
                                    <th>Tanggal Pengajuan</th>
                                    <th>Status</th>
                                    <th>Disetujui Oleh</th>
                                    <th width="150">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pengajuans as $index => $pengajuan)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <strong>{{ $pengajuan->driver->nama ?? '-' }}</strong><br>
                                        <small class="text-muted">{{ $pengajuan->driver->nomor_kontak ?? '-' }}</small>
                                    </td>
                                    <td>
                                        {{ $pengajuan->mobil->no_plat ?? '-' }}<br>
                                        <small class="text-muted">{{ $pengajuan->mobil->jenis_mobil ?? '-' }}</small>
                                    </td>
                                    <td>{{ date('d/m/Y', strtotime($pengajuan->tanggal_pengajuan)) }}</td>
                                    <td>
                                        @if($pengajuan->status == 'pending')
                                            <span class="badge badge-warning">Pending</span>
                                        @elseif($pengajuan->status == 'disetujui')
                                            <span class="badge badge-success">Disetujui</span>
                                        @else
                                            <span class="badge badge-danger">Ditolak</span>
                                        @endif
                                    </td>
                                    <td>{{ $pengajuan->disetujui_oleh ?? '-' }}</td>
                                    <td>
                                        @if($pengajuan->status == 'pending')
                                            <form action="{{ route('admin.pengajuans.approve', $pengajuan->pengajuan_id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm" title="Setujui">
                                                    <i class="bi bi-check-lg"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.pengajuans.reject', $pengajuan->pengajuan_id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm" title="Tolak" onclick="return confirm('Yakin menolak pengajuan ini?')">
                                                    <i class="bi bi-x-lg"></i>
                                                </button>
                                            </form>
                                        @endif
                                        
                                        <a href="{{ route('admin.pengajuans.edit', $pengajuan->pengajuan_id) }}" class="btn btn-warning btn-sm" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        
                                        <form action="{{ route('admin.pengajuans.delete', $pengajuan->pengajuan_id) }}" method="POST" onsubmit="return confirm('Yakin hapus pengajuan ini?')" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <i class="bi bi-file-text fs-1 text-secondary"></i>
                                        <p class="mt-3 mb-0">Belum ada data pengajuan</p>
                                        <a href="{{ route('admin.pengajuans.create') }}" class="btn btn-primary btn-sm mt-3">
                                            <i class="bi bi-plus-circle"></i> Tambah Pengajuan
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

