<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- TAMBAHKAN 2 BARIS INI -->
    <meta name="user-id" content="{{ Auth::id() }}">
    <meta name="user-role" content="{{ Auth::user()->role }}">
    <title>Admin Panel - @yield('title')</title>
    
    @vite(['resources/css/admin.css', 'resources/js/admin.js'])
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    
    <style>
        /* ========== CSS VARIABLES LIGHT / DARK MODE ========== */
        :root {
            --bg-body: #f4f6f9;
            --bg-sidebar: #2c3e50;
            --bg-card: #ffffff;
            --text-primary: #333333;
            --text-secondary: #6c757d;
            --border-color: #e9ecef;
            --shadow: 0 2px 4px rgba(0,0,0,0.05);
            --hover-bg: #f8f9fa;
        }
        
        [data-theme="dark"] {
            --bg-body: #1a1a2e;
            --bg-sidebar: #16213e;
            --bg-card: #0f3460;
            --text-primary: #e0e0e0;
            --text-secondary: #a0a0a0;
            --border-color: #1e2a4a;
            --shadow: 0 2px 4px rgba(0,0,0,0.2);
            --hover-bg: #1e2a4a;
        }
        
        /* Reset & Base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', 'Helvetica Neue', Arial, sans-serif;
            background: var(--bg-body);
            transition: background 0.3s, color 0.3s;
        }
        
        /* App Wrapper */
        .app-wrapper {
            display: flex;
            min-height: 100vh;
        }
        
        /* ========== SIDEBAR ========== */
        .app-sidebar {
            width: 260px;
            background: var(--bg-sidebar);
            color: white;
            position: fixed;
            height: 100vh;
            left: 0;
            top: 0;
            transition: all 0.3s ease;
            z-index: 1000;
            overflow-y: auto;
            overflow-x: hidden;
        }
        
        .app-sidebar.collapsed {
            width: 0;
            margin-left: -260px;
        }
        
        .sidebar-brand {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .brand-image {
            max-width: 130px;
            height: auto;
        }
        
        .sidebar-wrapper {
            padding: 20px 0;
        }
        
        .nav-sidebar {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        
        .nav-sidebar .nav-item {
            margin-bottom: 5px;
        }
        
        .nav-sidebar .nav-link {
            display: flex;
            align-items: center;
            padding: 10px 20px;
            color: #ecf0f1;
            text-decoration: none;
            transition: all 0.3s;
            font-size: 14px;
            gap: 12px;
        }
        
        .nav-sidebar .nav-link i {
            font-size: 1.2rem;
            width: 25px;
        }
        
        .nav-sidebar .nav-link:hover {
            background: #34495e;
            padding-left: 25px;
        }
        
        .nav-sidebar .nav-link.active {
            background: #3498db;
            border-left: 3px solid #fff;
        }
        
        .nav-header {
            padding: 10px 20px;
            font-size: 0.7rem;
            text-transform: uppercase;
            color: #7f8c8d;
            font-weight: bold;
        }
        
        /* ========== MAIN CONTENT ========== */
        .app-main {
            margin-left: 260px;
            padding: 20px;
            flex: 1;
            transition: all 0.3s ease;
        }
        
        .app-main.expanded {
            margin-left: 0;
        }
        
        /* ========== NAVBAR HEADER ========== */
        .app-header {
            background: var(--bg-card);
            box-shadow: var(--shadow);
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-radius: 12px;
            position: sticky;
            top: 0;
            z-index: 99;
        }
        
        /* Left Section */
        .header-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        #sidebarToggle {
            background: none;
            border: none;
            font-size: 1.3rem;
            cursor: pointer;
            padding: 8px;
            border-radius: 8px;
            color: var(--text-secondary);
            transition: all 0.3s;
        }
        
        #sidebarToggle:hover {
            background: var(--hover-bg);
            color: #3498db;
        }
        
        /* Right Section */
        .header-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .nav-item {
            position: relative;
        }
        
        /* Toggle Dark Mode */
        .theme-toggle {
            background: var(--hover-bg);
            border: none;
            border-radius: 50%;
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
            color: var(--text-secondary);
        }
        
        .theme-toggle:hover {
            background: #3498db;
            color: white;
            transform: scale(1.05);
        }
        
        .theme-toggle i {
            font-size: 1.2rem;
        }
        
        /* Notification Dropdown */
        .dropdown {
            position: relative;
        }
        
        .dropdown-toggle {
            background: var(--hover-bg);
            border: none;
            border-radius: 50%;
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            position: relative;
            color: var(--text-secondary);
        }
        
        .dropdown-toggle:hover {
            background: #3498db;
            color: white;
        }
        
        .navbar-badge {
            position: absolute;
            top: -3px;
            right: -3px;
            background: #dc3545;
            color: white;
            font-size: 9px;
            font-weight: bold;
            padding: 2px 5px;
            border-radius: 10px;
            min-width: 16px;
            text-align: center;
        }
        
        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background: var(--bg-card);
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            min-width: 320px;
            display: none;
            z-index: 1000;
            margin-top: 10px;
            overflow: hidden;
            border: 1px solid var(--border-color);
        }
        
        .dropdown.show .dropdown-menu {
            display: block;
            animation: fadeInDown 0.2s ease;
        }
        
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .dropdown-header {
            padding: 12px 15px;
            font-weight: 600;
            border-bottom: 1px solid var(--border-color);
            color: var(--text-primary);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .dropdown-header a {
            font-size: 11px;
            color: #3498db;
            text-decoration: none;
        }
        
        .notification-list {
            max-height: 350px;
            overflow-y: auto;
        }
        
        .notification-item {
            padding: 12px 15px;
            border-bottom: 1px solid var(--border-color);
            cursor: pointer;
            transition: background 0.2s;
        }
        
        .notification-item:hover {
            background: var(--hover-bg);
        }
        
        .notification-item.unread {
            background: rgba(52, 152, 219, 0.1);
        }
        
        .notification-title {
            font-weight: 600;
            font-size: 13px;
            color: var(--text-primary);
            margin-bottom: 4px;
        }
        
        .notification-text {
            font-size: 12px;
            color: var(--text-secondary);
        }
        
        .notification-time {
            font-size: 10px;
            color: #adb5bd;
            margin-top: 4px;
        }
        
        .dropdown-footer {
            padding: 10px 15px;
            text-align: center;
            border-top: 1px solid var(--border-color);
        }
        
        .dropdown-footer a {
            color: #3498db;
            text-decoration: none;
            font-size: 12px;
        }
        
        /* User Dropdown */
        .user-dropdown {
            position: relative;
        }
        
        .user-dropdown-toggle {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            padding: 5px 10px;
            border-radius: 30px;
            background: var(--hover-bg);
            transition: all 0.3s;
        }
        
        .user-dropdown-toggle:hover {
            background: #3498db;
            color: white;
        }
        
        .user-image {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            object-fit: cover;
        }
        
        .user-name {
            font-size: 13px;
            font-weight: 500;
        }
        
        .user-dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background: var(--bg-card);
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            min-width: 200px;
            display: none;
            z-index: 1000;
            margin-top: 10px;
            overflow: hidden;
            border: 1px solid var(--border-color);
        }
        
        .user-dropdown.show .user-dropdown-menu {
            display: block;
            animation: fadeInDown 0.2s ease;
        }
        
        .user-dropdown-item {
            display: block;
            padding: 10px 15px;
            text-decoration: none;
            color: var(--text-primary);
            font-size: 13px;
            transition: background 0.2s;
        }
        
        .user-dropdown-item:hover {
            background: var(--hover-bg);
        }
        
        .user-dropdown-item i {
            margin-right: 8px;
            width: 20px;
        }
        
        .dropdown-divider {
            height: 1px;
            background: var(--border-color);
            margin: 0;
        }
        
        /* Status Dot */
        .status-dot-navbar {
            position: absolute;
            bottom: 2px;
            right: 2px;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            border: 2px solid white;
        }
        
        .status-dot-navbar.online {
            background-color: #22c55e;
            animation: pulse-green 2s infinite;
        }
        
        .status-dot-navbar.offline {
            background-color: #9ca3af;
        }
        
        @keyframes pulse-green {
            0% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.4); }
            70% { box-shadow: 0 0 0 5px rgba(34, 197, 94, 0); }
            100% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0); }
        }
        
        /* Mobile Overlay */
        .mobile-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 999;
            display: none;
        }
        
        .mobile-overlay.show {
            display: block;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .app-sidebar {
                margin-left: -260px;
            }
            .app-sidebar.mobile-open {
                margin-left: 0;
            }
            .app-main {
                margin-left: 0;
            }
            .user-name {
                display: none;
            }
        }
        
        @stack('styles')
    </style>
