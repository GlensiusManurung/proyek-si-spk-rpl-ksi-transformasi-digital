   @vite(['public/css/adminlte.css', 'public/js/adminlte.js'])
   @vite(['resources/css/admin-customer.css', 'resources/js/admin-customer.js'])

@extends('layoutadmin.dashboard')

@section('title', 'Data Customer')



@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5><i class="bi bi-building me-2"></i> Data Customer</h5>
                    <a href="{{ route('admin.customers.create') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle"></i> Tambah Customer
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle"></i> {{ session('success') }}
                        </div>
                    @endif
                    
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="customerTable">
                            <thead>
                                <tr>
                                    <th width="50">No</th>
                                    <th>Nama Perusahaan</th>
                                    <th>Alamat</th>
                                    <th>Kontak</th>
                                    <th>Email</th>
                                    <th>PIC</th>
                                    <th width="100">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($customers as $index => $customer)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><strong>{{ $customer->nama_perusahaan }}</strong></td>
                                    <td>{{ Str::limit($customer->alamat, 50) }}</td>
                                    <td>{{ $customer->nomor_kontak }}</td>
                                    <td>{{ $customer->email ?? '-' }}</td>
                                    <td>{{ $customer->pic ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('admin.customers.edit', $customer->customer_id) }}" class="btn btn-warning btn-sm" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.customers.delete', $customer->customer_id) }}" method="POST" onsubmit="return confirm('Yakin hapus {{ $customer->nama_perusahaan }}?')" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <i class="bi bi-building fs-1 text-secondary"></i>
                                        <p class="mt-3 mb-0">Belum ada data customer</p>
                                        <a href="{{ route('admin.customers.create') }}" class="btn btn-primary btn-sm mt-3">
                                            <i class="bi bi-plus-circle"></i> Tambah Customer
                                        </a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

