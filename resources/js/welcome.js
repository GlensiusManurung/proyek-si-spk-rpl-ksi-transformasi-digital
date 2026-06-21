document.addEventListener("DOMContentLoaded", () => {
    console.log("🚀 Welcome Page - Electron Pro Theme Loaded");

    // ============================================
    // 1. MORPH ANIMATION - SCROLL REVEAL
    // ============================================
    
    const animateItems = document.querySelectorAll('.product-card, .testimonial, .blog-card');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animation = 'morphFadeUp 0.6s ease forwards';
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.15 });
    
    animateItems.forEach(item => {
        observer.observe(item);
    });

    // ============================================
    // 2. PARALLAX HERO EFFECT
    // ============================================
    
    const hero = document.querySelector('.hero');
    const heroContent = document.querySelector('.hero-content');
    
    if (hero && heroContent) {
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            heroContent.style.transform = `translateY(${scrolled * 0.15}px)`;
            hero.style.backgroundPosition = `center ${scrolled * 0.05}px`;
        });
    }

    // ============================================
    // 3. SMOOTH SCROLL FOR BUTTONS
    // ============================================
    
    const scrollBtn = document.querySelector('.hero-content .btn-primary');
    if (scrollBtn) {
        scrollBtn.addEventListener('click', () => {
            const target = document.querySelector('.products');
            if (target) {
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    }

    // ============================================
    // 4. PRODUCT CARD HOVER - GLOW EFFECT
    // ============================================
    
    const cards = document.querySelectorAll(".product-card");
    cards.forEach(card => {
        card.addEventListener("mouseenter", () => {
            card.style.borderColor = "#4a90e2";
            card.style.boxShadow = "0 8px 40px rgba(74,144,226,0.15)";
        });
        card.addEventListener("mouseleave", () => {
            card.style.borderColor = "#e0e4e8";
            card.style.boxShadow = "0 4px 20px rgba(0,0,0,0.08)";
        });
    });

    // ============================================
    // 5. TESTIMONIAL CARD HOVER
    // ============================================
    
    const testimonials = document.querySelectorAll(".testimonial");
    testimonials.forEach(test => {
        test.addEventListener("mouseenter", () => {
            test.style.borderColor = "#4a90e2";
            test.style.boxShadow = "0 8px 40px rgba(74,144,226,0.12)";
        });
        test.addEventListener("mouseleave", () => {
            test.style.borderColor = "#e0e4e8";
            test.style.boxShadow = "none";
        });
    });

    // ============================================
    // 6. BLOG CARD HOVER
    // ============================================
    
    const blogCards = document.querySelectorAll(".blog-card");
    blogCards.forEach(card => {
        card.addEventListener("mouseenter", () => {
            card.style.borderColor = "#4a90e2";
            card.style.boxShadow = "0 8px 40px rgba(74,144,226,0.12)";
        });
        card.addEventListener("mouseleave", () => {
            card.style.borderColor = "#e0e4e8";
            card.style.boxShadow = "0 4px 20px rgba(0,0,0,0.08)";
        });
    });

    // ============================================
    // 7. NEWSLETTER FORM
    // ============================================
    
    const newsletterForm = document.querySelector(".newsletter-form");
    if (newsletterForm) {
        newsletterForm.addEventListener("submit", (e) => {
            e.preventDefault();
            const email = newsletterForm.querySelector("input")?.value;
            if (email && email.includes('@')) {
                alert(`✅ [ERP System] Email ${email} telah terdaftar.`);
                newsletterForm.reset();
            } else {
                alert("⚠️ Masukkan alamat email yang valid.");
            }
        });
    }

    // ============================================
    // 8. CTA BUTTON
    // ============================================
    
    const ctaBtn = document.querySelector(".cta .btn-primary");
    if (ctaBtn) {
        ctaBtn.addEventListener("click", () => {
            window.location.href = "/contact";
        });
    }

    // ============================================
    // 9. CAREER BUTTON
    // ============================================
    
    const careerBtn = document.querySelector(".careers-text .btn-outline");
    if (careerBtn) {
        careerBtn.addEventListener("click", () => {
            window.location.href = "/careers";
        });
    }

    // ============================================
    // 10. NEWSLETTER PROMO BUTTON (SCROLL)
    // ============================================
    
    const promoBtn = document.querySelector(".newsletter-text .btn-outline");
    if (promoBtn) {
        promoBtn.addEventListener("click", () => {
            const target = document.querySelector(".newsletter-input");
            if (target) {
                target.scrollIntoView({ behavior: "smooth", block: "center" });
            }
        });
    }

    // ============================================
    // 11. COUNTER ANIMATION (Statistik)
    // ============================================
    
    const counterElements = document.querySelectorAll('.stat-number');
    if (counterElements.length > 0) {
        counterElements.forEach(el => {
            const target = parseInt(el.getAttribute('data-target'));
            let current = 0;
            const increment = target / 60;
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    el.textContent = target.toLocaleString();
                    clearInterval(timer);
                } else {
                    el.textContent = Math.floor(current).toLocaleString();
                }
            }, 30);
        });
    }

    console.log("✅ All animations initialized successfully!");
});