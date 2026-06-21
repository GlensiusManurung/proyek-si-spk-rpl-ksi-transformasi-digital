@vite(['public/css/adminlte.css', 'public/js/adminlte.js'])
@extends('layoutadmin.dashboard')

@section('title', 'Edit Pengiriman')

@push('styles')
    @vite(['resources/css/admin-pengiriman.css'])
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5><i class="bi bi-pencil-square me-2"></i> Edit Pengiriman: {{ $pengiriman->nomor_surat_jalan }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.pengirimans.update', $pengiriman->pengiriman_id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label>Nomor Surat Jalan</label>
                            <input type="text" class="form-control" value="{{ $pengiriman->nomor_surat_jalan }}" disabled>
                        </div>
                        
                        <div class="mb-3">
                            <label>Driver</label>
                            <input type="text" class="form-control" value="{{ $pengiriman->pengajuan->driver->nama ?? '-' }}" disabled>
                        </div>
                        
                        <div class="mb-3">
                            <label>Mobil</label>
                            <input type="text" class="form-control" value="{{ $pengiriman->pengajuan->mobil->no_plat ?? '-' }}" disabled>
                        </div>
                        
                        <div class="mb-3">
                            <label>Tanggal Pengiriman <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_pengiriman" class="form-control @error('tanggal_pengiriman') is-invalid @enderror" value="{{ old('tanggal_pengiriman', $pengiriman->tanggal_pengiriman) }}" required>
                            @error('tanggal_pengiriman') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label>Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                                <option value="proses" {{ $pengiriman->status == 'proses' ? 'selected' : '' }}>Proses</option>
                                <option value="dikirim" {{ $pengiriman->status == 'dikirim' ? 'selected' : '' }}>Dikirim</option>
                                <option value="selesai" {{ $pengiriman->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                            @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label>Deskripsi</label>
                            <textarea name="deskripsi" rows="3" class="form-control">{{ old('deskripsi', $pengiriman->deskripsi) }}</textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label>Catatan</label>
                            <textarea name="catatan" rows="2" class="form-control">{{ old('catatan', $pengiriman->catatan) }}</textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label>Gambar</label>
                            @if($pengiriman->gambar)
                                <div class="mb-2">
                                    <img src="{{ Storage::url($pengiriman->gambar) }}" style="max-width: 150px; border-radius: 5px;">
                                </div>
                            @endif
                            <input type="file" name="gambar" class="form-control" accept="image/*" onchange="previewGambar(this)">
                            <small class="text-muted">Kosongkan jika tidak ingin mengubah</small>
                            <img id="preview-img" class="img-fluid mt-2" style="max-width: 200px; display: none;">
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.pengirimans.index') }}" class="btn btn-secondary">Kembali</a>
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
    @vite(['resources/js/admin-pengiriman.js'])
@endpush