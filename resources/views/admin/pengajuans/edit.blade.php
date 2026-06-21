@vite(['public/css/adminlte.css', 'public/js/adminlte.js'])
@extends('layoutadmin.dashboard')

@section('title', 'Edit Pengajuan')

@push('styles')
    @vite(['resources/css/admin-pengajuan.css'])
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5><i class="bi bi-pencil-square me-2"></i> Edit Pengajuan</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.pengajuans.update', $pengajuan->pengajuan_id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label>Driver <span class="text-danger">*</span></label>
                            <select name="driver_id" class="form-control @error('driver_id') is-invalid @enderror" required>
                                <option value="">Pilih Driver</option>
                                @foreach($drivers as $driver)
                                    <option value="{{ $driver->driver_id }}" {{ $pengajuan->driver_id == $driver->driver_id ? 'selected' : '' }}>
                                        {{ $driver->nama }} - {{ $driver->no_sim }}
                                    </option>
                                @endforeach
                            </select>
                            @error('driver_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label>Mobil <span class="text-danger">*</span></label>
                            <select name="mobil_id" class="form-control @error('mobil_id') is-invalid @enderror" required>
                                <option value="">Pilih Mobil</option>
                                @foreach($mobils as $mobil)
                                    <option value="{{ $mobil->mobil_id }}" {{ $pengajuan->mobil_id == $mobil->mobil_id ? 'selected' : '' }}>
                                        {{ $mobil->no_plat }} - {{ $mobil->jenis_mobil }}
                                    </option>
                                @endforeach
                            </select>
                            @error('mobil_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label>Tanggal Pengajuan <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_pengajuan" class="form-control @error('tanggal_pengajuan') is-invalid @enderror" value="{{ old('tanggal_pengajuan', $pengajuan->tanggal_pengajuan) }}" required>
                            @error('tanggal_pengajuan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label>Bukti Struk</label>
                            @if($pengajuan->bukti_struk)
                                <div class="mb-2">
                                    <a href="{{ Storage::url($pengajuan->bukti_struk) }}" target="_blank" class="btn btn-sm btn-info">Lihat Struk</a>
                                </div>
                            @endif
                            <input type="file" name="bukti_struk" class="form-control" accept="image/*,application/pdf" onchange="previewStruk(this)">
                            <small class="text-muted">Kosongkan jika tidak ingin mengubah</small>
                            <img id="preview-img" class="img-fluid mt-2" style="max-width: 200px; display: none;">
                        </div>
                        
                        <div class="mb-3">
                            <label>Keterangan</label>
                            <textarea name="keterangan" rows="3" class="form-control">{{ old('keterangan', $pengajuan->keterangan) }}</textarea>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.pengajuans.index') }}" class="btn btn-secondary">Kembali</a>
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
    @vite(['resources/js/admin-pengajuan.js'])
@endpush