</head>
<body>

<div class="mobile-overlay" id="mobileOverlay"></div>

<div class="app-wrapper">
    <!-- SIDEBAR -->
    <aside class="app-sidebar" id="appSidebar">
        <div class="sidebar-brand">
            <a href="{{ url('/admin/dashboard') }}">
                <img src="{{ asset('img/OPR.png') }}" alt="Logo" class="brand-image">
            </a>
        </div>
        <div class="sidebar-wrapper">
            <ul class="nav-sidebar">
                <li class="nav-item">
                    <a href="{{ url('/admin/dashboard') }}" class="nav-link">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-header">DATA MASTER</li>
                <li class="nav-item"><a href="{{ route('admin.drivers.index') }}" class="nav-link"><i class="bi bi-truck"></i> Data Driver</a></li>
                <li class="nav-item"><a href="{{ url('/chat') }}" class="nav-link"><i class="bi bi-chat-dots"></i> Chat</a></li>
                <li class="nav-item"><a href="{{ route('admin.mobils.index') }}" class="nav-link"><i class="bi bi-car-front"></i> Data Mobil</a></li>
                <li class="nav-item"><a href="{{ route('admin.customers.index') }}" class="nav-link"><i class="bi bi-building"></i> Data Customer</a></li>
                <li class="nav-item"><a href="{{ route('admin.users') }}" class="nav-link"><i class="bi bi-people-fill"></i> Daftar Users</a></li>
                <li class="nav-header">PENGIRIMAN</li>
                <li class="nav-item"><a href="{{ route('admin.pengajuans.index') }}" class="nav-link"><i class="bi bi-file-text"></i> Pengajuan</a></li>
                <li class="nav-item"><a href="{{ route('admin.pengirimans.index') }}" class="nav-link"><i class="bi bi-box-seam"></i> Pengiriman</a></li>
                <li class="nav-item"><a href="{{ route('admin.bukti-pengiriman.index') }}" class="nav-link"><i class="bi bi-receipt"></i> Bukti Pengiriman</a></li>
                <li class="nav-item"><a href="{{ route('admin.riwayat-pengiriman') }}" class="nav-link"><i class="bi bi-clock-history"></i> Riwayat</a></li>
                <li class="nav-header">DRIVER TERBAIK - SAW</li>
                <li class="nav-item"><a href="{{ route('admin.saw.kriteria') }}" class="nav-link"><i class="bi bi-table"></i> Data Kriteria</a></li>
                <li class="nav-item"><a href="{{ route('admin.saw.penilaian') }}" class="nav-link"><i class="bi bi-pencil-square"></i> Penilaian Driver</a></li>
                <li class="nav-item"><a href="{{ route('admin.saw.ranking') }}" class="nav-link"><i class="bi bi-trophy"></i> Ranking Driver</a></li>
                <li class="nav-header">SYSTEM</li>
                <li class="nav-item"><a href="{{ route('admin.profile') }}" class="nav-link"><i class="bi bi-person-circle"></i> Profile</a></li>
                <li class="nav-item"><a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
            </ul>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="app-main" id="appMain">
        <nav class="app-header">
            <div class="header-left">
                <button id="sidebarToggle" class="nav-link">
                    <i class="bi bi-list"></i>
                </button>
            </div>

            <div class="header-right">
                <!-- Dark/Light Mode Toggle -->
                <button class="theme-toggle" id="themeToggle">
                    <i class="bi bi-moon-fill" id="themeIcon"></i>
                </button>

               @include('admin.notifikasi.notif')

                <!-- USER DROPDOWN -->
                <div class="user-dropdown" id="userDropdown">
                    <div class="user-dropdown-toggle" data-toggle="user-dropdown">
                        <div class="position-relative">
                            @if($user->avatar)
    <img src="{{ $user->avatar }}" class="profile-photo" alt="Profile Photo">
