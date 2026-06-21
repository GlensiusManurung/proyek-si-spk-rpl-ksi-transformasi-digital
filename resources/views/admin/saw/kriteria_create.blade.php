@vite(['public/css/adminlte.css', 'public/js/adminlte.js'])
@extends('layoutadmin.dashboard')

@section('title', 'Tambah Kriteria')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5><i class="bi bi-plus-circle me-2"></i> Tambah Kriteria</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.saw.kriteria.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label>Kode Kriteria <span class="text-danger">*</span></label>
                            <input type="text" name="kode_kriteria" class="form-control @error('kode_kriteria') is-invalid @enderror" value="{{ old('kode_kriteria') }}" required>
                            @error('kode_kriteria') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <small>Contoh: C1, C2, C3</small>
                        </div>
                        
                        <div class="mb-3">
                            <label>Nama Kriteria <span class="text-danger">*</span></label>
                            <input type="text" name="nama_kriteria" class="form-control @error('nama_kriteria') is-invalid @enderror" value="{{ old('nama_kriteria') }}" required>
                            @error('nama_kriteria') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label>Jenis <span class="text-danger">*</span></label>
                            <select name="jenis" class="form-control @error('jenis') is-invalid @enderror" required>
                                <option value="benefit">Benefit (semakin besar semakin baik)</option>
                                <option value="cost">Cost (semakin kecil semakin baik)</option>
                            </select>
                            @error('jenis') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label>Bobot <span class="text-danger">*</span></label>
                            <input type="text" name="bobot" class="form-control @error('bobot') is-invalid @enderror" value="{{ old('bobot') }}" placeholder="contoh: 25 atau 0,25" required>
                            @error('bobot') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <small class="text-muted">Masukkan bobot (contoh: 25 atau 0,25)</small>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.saw.kriteria') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection