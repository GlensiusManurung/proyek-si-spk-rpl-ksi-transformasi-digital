document.addEventListener('DOMContentLoaded', function () {

    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.querySelector('.app-sidebar');
    const mainContent = document.querySelector('.app-main');

    /* =========================
       SIDEBAR TOGGLE
    ========================= */
    if (sidebarToggle && sidebar && mainContent) {

        sidebarToggle.addEventListener('click', function (e) {

            e.preventDefault();

            // MOBILE
            if (window.innerWidth <= 768) {

                sidebar.classList.toggle('open');

            } 
            
            // DESKTOP
            else {

                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('expanded');

            }

        });

    }

    /* =========================
       AUTO CLOSE ALERT
    ========================= */
    setTimeout(function () {

        const alerts = document.querySelectorAll('.alert');

        alerts.forEach(function (alert) {

            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';

            setTimeout(function () {

                if (alert.parentNode) {
                    alert.remove();
                }

            }, 500);

        });

    }, 3000);

    /* =========================
       ACTIVE LINK
    ========================= */
    const currentUrl = window.location.pathname;
    const navLinks = document.querySelectorAll('.nav-sidebar .nav-link');

    navLinks.forEach(function (link) {

        const href = link.getAttribute('href');

        if (href && href !== '#' && currentUrl === href) {
            link.classList.add('active');
        }

    });

});