@else
    <div class="default-avatar">
        <i class="bi bi-person-circle"></i>
    </div>
@endif
                            @else
                                <i class="bi bi-person-circle" style="font-size: 1.8rem;"></i>
                            @endif
                            <span class="status-dot-navbar {{ Auth::user()->is_online ? 'online' : 'offline' }}"></span>
                        </div>
                        <span class="user-name">{{ Auth::user()->nama }}</span>
                        <i class="bi bi-chevron-down ms-1" style="font-size: 0.7rem;"></i>
                    </div>
                    <div class="user-dropdown-menu">
                        <a class="user-dropdown-item" href="{{ route('admin.profile') }}">
                            <i class="bi bi-person"></i> Profile
                        </a>
                        <div class="dropdown-divider"></div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="user-dropdown-item" type="submit" style="width: 100%; text-align: left;">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        @yield('content')
    </main>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // ============================================
    // SIDEBAR TOGGLE
    // ============================================
    const sidebar = document.getElementById('appSidebar');
    const main = document.getElementById('appMain');
    const toggleBtn = document.getElementById('sidebarToggle');
    const mobileOverlay = document.getElementById('mobileOverlay');

    toggleBtn?.addEventListener('click', function() {
        if (window.innerWidth <= 768) {
            sidebar.classList.toggle('mobile-open');
            mobileOverlay.classList.toggle('show');
        } else {
            sidebar.classList.toggle('collapsed');
            main.classList.toggle('expanded');
        }
    });

    mobileOverlay?.addEventListener('click', function() {
        sidebar.classList.remove('mobile-open');
        this.classList.remove('show');
    });

    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            sidebar.classList.remove('mobile-open');
            mobileOverlay.classList.remove('show');
        }
    });

    // ============================================
    // DARK / LIGHT MODE
    // ============================================
    const themeToggle = document.getElementById('themeToggle');
    const themeIcon = document.getElementById('themeIcon');
    
    // Load saved theme
    const savedTheme = localStorage.getItem('theme') || 'light';
    document.documentElement.setAttribute('data-theme', savedTheme);
    updateThemeIcon(savedTheme);
    
    themeToggle?.addEventListener('click', function() {
        const currentTheme = document.documentElement.getAttribute('data-theme');
        const newTheme = currentTheme === 'light' ? 'dark' : 'light';
        document.documentElement.setAttribute('data-theme', newTheme);
        localStorage.setItem('theme', newTheme);
        updateThemeIcon(newTheme);
    });
    
    function updateThemeIcon(theme) {
        if (themeIcon) {
            themeIcon.className = theme === 'light' ? 'bi bi-moon-fill' : 'bi bi-sun-fill';
        }
    }

    // ============================================
    // DROPDOWNS (Notification & User)
    // ============================================
    const notifBtn = document.querySelector('#notificationDropdown .dropdown-toggle');
    const notifMenu = document.querySelector('#notificationDropdown .dropdown-menu');
    
    if (notifBtn && notifMenu) {
        notifBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            notifMenu.classList.toggle('show');
            document.querySelector('#notificationDropdown')?.classList.toggle('show');
        });
    }
    
    const userToggle = document.querySelector('#userDropdown .user-dropdown-toggle');
    const userMenu = document.querySelector('#userDropdown .user-dropdown-menu');
    
    if (userToggle && userMenu) {
        userToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            userMenu.classList.toggle('show');
            document.querySelector('#userDropdown')?.classList.toggle('show');
        });
    }
    
    document.addEventListener('click', function() {
        if (notifMenu) notifMenu.classList.remove('show');
        if (userMenu) userMenu.classList.remove('show');
        document.querySelector('#notificationDropdown')?.classList.remove('show');
        document.querySelector('#userDropdown')?.classList.remove('show');
    });

    // ============================================
    // MARK ALL NOTIFICATIONS READ
    // ============================================
    document.getElementById('markAllRead')?.addEventListener('click', function(e) {
        e.preventDefault();
        document.querySelectorAll('.notification-item.unread').forEach(item => {
            item.classList.remove('unread');
        });
        const badge = document.getElementById('notificationBadge');
        if (badge) badge.style.display = 'none';
    });

    // ============================================
    // SET OFFLINE SAAT BROWSER DITUTUP
    // ============================================
    window.addEventListener('beforeunload', function() {
        fetch('/set-offline', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
                'Content-Type': 'application/json'
            },
            keepalive: true
        });
    });
</script>

@stack('scripts')

</body>
</html>