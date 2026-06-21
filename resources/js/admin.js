// ============================================================
// ADMIN PANEL — GLOBAL SCRIPTS
// resources/js/admin.js
// ============================================================

document.addEventListener('DOMContentLoaded', function () {

    // ── Referensi elemen ────────────────────────────────────
    const sidebar       = document.querySelector('.app-sidebar');
    const mainContent   = document.querySelector('.app-main');
    const toggleBtn     = document.getElementById('sidebarToggle');
    const overlay       = document.getElementById('sidebarOverlay');

    // ── Deteksi ukuran layar ─────────────────────────────────
    const bp = {
        mobile:  () => window.innerWidth <= 768,
        tablet:  () => window.innerWidth > 768 && window.innerWidth <= 1024,
        desktop: () => window.innerWidth > 1024,
    };

    // ============================================================
    // 1. SIDEBAR
    // ============================================================

    if (toggleBtn && sidebar) {
        toggleBtn.addEventListener('click', function (e) {
            e.preventDefault();

            if (bp.mobile()) {
                // Mobile: slide in/out dengan overlay
                const isOpen = sidebar.classList.contains('mobile-open');
                isOpen ? closeMobileSidebar() : openMobileSidebar();
            } else {
                // Desktop / Tablet: toggle mini ↔ full
                const isMini = sidebar.classList.contains('mini');
                sidebar.classList.toggle('mini', !isMini);
                mainContent?.classList.toggle('mini-offset', !isMini);
            }
        });
    }

    // Overlay click → tutup sidebar mobile
    if (overlay) {
        overlay.addEventListener('click', closeMobileSidebar);
    }

    function openMobileSidebar() {
        sidebar.classList.add('mobile-open');
        if (overlay) overlay.classList.add('visible');
        document.body.style.overflow = 'hidden';
    }

    function closeMobileSidebar() {
        sidebar.classList.remove('mobile-open');
        if (overlay) overlay.classList.remove('visible');
        document.body.style.overflow = '';
    }

    // Tutup mobile sidebar saat resize ke desktop
    window.addEventListener('resize', function () {
        if (!bp.mobile()) closeMobileSidebar();
    });

    // ── Active nav link ──────────────────────────────────────
    const currentPath = window.location.pathname;
    document.querySelectorAll('.nav-sidebar .nav-link').forEach(function (link) {
        const href = link.getAttribute('href');
        if (!href || href === '#') return;
        if (currentPath === href || (currentPath.startsWith(href) && href !== '/')) {
            link.classList.add('active');
        }
    });

    // ============================================================
    // 2. DROPDOWN — Notifikasi & Profil
    // ============================================================
    // Kita kelola sendiri tanpa bergantung Bootstrap JS.
    // Setiap .nav-dropdown memiliki:
    //   - .nav-dropdown-toggle  (trigger)
    //   - .nav-dropdown-menu    (panel)

    let activeDropdown = null; // track yang sedang terbuka

    function openDropdown(wrapper) {
        // Tutup yang lain dulu
        if (activeDropdown && activeDropdown !== wrapper) {
            closeDropdown(activeDropdown);
        }

        const menu   = wrapper.querySelector('.nav-dropdown-menu');
        const toggle = wrapper.querySelector('.nav-dropdown-toggle');
        if (!menu) return;

        wrapper.classList.add('open');
        menu.classList.add('open');
        toggle?.setAttribute('aria-expanded', 'true');
        activeDropdown = wrapper;

        // Pastikan menu tidak terpotong di kanan layar
        repositionMenu(menu);
    }

    function closeDropdown(wrapper) {
        if (!wrapper) return;
        const menu   = wrapper.querySelector('.nav-dropdown-menu');
        const toggle = wrapper.querySelector('.nav-dropdown-toggle');

        wrapper.classList.remove('open');
        menu?.classList.remove('open');
        toggle?.setAttribute('aria-expanded', 'false');

        if (activeDropdown === wrapper) activeDropdown = null;
    }

    function toggleDropdown(wrapper) {
        wrapper.classList.contains('open')
            ? closeDropdown(wrapper)
            : openDropdown(wrapper);
    }

    function repositionMenu(menu) {
        // Reset
        menu.style.right = '';
        menu.style.left  = '';

        // Tunggu render, lalu cek posisi
        requestAnimationFrame(function () {
            const rect = menu.getBoundingClientRect();
            if (rect.right > window.innerWidth - 8) {
                menu.style.right = '0';
                menu.style.left  = 'auto';
            }
            if (rect.left < 8) {
                menu.style.left  = '0';
                menu.style.right = 'auto';
            }
        });
    }

    // Pasang event ke semua .nav-dropdown
    document.querySelectorAll('.nav-dropdown').forEach(function (wrapper) {
        const toggle = wrapper.querySelector('.nav-dropdown-toggle');
        if (!toggle) return;

        toggle.setAttribute('aria-expanded', 'false');
        toggle.setAttribute('aria-haspopup', 'true');

        // Klik toggle
        toggle.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            toggleDropdown(wrapper);
        });

        // Keyboard: Enter / Space buka, Escape tutup
        toggle.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                toggleDropdown(wrapper);
            } else if (e.key === 'Escape') {
                closeDropdown(wrapper);
                toggle.focus();
            }
        });
    });

    // Klik di luar → tutup semua dropdown
    document.addEventListener('click', function (e) {
        if (!e.target.closest('.nav-dropdown')) {
            if (activeDropdown) closeDropdown(activeDropdown);
        }
    });

    // Escape di mana saja → tutup
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && activeDropdown) {
            closeDropdown(activeDropdown);
        }
    });

    // ============================================================
    // 3. AUTO-CLOSE ALERTS
    // ============================================================

    setTimeout(function () {
        document.querySelectorAll('.alert').forEach(function (alert) {
            // Simpan tinggi asli dulu
            const h = alert.offsetHeight;
            alert.style.height   = h + 'px';
            alert.style.overflow = 'hidden';
            alert.style.transition = 'opacity 0.4s ease, height 0.4s ease, padding 0.4s ease, margin 0.4s ease';

            requestAnimationFrame(function () {
                alert.style.opacity = '0';
                alert.style.height  = '0';
                alert.style.padding = '0';
                alert.style.margin  = '0';
            });

            setTimeout(function () { alert.remove(); }, 450);
        });
    }, 3500);

    // ============================================================
    // 4. SET OFFLINE saat tab/browser ditutup
    // ============================================================

    window.addEventListener('beforeunload', function () {
        const token = document.querySelector('meta[name="csrf-token"]')?.content;
        if (!token) return;
        // sendBeacon lebih reliable daripada fetch saat halaman menutup
        const blob = new Blob([JSON.stringify({})], { type: 'application/json' });
        navigator.sendBeacon('/set-offline', blob);
    });

});