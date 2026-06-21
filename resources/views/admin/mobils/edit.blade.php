@vite(['public/css/adminlte.css', 'public/js/adminlte.js'])
@extends('layoutadmin.dashboard')

@section('title', 'Edit Mobil')

@push('styles')
    @vite(['resources/css/admin-mobil.css'])
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5><i class="bi bi-pencil-square me-2"></i> Edit Mobil: {{ $mobil->no_plat }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.mobils.update', $mobil->mobil_id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label>No Plat <span class="text-danger">*</span></label>
                            <input type="text" name="no_plat" class="form-control @error('no_plat') is-invalid @enderror" value="{{ old('no_plat', $mobil->no_plat) }}" required>
                            @error('no_plat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Merk</label>
                                <input type="text" name="merk" class="form-control" value="{{ old('merk', $mobil->merk) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Jenis Mobil <span class="text-danger">*</span></label>
                                <input type="text" name="jenis_mobil" class="form-control @error('jenis_mobil') is-invalid @enderror" value="{{ old('jenis_mobil', $mobil->jenis_mobil) }}" required>
                                @error('jenis_mobil') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label>Pajak STNK</label>
                                <input type="date" name="pajak_stnk" class="form-control" value="{{ old('pajak_stnk', $mobil->pajak_stnk) }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Pajak Plat</label>
                                <input type="date" name="pajak_plat" class="form-control" value="{{ old('pajak_plat', $mobil->pajak_plat) }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>KIR</label>
                                <input type="date" name="kir" class="form-control" value="{{ old('kir', $mobil->kir) }}">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                                    <option value="aktif" {{ $mobil->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="perbaikan" {{ $mobil->status == 'perbaikan' ? 'selected' : '' }}>Perbaikan</option>
                                    <option value="nonaktif" {{ $mobil->status == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                                </select>
                                @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Keterangan</label>
                                <textarea name="keterangan" rows="1" class="form-control">{{ old('keterangan', $mobil->keterangan) }}</textarea>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.mobils.index') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    @vite(['resources/js/admin-mobil.js'])
@endpush