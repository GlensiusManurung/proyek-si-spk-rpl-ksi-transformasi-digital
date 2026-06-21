
@vite(['public/css/adminlte.css', 'public/js/adminlte.js'])
@extends('layoutadmin.dashboard')

@section('title', 'Edit User')

@section('content')
<div class="container-fluid px-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-pencil-square me-2"></i> Edit User: {{ $user->nama }}
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.update', $user->user_id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <!-- Preview Avatar -->
                        <div class="text-center mb-4 position-relative">
                            <div class="position-relative d-inline-block">
                                @if($user->avatar && Storage::disk('public')->exists($user->avatar))
                                    <img src="{{ Storage::url($user->avatar) }}" 
                                         class="rounded-circle" 
                                         style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #0f6bff;"
                                         id="avatarPreview">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->nama) }}&background=0f6bff&color=fff&size=120&length=2&bold=true" 
                                         class="rounded-circle" 
                                         style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #e5e7eb;"
                                         id="avatarPreview">
                                @endif
                                <div class="position-absolute bottom-0 end-0 bg-white rounded-circle p-1" style="transform: translate(10px, 10px);">
                                    <i class="bi bi-camera-fill text-primary"></i>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="avatar" class="form-label">
                                <i class="bi bi-image me-1"></i> Ganti Foto Profile (Opsional)
                            </label>
                            <input type="file" name="avatar" id="avatar" class="form-control @error('avatar') is-invalid @enderror" accept="image/*">
                            <small class="text-muted">Format: JPG, PNG, GIF (Max 2MB)</small>
                            @error('avatar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="nama" class="form-label">
                                <i class="bi bi-person-fill me-1"></i> Nama Lengkap
                            </label>
                            <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $user->nama) }}" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">
                                <i class="bi bi-envelope-fill me-1"></i> Email
                            </label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">
                                    <i class="bi bi-lock-fill me-1"></i> Password (Kosongkan jika tidak diubah)
                                </label>
                                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label">
                                    <i class="bi bi-lock-fill me-1"></i> Konfirmasi Password
                                </label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="role" class="form-label">
                                <i class="bi bi-person-badge-fill me-1"></i> Role
                            </label>
                            <select name="role" id="role" class="form-select @error('role') is-invalid @enderror" required>
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="driver" {{ $user->role == 'driver' ? 'selected' : '' }}>Driver</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <hr class="my-4">
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.users') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i> Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Preview avatar saat ganti file
    document.getElementById('avatar').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('avatarPreview');
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                preview.src = event.target.result;
                preview.style.border = '3px solid #0f6bff';
            };
            reader.readAsDataURL(file);
        }
    });
    
    // Update preview saat nama diketik (buat avatar default)
    document.getElementById('nama').addEventListener('input', function() {
        const nama = this.value;
        const preview = document.getElementById('avatarPreview');
        const fileInput = document.getElementById('avatar');
        
        if (!fileInput.files.length > 0) {
            preview.src = `https://ui-avatars.com/api/?name=${encodeURIComponent(nama)}&background=0f6bff&color=fff&size=120&length=2&bold=true`;
        }
    });
</script>
@endsection