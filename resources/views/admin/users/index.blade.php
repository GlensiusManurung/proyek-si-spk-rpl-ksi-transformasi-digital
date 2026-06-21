 @vite(['public/css/adminlte.css', 'public/js/adminlte.js'])
 @vite(['resources/css/admin-users.css', 'resources/js/admin-users.js'])
@extends('layoutadmin.dashboard')

@section('title', 'Manajemen Users')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    @vite(['resources/css/admin-users.css'])
@endpush

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="container-fluid px-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                    <h5 class="mb-0">
                        <i class="bi bi-people-fill me-2"></i> Daftar Users
                    </h5>
                    <div class="d-flex gap-2">
                        <div class="input-group" style="width: 250px;">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" id="searchUser" class="form-control border-start-0" placeholder="Cari user...">
                        </div>
                        <select id="filterRole" class="form-select" style="width: 120px;">
                            <option value="all">Semua Role</option>
                            <option value="admin">Admin</option>
                            <option value="driver">Driver</option>
                        </select>
                        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle me-1"></i> Tambah User
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-container">
                        <table class="data-table" id="userTable">
                            <thead>
                                <tr>
                                    <th>Foto</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Bergabung</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                <tr>
                                    <td data-label="Foto">
                                        @if($user->avatar && Storage::disk('public')->exists($user->avatar))
                                            <img src="{{ Storage::url($user->avatar) }}" class="avatar-table" alt="{{ $user->nama }}">
                                        @else
                                            <div class="avatar-table-default">
                                                {{ substr($user->nama, 0, 1) }}
                                            </div>
                                        @endif
                                    </td>
                                    <td data-label="Nama"><strong>{{ $user->nama }}</strong></td>
                                    <td data-label="Email">{{ $user->email }}</td>
                                    <td data-label="Role">
                                        <span class="badge {{ $user->role == 'admin' ? 'badge-admin' : 'badge-driver' }}">
                                            <i class="bi {{ $user->role == 'admin' ? 'bi-shield-lock-fill' : 'bi-truck' }}"></i>
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td data-label="Status">
                                        <span class="badge {{ $user->is_online ? 'badge-online' : 'badge-offline' }}">
                                            <i class="bi {{ $user->is_online ? 'bi-circle-fill' : 'bi-circle' }}"></i>
                                            {{ $user->is_online ? 'Online' : 'Offline' }}
                                        </span>
                                    </td>
                                    <td data-label="Bergabung">
                                        <small>{{ $user->created_at->format('d/m/Y') }}</small>
                                    </td>
                                    <td data-label="Aksi">
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.users.edit', $user->user_id) }}" class="btn btn-warning" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <button type="button" class="btn btn-danger btn-delete" 
                                                    data-user-id="{{ $user->user_id }}"
                                                    data-user-name="{{ $user->nama }}"
                                                    data-delete-url="{{ route('admin.users.delete', $user->user_id) }}"
                                                    title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <i class="bi bi-people fs-1 text-secondary"></i>
                                        <p class="mt-2">Belum ada user terdaftar</p>
                                        <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">Tambah User</a>
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

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite(['resources/js/admin-users.js'])
@endpush