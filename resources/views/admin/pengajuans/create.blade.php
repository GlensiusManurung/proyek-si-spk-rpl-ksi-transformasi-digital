@vite(['public/css/adminlte.css', 'public/js/adminlte.js'])
@extends('layoutadmin.dashboard')

@section('title', 'Tambah Pengajuan')

@push('styles')
    @vite(['resources/css/admin-pengajuan.css'])
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5><i class="bi bi-plus-circle me-2"></i> Tambah Pengajuan</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.pengajuans.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- DRIVER -->
                        <div class="mb-3">
                            <label>Driver <span class="text-danger">*</span></label>
                            <select name="driver_id" class="form-control @error('driver_id') is-invalid @enderror" required>
                                <option value="">Pilih Driver</option>
                                @foreach($drivers as $driver)
                                    <option value="{{ $driver->driver_id }}" {{ old('driver_id') == $driver->driver_id ? 'selected' : '' }}>
                                        {{ $driver->nama }} - {{ $driver->no_sim }}
                                    </option>
                                @endforeach
                            </select>
                            @error('driver_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <!-- MOBIL -->
                        <div class="mb-3">
                            <label>Mobil <span class="text-danger">*</span></label>
                            <select name="mobil_id" class="form-control @error('mobil_id') is-invalid @enderror" required>
                                <option value="">Pilih Mobil</option>
                                @foreach($mobils as $mobil)
                                    <option value="{{ $mobil->mobil_id }}" {{ old('mobil_id') == $mobil->mobil_id ? 'selected' : '' }}>
                                        {{ $mobil->no_plat }} - {{ $mobil->jenis_mobil }}
                                    </option>
                                @endforeach
                            </select>
                            @error('mobil_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <!-- CUSTOMER (TAMBAHKAN INI) -->
                        <div class="mb-3">
                            <label>Customer / Tujuan <span class="text-danger">*</span></label>
                            <select name="customer_id" class="form-control @error('customer_id') is-invalid @enderror" required>
                                <option value="">Pilih Customer</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->customer_id }}" {{ old('customer_id') == $customer->customer_id ? 'selected' : '' }}>
                                        {{ $customer->nama_perusahaan }} - {{ Str::limit($customer->alamat, 40) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('customer_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <small class="text-muted">Alamat customer akan menjadi tujuan pengiriman</small>
                        </div>
                        
                        <!-- TANGGAL PENGAJUAN -->
                        <div class="mb-3">
                            <label>Tanggal Pengajuan <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_pengajuan" class="form-control @error('tanggal_pengajuan') is-invalid @enderror" value="{{ date('Y-m-d') }}" required>
                            @error('tanggal_pengajuan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <!-- BUKTI STRUK -->
                        <div class="mb-3">
                            <label>Bukti Struk (Opsional)</label>
                            <input type="file" name="bukti_struk" class="form-control" accept="image/*,application/pdf" onchange="previewStruk(this)">
                            <small class="text-muted">Format: JPG, PNG, PDF (Max 2MB)</small>
                            <img id="preview-img" class="img-fluid mt-2" style="max-width: 200px; display: none;">
                        </div>
                        
                        <!-- KETERANGAN -->
                        <div class="mb-3">
                            <label>Keterangan</label>
                            <textarea name="keterangan" rows="3" class="form-control">{{ old('keterangan') }}</textarea>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.pengajuans.index') }}" class="btn btn-secondary">Kembali</a>
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
    <script>
        function previewStruk(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#preview-img').attr('src', e.target.result).show();
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
    @vite(['resources/js/admin-pengajuan.js'])
@endpush