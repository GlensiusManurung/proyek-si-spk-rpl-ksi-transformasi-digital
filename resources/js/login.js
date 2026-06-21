/**
 * Login Module
 * Mengatur interaksi formulir login
 */

document.addEventListener("DOMContentLoaded", () => {
    const loginForm = document.querySelector("#loginForm"); // Pastikan ID ini ada di HTML
    const loginBtn = document.querySelector(".btn-login");

    if (loginForm) {
        loginForm.addEventListener("submit", (e) => {
            // Contoh handling submit sederhana
            const email = document.querySelector('input[type="email"]')?.value;
            const password = document.querySelector('input[type="password"]')?.value;

            if (!email || !password) {
                e.preventDefault();
                alert("Mohon isi semua field.");
                return;
            }

            // Animasi loading pada tombol
            setLoading(true);
        });
    }

    /**
     * Fungsi untuk mengubah state tombol menjadi loading
     * @param {boolean} isLoading 
     */
    function setLoading(isLoading) {
        if (isLoading) {
            loginBtn.disabled = true;
            loginBtn.innerText = "Processing...";
            loginBtn.style.opacity = "0.7";
            loginBtn.style.cursor = "not-allowed";
        } else {
            loginBtn.disabled = false;
            loginBtn.innerText = "Sign In";
            loginBtn.style.opacity = "1";
            loginBtn.style.cursor = "pointer";
        }
    }

    console.log("Login module initialized successfully.");
});