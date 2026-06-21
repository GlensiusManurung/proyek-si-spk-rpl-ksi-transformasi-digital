<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user-id" content="{{ Auth::id() }}">
<meta name="user-role" content="{{ Auth::user()->role }}">
    <title>Driver Panel - @yield('title')</title>
    
    @vite(['resources/css/driver.css', 'resources/js/driver.js'])
     @vite(['resources/css/chat-driver.css', 'resources/js/chat-driver.js'])
     
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <style>
        .user-image {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 5px;
        }
        .dropdown-toggle {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .badge {
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
        }
        .bg-danger { background: #dc3545; color: white; }
        .bg-warning { background: #ffc107; color: #000; }
        .bg-info { background: #17a2b8; color: white; }
        .bg-success { background: #28a745; color: white; }
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            padding: 15px;
            border-radius: 5px;
        }
        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            padding: 15px;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<div class="app-wrapper">

    <!-- Sidebar Driver -->
    <aside class="app-sidebar">
        <div class="sidebar-brand">
            <a href="{{ url('/driver/dashboard') }}">
                <img src="{{ asset('img/OPR.png') }}" alt="Logo" class="brand-image">
            </a>
        </div>
        <div class="sidebar-wrapper">
            <ul class="nav-sidebar">
                <li class="nav-item">
                    <a href="{{ url('/driver/dashboard') }}" class="nav-link {{ request()->routeIs('driver.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="nav-header">PENGIRIMAN</li>

                

<li class="nav-item">
    <a href="{{ route('driver.pengiriman-saya') }}" class="nav-link">
        <i class="bi bi-truck"></i> Pengiriman Saya
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('driver.bukti-pengiriman.index') }}" class="nav-link">
        <i class="bi bi-receipt"></i> Bukti Pengiriman
    </a>
</li>
                <li class="nav-item">
    <a href="{{ route('driver.riwayat-pengiriman') }}" class="nav-link">
        <i class="bi bi-clock-history"></i> Riwayat
    </a>
</li>

                <li class="nav-header">PROFILE</li>

                <li class="nav-item">
                    <a href="{{ route('driver.profile') }}" class="nav-link">
                        <i class="bi bi-person-circle"></i>
                        <span>Profile Saya</span>
                    </a>
                </li>

<li class="nav-header">CHAT</li>
<li class="nav-item">
    <a href="{{ url('/chat') }}" class="nav-link">
        <i class="bi bi-chat-dots"></i>
        <span>Chat</span>
    </a>
</li>

                <li class="nav-header">SYSTEM</li>

                <li class="nav-item">
                    <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="app-main">
        
        <!-- Navbar -->
       <!-- Navbar -->
<nav class="app-header">
    <div class="header-left">
        <button id="sidebarToggle">
            <i class="bi bi-list"></i>
        </button>
    </div>

    <div class="header-right" style="display:flex; align-items:center; gap:8px;">
        
        @include('driver.notifikasi.notif')

        <div class="dropdown" style="position:relative; display:flex; align-items:center;">
            <a href="#" class="nav-link dropdown-toggle" style="display:flex; align-items:center; gap:8px;">
                @if(Auth::user()->avatar)
                    @if(str_contains(Auth::user()->avatar, 'googleusercontent.com'))
                        <img src="{{ Auth::user()->avatar }}" class="user-image rounded-circle" alt="User">
                    @else
                        <img src="{{ Storage::url(Auth::user()->avatar) }}" class="user-image rounded-circle" alt="User">
                    @endif
                @else
                    <i class="bi bi-person-circle" style="font-size:1.5rem;"></i>
                @endif
                <span>{{ Auth::user()->nama }}</span>
            </a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{ route('driver.profile') }}">Profile</a></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item">Logout</button>
                    </form>
                </li>
            </ul>
        </div>

    </div>
</nav>

        <!-- Content -->
        @yield('content')

    </main>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
@vite(['resources/js/driver.js'])
<script>
    // Deteksi ketika browser/tab ditutup
    window.addEventListener('beforeunload', function() {
        fetch('/set-offline', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
                'Content-Type': 'application/json'
            },
            keepalive: true  // Biar tetap terkirim meskipun halaman ditutup
        });
    });
</script>
</body>
</html>