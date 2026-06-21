@vite(['public/css/adminlte.css', 'public/js/adminlte.js'])
@extends('layoutadmin.dashboard')

@section('title', 'Tambah Mobil')

@push('styles')
    @vite(['resources/css/admin-mobil.css'])
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5><i class="bi bi-plus-circle me-2"></i> Tambah Mobil</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.mobils.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label>No Plat <span class="text-danger">*</span></label>
                            <input type="text" name="no_plat" class="form-control @error('no_plat') is-invalid @enderror" value="{{ old('no_plat') }}" required>
                            @error('no_plat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Merk</label>
                                <input type="text" name="merk" class="form-control" value="{{ old('merk') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Jenis Mobil <span class="text-danger">*</span></label>
                                <input type="text" name="jenis_mobil" class="form-control @error('jenis_mobil') is-invalid @enderror" value="{{ old('jenis_mobil') }}" required>
                                @error('jenis_mobil') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label>Pajak STNK</label>
                                <input type="date" name="pajak_stnk" class="form-control" value="{{ old('pajak_stnk') }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Pajak Plat</label>
                                <input type="date" name="pajak_plat" class="form-control" value="{{ old('pajak_plat') }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>KIR</label>
                                <input type="date" name="kir" class="form-control" value="{{ old('kir') }}">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                                    <option value="aktif">Aktif</option>
                                    <option value="perbaikan">Perbaikan</option>
                                    <option value="nonaktif">Nonaktif</option>
                                </select>
                                @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Keterangan</label>
                                <textarea name="keterangan" rows="1" class="form-control">{{ old('keterangan') }}</textarea>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.mobils.index') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
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