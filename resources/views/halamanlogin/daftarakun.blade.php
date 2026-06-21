<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Akun</title>
    
    @vite(['resources/css/daftarakun.css', 'resources/js/daftarakun.js'])
</head>
<body>

<div class="container">
    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
    <div class="logo">
        <img src="{{ asset('img/OPR-optiroute.png') }}" alt="Logo">
    </div>

    <form method="POST" action="{{ route('daftar.store') }}">
        @csrf

        <label>Nama</label>
        <input type="text" name="nama" placeholder="Masukkan Nama" required>

        <label>Email</label>
        <input type="email" name="email" placeholder="Masukkan Email" required>

        <label>Password</label>
        <input type="password" name="password" placeholder="Masukkan Password" required>

        <div class="button-group">
            <a href="/login" class="btn">KEMBALI KE LOGIN</a>
            <button type="submit" class="btn">DAFTAR</button>
        </div>

        <p class="divider">Atau Daftar Dengan</p>

        <a href="{{ route('google.redirect') }}" class="google-btn">
            <img src="https://www.gstatic.com/firebasejs/ui/2.0.0/images/auth/google.svg" alt="Google">
            DAFTAR DENGAN GOOGLE
        </a>
    </form>
</div>



</body>
</html>