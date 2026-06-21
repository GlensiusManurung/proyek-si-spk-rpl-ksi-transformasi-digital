document.addEventListener("DOMContentLoaded", () => {
    console.log("Footer Loaded - With Morph Animation");
    
    // Optional: Tambahan efek scroll reveal
    const animateItems = document.querySelectorAll('.animate-item');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animation = 'morphIn 0.6s ease forwards';
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });
    
    animateItems.forEach(item => {
        observer.observe(item);
    });
});