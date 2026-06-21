@vite(['public/css/adminlte.css', 'public/js/adminlte.js'])
@extends('layoutadmin.dashboard')

@section('title', 'Edit Customer')

@push('styles')
    @vite(['resources/css/admin-customer.css'])
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5><i class="bi bi-pencil-square me-2"></i> Edit Customer: {{ $customer->nama_perusahaan }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.customers.update', $customer->customer_id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label>Nama Perusahaan <span class="text-danger">*</span></label>
                            <input type="text" name="nama_perusahaan" class="form-control @error('nama_perusahaan') is-invalid @enderror" value="{{ old('nama_perusahaan', $customer->nama_perusahaan) }}" required>
                            @error('nama_perusahaan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label>Alamat <span class="text-danger">*</span></label>
                            <textarea name="alamat" rows="3" class="form-control @error('alamat') is-invalid @enderror" required>{{ old('alamat', $customer->alamat) }}</textarea>
                            @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Nomor Kontak <span class="text-danger">*</span></label>
                                <input type="text" name="nomor_kontak" class="form-control @error('nomor_kontak') is-invalid @enderror" value="{{ old('nomor_kontak', $customer->nomor_kontak) }}" required>
                                @error('nomor_kontak') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $customer->email) }}">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>PIC (Person In Charge)</label>
                                <input type="text" name="pic" class="form-control" value="{{ old('pic', $customer->pic) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Keterangan</label>
                                <textarea name="keterangan" rows="1" class="form-control">{{ old('keterangan', $customer->keterangan) }}</textarea>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.customers.index') }}" class="btn btn-secondary">Kembali</a>
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
    @vite(['resources/js/admin-customer.js'])
@endpush