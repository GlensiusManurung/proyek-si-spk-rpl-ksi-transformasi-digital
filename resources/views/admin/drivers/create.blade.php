@vite(['public/css/adminlte.css', 'public/js/adminlte.js'])
@extends('layoutadmin.dashboard')

@section('title', 'Tambah Driver')

@push('styles')
    @vite(['resources/css/admin-driver.css'])
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5><i class="bi bi-person-plus-fill me-2"></i> Tambah Driver</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.drivers.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label">Akun Driver</label>
                            <select name="user_id" class="form-select @error('user_id') is-invalid @enderror" required>
                                <option value="">Pilih Akun Driver</option>
                                @foreach($availableUsers as $user)
                                    <option value="{{ $user->user_id }}" {{ old('user_id') == $user->user_id ? 'selected' : '' }}>
                                        {{ $user->nama }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" required>
                            @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">No SIM</label>
                                <input type="text" name="no_sim" class="form-control @error('no_sim') is-invalid @enderror" value="{{ old('no_sim') }}" required>
                                @error('no_sim') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">NIK</label>
                                <input type="text" name="nik" class="form-control @error('nik') is-invalid @enderror" value="{{ old('nik') }}" required>
                                @error('nik') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nomor Kontak</label>
                                <input type="text" name="nomor_kontak" class="form-control @error('nomor_kontak') is-invalid @enderror" value="{{ old('nomor_kontak') }}" required>
                                @error('nomor_kontak') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">No Rekening (Opsional)</label>
                                <input type="text" name="no_rek" class="form-control" value="{{ old('no_rek') }}">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Alamat (Opsional)</label>
                            <textarea name="alamat" rows="2" class="form-control">{{ old('alamat') }}</textarea>
                        </div>
                        

<div class="col-md-6 mb-3">
    <label>Status <span class="text-danger">*</span></label>
    <select name="status" class="form-control @error('status') is-invalid @enderror" required>
        <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
        <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
    </select>
    @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.drivers.index') }}" class="btn btn-secondary">Kembali</a>
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
    @vite(['resources/js/admin-driver.js'])
@endpush