@vite(['resources/css/login.css','resources/js/login.js'])

<div class="login-container">

    <div class="logo">
        <img src="{{ asset('img/OPR-optiroute.png') }}" alt="Logo OPR Optiroute" style="max-width: 150px; height: auto;">
    </div>

    {{-- TAMPILKAN SEMUA ERROR (VALIDASI + SESSION ERROR) --}}
    @if($errors->any())
        <div class="alert alert-danger" style="background: #fee2e2; border: 1px solid #ef4444; color: #b91c1c; padding: 12px; border-radius: 8px; margin-bottom: 15px; max-width: 350px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- TAMPILKAN SESSION ERROR (dari with('error', '...')) --}}
    @if(session('error'))
        <div class="alert alert-error" style="background: #fee2e2; border: 1px solid #ef4444; color: #b91c1c; padding: 12px; border-radius: 8px; margin-bottom: 15px; max-width: 350px;">
            {{ session('error') }}
        </div>
    @endif

    {{--TAMPILKAN SESSION SUCCESS --}}
    @if(session('success'))
        <div class="alert alert-success" style="background: #dcfce7; border: 1px solid #22c55e; color: #166534; padding: 12px; border-radius: 8px; margin-bottom: 15px; max-width: 350px;">
            {{ session('success') }}
        </div>
    @endif

    <form class="login-form" method="POST" action="{{ route('login.process') }}">
        @csrf
        
        <div class="input-group">
            <label>Nama</label>
            <input type="text" name="nama" placeholder="Masukkan Nama" value="{{ old('nama') }}" required>
        </div>

        <div class="input-group">
            <label>Email</label>
            <input type="email" name="email" placeholder="Masukkan Email" value="{{ old('email') }}" required>
        </div>

        <div class="input-group">
            <label>Password</label>
            <input type="password" name="password" placeholder="Masukkan Password" required>
        </div>

        <button type="submit" class="btn-login">LOGIN</button>

        <div class="login-actions">
            <a href="{{ route('password.request') }}">LUPA PASSWORD?</a>
            <a href="{{ route('daftar') }}">DAFTAR AKUN</a>
        </div>

    </form>

</div>