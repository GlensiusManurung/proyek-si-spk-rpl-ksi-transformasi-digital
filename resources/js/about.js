document.addEventListener("DOMContentLoaded", () => {
    console.log("🚀 About Page - Professional Animations Loaded");

    // ============================================
    // 1. MORPH ANIMATION - Fade In Up
    // ============================================
    
    const morphElements = document.querySelectorAll(
        '.about-content, .about-grid, .mission-card, .team-card, .about-cta'
    );
    
    const morphObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '0';
                entry.target.style.transform = 'translateY(40px) scale(0.96)';
                entry.target.style.filter = 'blur(4px)';
                entry.target.style.transition = 'all 0.7s cubic-bezier(0.25, 0.46, 0.45, 0.94)';
                
                requestAnimationFrame(() => {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0) scale(1)';
                    entry.target.style.filter = 'blur(0)';
                });
                
                morphObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });
    
    morphElements.forEach(el => {
        morphObserver.observe(el);
    });

    // ============================================
    // 2. STAGGERED ANIMATION - Cards
    // ============================================
    
    const cards = document.querySelectorAll('.mission-card, .team-card');
    const staggerObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const parent = entry.target.parentElement;
                const siblings = parent.querySelectorAll('.mission-card, .team-card');
                siblings.forEach((card, index) => {
                    setTimeout(() => {
                        card.style.opacity = '0';
                        card.style.transform = 'translateY(30px)';
                        card.style.transition = 'all 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94)';
                        requestAnimationFrame(() => {
                            card.style.opacity = '1';
                            card.style.transform = 'translateY(0)';
                        });
                    }, index * 150);
                });
                staggerObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });
    
    const cardContainers = document.querySelectorAll('.mission-grid, .team-grid');
    cardContainers.forEach(container => {
        staggerObserver.observe(container);
        // Set initial state
        container.querySelectorAll('.mission-card, .team-card').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';
        });
    });

    // ============================================
    // 3. PARALLAX HERO - Smooth scroll effect
    // ============================================
    
    const hero = document.querySelector('.about-hero');
    const heroContent = document.querySelector('.about-content');
    
    if (hero && heroContent) {
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const heroHeight = hero.offsetHeight;
            if (scrolled < heroHeight) {
                const parallaxValue = scrolled * 0.3;
                heroContent.style.transform = `translateY(${parallaxValue * 0.15}px)`;
                hero.style.backgroundPositionY = `${scrolled * 0.1}px`;
            }
        });
    }

    // ============================================
    // 4. COUNTER ANIMATION - For stats (optional)
    // ============================================
    
    const counters = document.querySelectorAll('.stat-number');
    if (counters.length > 0) {
        const counterObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const target = parseInt(entry.target.getAttribute('data-target'));
                    let current = 0;
                    const increment = target / 60;
                    const timer = setInterval(() => {
                        current += increment;
                        if (current >= target) {
                            entry.target.textContent = target.toLocaleString();
                            clearInterval(timer);
                        } else {
                            entry.target.textContent = Math.floor(current).toLocaleString();
                        }
                    }, 30);
                    counterObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.3 });
        
        counters.forEach(counter => {
            counterObserver.observe(counter);
        });
    }

    // ============================================
    // 5. IMAGE PLACEHOLDER - Reveal on hover
    // ============================================
    
    const images = document.querySelectorAll('.img-placeholder');
    images.forEach(img => {
        img.addEventListener('mouseenter', () => {
            img.style.transform = 'scale(1.02)';
            img.style.boxShadow = '0 8px 40px rgba(0,0,0,0.12)';
        });
        img.addEventListener('mouseleave', () => {
            img.style.transform = 'scale(1)';
            img.style.boxShadow = 'none';
        });
    });

    // ============================================
    // 6. SMOOTH SCROLL - For CTA buttons
    // ============================================
    
    const ctaBtn = document.querySelector('.about-hero .btn-primary');
    if (ctaBtn) {
        ctaBtn.addEventListener('click', () => {
            const target = document.querySelector('.about-section');
            if (target) {
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    }

    // ============================================
    // 7. REVEAL ON SCROLL - Section fade in
    // ============================================
    
    const sections = document.querySelectorAll('.about-section, .mission-section, .team-section, .about-cta');
    const sectionObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '0';
                entry.target.style.transform = 'translateY(50px)';
                entry.target.style.transition = 'all 0.7s cubic-bezier(0.25, 0.46, 0.45, 0.94)';
                
                requestAnimationFrame(() => {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                });
                
                sectionObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });
    
    sections.forEach(section => {
        section.style.opacity = '0';
        section.style.transform = 'translateY(50px)';
        sectionObserver.observe(section);
    });

    // ============================================
    // 8. MORPH GLOW - Pulse effect on active elements
    // ============================================
    
    const missionCards = document.querySelectorAll('.mission-card');
    missionCards.forEach(card => {
        card.addEventListener('mouseenter', () => {
            card.style.boxShadow = '0 8px 40px rgba(74, 144, 226, 0.2)';
            card.style.borderColor = '#4a90e2';
        });
        card.addEventListener('mouseleave', () => {
            card.style.boxShadow = '0 4px 20px rgba(0, 0, 0, 0.06)';
            card.style.borderColor = '#e2e8f0';
        });
    });

    // ============================================
    // 9. TEAM CARD HOVER
    // ============================================
    
    const teamCards = document.querySelectorAll('.team-card');
    teamCards.forEach(card => {
        card.addEventListener('mouseenter', () => {
            card.style.boxShadow = '0 8px 40px rgba(74, 144, 226, 0.15)';
            card.style.borderColor = '#4a90e2';
        });
        card.addEventListener('mouseleave', () => {
            card.style.boxShadow = '0 4px 20px rgba(0, 0, 0, 0.06)';
            card.style.borderColor = '#e2e8f0';
        });
    });

    // ============================================
    // 10. TYPING ANIMATION - Hero subtitle (optional)
    // ============================================
    
    const typingElement = document.querySelector('.about-content .typing-text');
    if (typingElement) {
        const text = typingElement.textContent;
        typingElement.textContent = '';
        let index = 0;
        const typeInterval = setInterval(() => {
            if (index < text.length) {
                typingElement.textContent += text.charAt(index);
                index++;
            } else {
                clearInterval(typeInterval);
            }
        }, 50);
    }

    console.log("✅ About page animations initialized!");
});