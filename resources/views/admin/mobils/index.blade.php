@vite(['public/css/adminlte.css', 'public/js/adminlte.js'])
   @vite(['resources/css/admin-mobil.css', 'resources/js/admin-mobil.js'])

@extends('layoutadmin.dashboard')

@section('title', 'Data Mobil')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5><i class="bi bi-car-front me-2"></i> Data Mobil</h5>
                    <div class="d-flex gap-2">
                        <div class="btn-group-export">
                            <a href="{{ route('admin.mobils.export-excel') }}" class="btn btn-success btn-sm">
                                <i class="bi bi-file-earmark-excel"></i> Excel
                            </a>
                            <a href="{{ route('admin.mobils.export-pdf') }}" class="btn btn-danger btn-sm">
                                <i class="bi bi-file-earmark-pdf"></i> PDF
                            </a>
                            <a href="{{ route('admin.mobils.export-word') }}" class="btn btn-info btn-sm">
                                <i class="bi bi-file-earmark-word"></i> Word
                            </a>
                        </div>
                        <a href="{{ route('admin.mobils.create') }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-plus-circle"></i> Tambah Mobil
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle"></i> {{ session('success') }}
                        </div>
                    @endif
                    
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover" id="mobilTable" width="100%">
                            <thead>
                                <tr>
                                    <th width="50">No</th>
                                    <th>No Plat</th>
                                    <th>Merk</th>
                                    <th>Jenis Mobil</th>
                                    <th>Pajak STNK</th>
                                    <th>Pajak Plat</th>
                                    <th>KIR</th>
                                    <th width="100">Status</th>
                                    <th width="100">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($mobils as $index => $mobil)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><strong>{{ $mobil->no_plat }}</strong></td>
                                    <td>{{ $mobil->merk ?? '-' }}</td>
                                    <td>{{ $mobil->jenis_mobil }}</td>
                                    <td>{{ $mobil->pajak_stnk ? date('d/m/Y', strtotime($mobil->pajak_stnk)) : '-' }}</td>
                                    <td>{{ $mobil->pajak_plat ? date('d/m/Y', strtotime($mobil->pajak_plat)) : '-' }}</td>
                                    <td>{{ $mobil->kir ? date('d/m/Y', strtotime($mobil->kir)) : '-' }}</td>
                                    <td>
                                        @if($mobil->status == 'aktif')
                                            <span class="badge-aktif">Aktif</span>
                                        @elseif($mobil->status == 'perbaikan')
                                            <span class="badge-perbaikan">Perbaikan</span>
                                        @else
                                            <span class="badge-nonaktif">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.mobils.edit', $mobil->mobil_id) }}" class="btn btn-warning btn-sm" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.mobils.delete', $mobil->mobil_id) }}" method="POST" onsubmit="return confirm('Yakin hapus {{ $mobil->no_plat }}?')" style="display: inline;">
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
                                    <td colspan="9" class="text-center py-5">
                                        <i class="bi bi-car-front fs-1 text-secondary"></i>
                                        <p class="mt-3 mb-0">Belum ada data mobil</p>
                                        <a href="{{ route('admin.mobils.create') }}" class="btn btn-primary btn-sm mt-3">
                                            <i class="bi bi-plus-circle"></i> Tambah Mobil
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

