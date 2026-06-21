@vite(['resources/css/admin-saw.css', 'resources/js/admin-saw.js'])
@extends('layoutadmin.dashboard')

@section('title', 'Data Kriteria SAW')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5><i class="bi bi-table me-2"></i> Data Kriteria SAW</h5>
            <a href="{{ route('admin.saw.kriteria.create') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-circle"></i> Tambah Kriteria
            </a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama Kriteria</th>
                            <th>Jenis</th>
                            <th>Bobot</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kriterias as $k)
                        <tr>
                            <td><strong>{{ $k->kode_kriteria }}</strong></td>
                            <td>{{ $k->nama_kriteria }}</td>
                            <td class="text-center">
                                @if($k->jenis == 'benefit')
                                    <span class="badge bg-success">Benefit</span>
                                @else
                                    <span class="badge bg-danger">Cost</span>
                                @endif
                            </td>
                            <td class="text-center">{{ $k->bobot }}</td>
                            <td>
                                <a href="{{ route('admin.saw.kriteria.edit', $k->kriteria_id) }}" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('admin.saw.kriteria.delete', $k->kriteria_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="alert alert-info mt-3">
                <strong>Total Bobot: {{ $kriterias->sum('bobot') }}</strong>
            </div>
        </div>
    </div>
</div>
@endsection