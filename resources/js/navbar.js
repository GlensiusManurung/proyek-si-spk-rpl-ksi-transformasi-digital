document.addEventListener("DOMContentLoaded", () => {
    console.log("🚀 Navbar - Fully Responsive Loaded");

    const navbar = document.querySelector(".navbar");
    const mobileToggle = document.querySelector(".mobile-toggle");
    const mobileMenu = document.querySelector(".mobile-menu");

    // Scroll effect
    window.addEventListener("scroll", () => {
        navbar.classList.toggle("scrolled", window.scrollY > 30);
    });

    // Mobile toggle
    if (mobileToggle && mobileMenu) {
        mobileToggle.addEventListener("click", (e) => {
            e.stopPropagation();
            mobileToggle.classList.toggle("active");
            mobileMenu.classList.toggle("active");
            document.body.style.overflow = mobileMenu.classList.contains("active") ? "hidden" : "";
            mobileToggle.setAttribute("aria-expanded", mobileToggle.classList.contains("active"));
        });

        // Close on link click
        mobileMenu.querySelectorAll("a").forEach(link => {
            link.addEventListener("click", () => {
                mobileToggle.classList.remove("active");
                mobileMenu.classList.remove("active");
                document.body.style.overflow = "";
                mobileToggle.setAttribute("aria-expanded", "false");
            });
        });
    }

    // Active menu highlight
    const currentPath = window.location.pathname;
    document.querySelectorAll(".menu a, .mobile-menu a:not(.mobile-auth a)").forEach(link => {
        const href = link.getAttribute("href");
        if (href) {
            const isActive = href === currentPath || 
                            (href !== "/" && currentPath.startsWith(href) && href !== "/") ||
                            (href === "/" && currentPath === "/");
            if (isActive) link.classList.add("active");
        }
    });

    console.log("✅ Navbar initialized - Responsive All Devices");
});