<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin - @yield('title')</title>
    
    @vite(['resources/css/superadmin.css', 'resources/js/superadmin.js'])
    @vite(['resources/css/chat-superadmin.css', 'resources/js/chat-superadmin.js'])
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <style>
        .badge {
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
        }
        .bg-danger { background: #dc3545; color: white; }
        .bg-warning { background: #ffc107; color: #000; }
        .bg-info { background: #17a2b8; color: white; }
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            padding: 15px;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<div class="app-wrapper">

    <!-- Sidebar -->
    <aside class="app-sidebar">
        <div class="sidebar-brand">
            <a href="{{ url('/superadmin/dashboard') }}">
                <img src="{{ asset('img/OPR-optiroute.png') }}" alt="OPR Optiroute" class="brand-image">
            </a>
        </div>
        <div class="sidebar-wrapper">
            <ul class="nav-sidebar">
                <li class="nav-item">
                    <a href="{{ url('/superadmin/dashboard') }}" class="nav-link {{ request()->routeIs('superadmin.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="nav-item has-treeview {{ request()->routeIs('superadmin.users*') || request()->routeIs('superadmin.create-akun*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link">
                        <i class="bi bi-people"></i>
                        <span>Manajemen Akun</span>
                        <i class="nav-arrow bi bi-chevron-right"></i>
                    </a>
                    <ul class="nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('superadmin.users') }}" class="nav-link {{ request()->routeIs('superadmin.users') ? 'active' : '' }}">
                                <i class="bi bi-circle"></i>
                                <span>Semua User</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('superadmin.create-akun') }}" class="nav-link {{ request()->routeIs('superadmin.create-akun') ? 'active' : '' }}">
                                <i class="bi bi-circle"></i>
                                <span>Tambah User</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- DATA MASTER -->
                <li class="nav-header">DATA MASTER</li>

                <li class="nav-item">
                    <a href="{{ url('/superadmin/driver') }}" class="nav-link">
                        <i class="bi bi-truck"></i>
                        <span>Data Driver</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('/superadmin/mobil') }}" class="nav-link">
                        <i class="bi bi-car-front"></i>
                        <span>Data Mobil</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('/superadmin/customer') }}" class="nav-link">
                        <i class="bi bi-people-fill"></i>
                        <span>Data Customer</span>
                    </a>
                </li>
<li class="nav-header">CHAT</li>
<li class="nav-item">
    <a href="{{ url('/chat') }}" class="nav-link">
        <i class="bi bi-chat-dots"></i>
        <span>Chat</span>
    </a>
</li>
                <!-- TRANSAKSI -->
                <li class="nav-header">TRANSAKSI</li>

                <li class="nav-item">
                    <a href="{{ url('/superadmin/pengajuan') }}" class="nav-link">
                        <i class="bi bi-file-text"></i>
                        <span>Pengajuan</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('/superadmin/pengiriman') }}" class="nav-link">
                        <i class="bi bi-box-seam"></i>
                        <span>Pengiriman</span>
                    </a>
                </li>

                <!-- SPK -->
                <li class="nav-header">SPK</li>

                <li class="nav-item">
                    <a href="{{ url('/superadmin/saw') }}" class="nav-link">
                        <i class="bi bi-calculator"></i>
                        <span>Metode SAW</span>
                    </a>
                </li>

                <!-- SYSTEM -->
                <li class="nav-header">SYSTEM</li>

                <li class="nav-item">
                    <a href="{{ url('/superadmin/settings') }}" class="nav-link">
                        <i class="bi bi-gear"></i>
                        <span>Settings</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('superadmin.profile') }}" class="nav-link">
                        <i class="bi bi-person-circle"></i>
                        <span>Profile</span>
                    </a>
                </li>

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
        <nav class="app-header">
            <button id="sidebarToggle" class="nav-link">
                <i class="bi bi-list"></i>
            </button>

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="{{ url('/') }}" class="nav-link">Home</a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/kontak') }}" class="nav-link">Contact</a>
                </li>
            </ul>

            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle">
                        <i class="bi bi-bell"></i>
                        <span class="badge bg-danger" style="font-size: 10px;">3</span>
                    </a>
                </li>
                <li class="nav-item dropdown">
    <a href="#" class="nav-link dropdown-toggle">
        @if(Auth::user()->avatar)
            @if(str_contains(Auth::user()->avatar, 'googleusercontent.com'))
                <!-- Foto dari Google -->
                <img src="{{ Auth::user()->avatar }}" class="user-image rounded-circle" alt="User">
            @else
                <!-- Foto upload manual dari storage -->
                <img src="{{ Storage::url(Auth::user()->avatar) }}" class="user-image rounded-circle" alt="User">
            @endif
        @else
            <!-- Default avatar -->
            <i class="bi bi-person-circle" style="font-size: 1.5rem;"></i>
        @endif
        <span>{{ Auth::user()->nama }}</span>
    </a>
    <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="{{ route('superadmin.profile') }}">Profile</a></li>
        <li>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="dropdown-item" style="width: 100%; text-align: left;">Logout</button>
            </form>
        </li>
    </ul>
</li>
            </ul>
        </nav>

        <!-- Content -->
        @yield('content')

    </main>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
@vite(['resources/js/superadmin.js'])

</body>
</html>