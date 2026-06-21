@extends('layouts.superadmin')

@section('title', 'Profile')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">My Profile</h3>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    
                    <!-- Profile Photo -->
                    <div class="text-center mb-4">
                        <div class="profile-photo-wrapper">
                            @if($user->avatar && !str_contains($user->avatar, 'googleusercontent.com'))
                                <img src="{{ Storage::url($user->avatar) }}" class="profile-photo" alt="Profile Photo">
                            @elseif($user->avatar)
                                <img src="{{ $user->avatar }}" class="profile-photo" alt="Profile Photo">
                            @else
                                <div class="default-avatar">
                                    <i class="bi bi-person-circle"></i>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Tombol Hapus Foto (hanya tampil jika ada foto) -->
                        @if($user->avatar)
                            <div class="mt-2">
                                <form method="POST" action="{{ route('superadmin.profile.delete-photo') }}" 
                                      onsubmit="return confirm('Yakin ingin menghapus foto profile?')"
                                      style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i> Hapus Foto
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                    
                    <form method="POST" action="{{ route('superadmin.profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="form-group">
                            <label>Foto Profile</label>
                            <input type="file" name="avatar" class="form-control" accept="image/*">
                            <small class="text-muted">Format: JPG, PNG, GIF (Max 2MB)</small>
                        </div>
                        
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" name="nama" class="form-control" value="{{ $user->nama }}" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" value="{{ $user->email }}" disabled>
                        </div>
                        
                        <div class="form-group">
                            <label>Role</label>
                            <input type="text" class="form-control" value="{{ ucfirst($user->role) }}" disabled>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </form>
                    
                    <hr>
                    
                    <h4>Ganti Password</h4>
                    <form method="POST" action="{{ route('superadmin.profile.change-password') }}">
                        @csrf
                        <div class="form-group">
                            <label>Password Saat Ini</label>
                            <input type="password" name="current_password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Password Baru</label>
                            <input type="password" name="new_password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Konfirmasi Password Baru</label>
                            <input type="password" name="new_password_confirmation" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-warning">Ganti Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.profile-photo-wrapper {
    width: 150px;
    height: 150px;
    margin: 0 auto;
    border-radius: 50%;
    overflow: hidden;
    border: 3px solid #3498db;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}
.profile-photo {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.default-avatar {
    width: 100%;
    height: 100%;
    background: #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 5rem;
    color: #cbd5e0;
}
</style>
@endsection