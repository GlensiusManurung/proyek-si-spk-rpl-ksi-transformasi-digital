@vite(['public/css/adminlte.css', 'public/js/adminlte.js'])
@extends('layoutadmin.dashboard')

@section('title', 'Buat Pengiriman')

@push('styles')
    @vite(['resources/css/admin-pengiriman.css'])
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5><i class="bi bi-plus-circle me-2"></i> Buat Pengiriman</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.pengirimans.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label>Pilih Pengajuan yang Disetujui <span class="text-danger">*</span></label>
                            <select name="pengajuan_id" class="form-control @error('pengajuan_id') is-invalid @enderror" required>
                                <option value="">Pilih Pengajuan</option>
                                @foreach($pengajuans as $pengajuan)
                                    <option value="{{ $pengajuan->pengajuan_id }}" 
                                        {{-- Tandai yang tidak punya customer --}}
                                        @if(!$pengajuan->customer) style="color: red; background: #ffe0e0;" @endif
                                    >
                                        👤 {{ $pengajuan->driver->nama ?? '-' }} - 
                                        🚗 {{ $pengajuan->mobil->no_plat ?? '-' }} - 
                                        📅 {{ date('d/m/Y', strtotime($pengajuan->tanggal_pengajuan)) }}
                                        @if($pengajuan->customer)
                                            ✅ 🏢 {{ $pengajuan->customer->nama_perusahaan }}
                                        @else
                                            ❌ TANPA CUSTOMER (TIDAK BISA DIGUNAKAN)
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('pengajuan_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <small class="text-danger">⚠️ Hanya pilih pengajuan yang sudah ada ✅ CUSTOMER</small>
                        </div>
                        
                        <div class="mb-3">
                            <label>Tanggal Pengiriman <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_pengiriman" class="form-control @error('tanggal_pengiriman') is-invalid @enderror" value="{{ date('Y-m-d') }}" required>
                            @error('tanggal_pengiriman') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label>Deskripsi</label>
                            <textarea name="deskripsi" rows="3" class="form-control">{{ old('deskripsi') }}</textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label>Catatan</label>
                            <textarea name="catatan" rows="2" class="form-control">{{ old('catatan') }}</textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label>Gambar (Opsional)</label>
                            <input type="file" name="gambar" class="form-control" accept="image/*" onchange="previewGambar(this)">
                            <small class="text-muted">Format: JPG, JPEG, PNG (Max 2MB)</small>
                            <img id="preview-img" class="img-fluid mt-2" style="max-width: 200px; display: none;">
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.pengirimans.index') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function previewGambar(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#preview-img').attr('src', e.target.result).show();
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection

@push('scripts')
    @vite(['resources/js/admin-pengiriman.js'])
@endpush