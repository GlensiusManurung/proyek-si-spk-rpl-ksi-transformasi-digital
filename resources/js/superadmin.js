// Sidebar Toggle
document.addEventListener('DOMContentLoaded', function() {
    // Toggle sidebar
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.querySelector('.app-sidebar');
    const mainContent = document.querySelector('.app-main');
    
    if (sidebarToggle && sidebar && mainContent) {
        sidebarToggle.addEventListener('click', function(e) {
            e.preventDefault();
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
        });
    }
    
    // Treeview toggle (dropdown menu)
    const treeviewLinks = document.querySelectorAll('.has-treeview > .nav-link');
    
    treeviewLinks.forEach(function(link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const parent = this.closest('.nav-item');
            if (parent) {
                parent.classList.toggle('menu-open');
            }
        });
    });
    
    // Active link highlight
    const currentUrl = window.location.pathname;
    const navLinks = document.querySelectorAll('.nav-sidebar .nav-link');
    
    navLinks.forEach(function(link) {
        const href = link.getAttribute('href');
        if (href && href !== '#' && currentUrl === href) {
            link.classList.add('active');
            
            // Open parent menu
            let parent = link.closest('.nav-treeview');
            if (parent) {
                let parentItem = parent.closest('.nav-item');
                if (parentItem) {
                    parentItem.classList.add('menu-open');
                }
            }
        }
    });
    
    // Auto close alerts
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(function() {
                if (alert.parentNode) {
                    alert.remove();
                }
            }, 500);
        });
    }, 3000);
});