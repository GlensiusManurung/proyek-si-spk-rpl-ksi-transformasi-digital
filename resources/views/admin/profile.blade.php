@vite(['public/css/adminlte.css', 'public/js/adminlte.js'])
@extends('layoutadmin.dashboard')

@section('title', 'Profile')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h4><i class="bi bi-person-circle"></i> Profile Admin</h4>
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
                            <div class="mt-3">
                                <form method="POST" action="{{ route('admin.profile.delete-photo') }}" 
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
                    
                    <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="form-group">
                            <label>Foto Profile</label>
                            <input type="file" name="avatar" class="form-control" accept="image/*">
                            <small class="text-muted">Format: JPG, PNG, GIF (Max 2MB)</small>
                        </div>
                        
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" value="{{ $user->nama }}" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" value="{{ $user->email }}" disabled>
                        </div>
                        
                        <div class="form-group">
                            <label>Role</label>
                            <input type="text" class="form-control" value="Admin" disabled>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </form>
                    
                    <hr>
                    
                    <h5>Ganti Password</h5>
                    <form method="POST" action="{{ route('admin.profile.change-password') }}">
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

.btn-danger {
    background-color: #dc3545;
    color: white;
    border: none;
    padding: 5px 12px;
    border-radius: 5px;
    cursor: pointer;
}

.btn-danger:hover {
    background-color: #c82333;
}
</style>
@endsection