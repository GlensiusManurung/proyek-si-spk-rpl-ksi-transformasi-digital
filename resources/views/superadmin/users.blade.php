@extends('layouts.superadmin')

@section('title', 'Manajemen User')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="bi bi-people"></i> Daftar Semua User
                    </h3>
                    <a href="{{ route('superadmin.create-akun') }}" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle"></i> Tambah User
                    </a>
                </div>
                <div class="card-body table-responsive">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Avatar</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Dibuat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $index => $user)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    @if($user->avatar)
                                        @if(str_contains($user->avatar, 'googleusercontent.com'))
                                            <img src="{{ $user->avatar }}" class="avatar-img" alt="Avatar">
                                        @else
                                            <img src="{{ Storage::url($user->avatar) }}" class="avatar-img" alt="Avatar">
                                        @endif
                                    @else
                                        <div class="default-avatar-small">
                                            <i class="bi bi-person-circle"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>{{ $user->nama }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if($user->role == 'superadmin')
                                        <span class="badge bg-danger">Superadmin</span>
                                    @elseif($user->role == 'admin')
                                        <span class="badge bg-warning">Admin</span>
                                    @else
                                        <span class="badge bg-info">Driver</span>
                                    @endif
                                </td>
                                <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    @if($user->role != 'superadmin')
                                        <a href="{{ route('superadmin.edit-akun', $user->user_id) }}" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('superadmin.delete-akun', $user->user_id) }}" method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus user ini?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.avatar-img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
}

.default-avatar-small {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: #94a3b8;
}

.table td {
    vertical-align: middle;
}
</style>
@endsection