<header class="navbar">

    <div class="nav-container">

        <!-- Logo -->
        <div class="logo">
            <a href="/">
                <img src="{{ asset('img/OPR.png') }}" alt="Logo OPR">
            </a>
        </div>

        <!-- Menu -->
        <nav class="menu">
            <a href="/" class="{{ request()->is('/') ? 'active' : '' }}">
                <i class="bi bi-house-fill"></i> Home
            </a>
            <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">
                <i class="bi bi-info-circle-fill"></i> About
            </a>
        </nav>

        <!-- Auth Buttons - Desktop -->
        <div class="auth">
            <a href="{{ route('login') }}" class="btn-outline">
                <i class="bi bi-box-arrow-in-right"></i> LOG IN
            </a>
            <a href="{{ route('daftar') }}" class="btn-primary">
                <i class="bi bi-person-plus-fill"></i> SIGN UP
            </a>
        </div>

        <!-- Mobile Toggle -->
        <button class="mobile-toggle" aria-label="Toggle menu">
            <span></span>
            <span></span>
            <span></span>
        </button>

    </div>

    <!-- Mobile Menu -->
    <div class="mobile-menu">
        <a href="/" class="{{ request()->is('/') ? 'active' : '' }}">
            <i class="bi bi-house-fill"></i> Home
        </a>
        <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'active' : '' }}">
            <i class="bi bi-info-circle-fill"></i> About
        </a>
        <div class="mobile-auth">
            <a href="{{ route('login') }}" class="btn-outline-mobile">
                <i class="bi bi-box-arrow-in-right"></i> LOG IN
            </a>
            <a href="{{ route('daftar') }}" class="btn-primary-mobile">
                <i class="bi bi-person-plus-fill"></i> SIGN UP
            </a>
        </div>
    </div>

</header>