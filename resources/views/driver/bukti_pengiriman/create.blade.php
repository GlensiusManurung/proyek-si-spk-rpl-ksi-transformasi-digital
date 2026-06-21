@extends('layoutdriver.dashboard')

@section('title', 'Upload Bukti Pengiriman')

@push('styles')
    @vite(['resources/css/bukti-pengiriman.css'])
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5><i class="bi bi-upload me-2"></i> Upload Bukti Pengiriman</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('driver.bukti-pengiriman.store', $pengiriman->pengiriman_id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label>No Surat Jalan</label>
                            <input type="text" class="form-control" value="{{ $pengiriman->nomor_surat_jalan }}" disabled>
                        </div>
                        
                        <div class="mb-3">
                            <label>Driver</label>
                            <input type="text" class="form-control" value="{{ Auth::user()->nama }}" disabled>
                        </div>
                        
                        <div class="mb-3">
                            <label>Mobil</label>
                            <input type="text" class="form-control" value="{{ $pengiriman->pengajuan->mobil->no_plat ?? '-' }} - {{ $pengiriman->pengajuan->mobil->jenis_mobil ?? '-' }}" disabled>
                        </div>
                        
                        <div class="mb-3">
                            <label>Tanggal Bukti</label>
                            <input type="text" class="form-control" value="{{ date('d/m/Y') }}" disabled>
                        </div>
                        
                        <div class="mb-3">
                            <label>Deskripsi</label>
                            <textarea name="deskripsi" rows="3" class="form-control" placeholder="Contoh: Barang telah diterima oleh customer ..."></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label>Foto Bukti <span class="text-danger">*</span></label>
                            <input type="file" name="gambar" class="form-control @error('gambar') is-invalid @enderror" accept="image/*" onchange="previewImage(this)" required>
                            <small class="text-muted">Format: JPG, JPEG, PNG (Max 2MB)</small>
                            @error('gambar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <img id="preview-img" class="img-fluid mt-2" style="max-width: 200px; display: none;">
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('driver.bukti-pengiriman.index') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Upload Bukti
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    @vite(['resources/js/bukti-pengiriman.js'])
@endpush