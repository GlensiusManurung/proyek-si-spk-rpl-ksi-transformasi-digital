
   @vite(['resources/css/admin-driver.css', 'resources/js/admin-driver.js'])
@extends('layoutadmin.dashboard')

@section('title', 'Data Driver')



@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>
                        <i class="bi bi-truck me-2"></i> Data Driver
                    </h5>
                    <div class="card-tools">
                        <div class="btn-group-export">
                            <a href="{{ route('admin.drivers.export-excel') }}" class="btn btn-success btn-sm">
                                <i class="bi bi-file-earmark-excel"></i> Excel
                            </a>
                            <a href="{{ route('admin.drivers.export-pdf') }}" class="btn btn-danger btn-sm">
                                <i class="bi bi-file-earmark-pdf"></i> PDF
                            </a>
                            <a href="{{ route('admin.drivers.export-word') }}" class="btn btn-info btn-sm">
                                <i class="bi bi-file-earmark-word"></i> Word
                            </a>
                        </div>
                        <a href="{{ route('admin.drivers.create') }}" class="btn btn-primary btn-sm ms-2">
                            <i class="bi bi-plus-circle"></i> Tambah Driver
                        </a>
                    </div>
                </div>
                <div class="card-body">
                   {{-- ✅ ALERT SUCCESS --}}
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- ✅ ALERT ERROR --}}
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- ✅ VALIDASI ERROR (summary) --}}
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-x-circle-fill me-2"></i>
                            <strong>Terjadi kesalahan:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover" id="driverTable" width="100%">
                            <thead>
                                <tr>
                                    <th width="50">No</th>
                                    <th width="60">Foto</th>
                                    <th>Nama Driver</th>
                                    <th>No SIM</th>
                                    <th>NIK</th>
                                    <th>Kontak</th>
                                    <th>No Rekening</th>
                                    <th width="80">Status</th>
                                    <th width="120">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($drivers as $index => $driver)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        @if($driver->user && $driver->user->avatar)
                                            <img src="{{ Storage::url($driver->user->avatar) }}" class="driver-avatar">
                                        @else
                                            <div class="avatar-placeholder">
                                                {{ strtoupper(substr($driver->nama, 0, 1)) }}
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $driver->nama }}</strong><br>
                                        <small class="text-muted">{{ $driver->user->email ?? '-' }}</small>
                                    </td>
                                    <td>{{ $driver->no_sim }}</td>
                                    <td>{{ $driver->nik }}</td>
                                    <td>{{ $driver->nomor_kontak }}</td>
                                    <td>{{ $driver->no_rek ?? '-' }}</td>
                                    <td>
                                        @if($driver->status == 'aktif')
                                            <span class="badge badge-success">Aktif</span>
                                        @else
                                            <span class="badge badge-danger">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('admin.drivers.edit', $driver->driver_id) }}" class="btn btn-warning btn-sm" data-toggle="tooltip" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.drivers.delete', $driver->driver_id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm btn-delete" data-name="{{ $driver->nama }}" data-toggle="tooltip" title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

