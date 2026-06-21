document.addEventListener("DOMContentLoaded", () => {
    const registrationForm = document.querySelector("#registrationForm");
    const passwordInput = document.querySelector('input[name="password"]');
    const confirmInput = document.querySelector('input[name="password_confirmation"]');

    if (registrationForm) {
        registrationForm.addEventListener("submit", (e) => {
            // Validasi kecocokan password sederhana di sisi client
            if (confirmInput && passwordInput.value !== confirmInput.value) {
                e.preventDefault();
                alert("Konfirmasi password tidak cocok!");
                return;
            }

            console.log("Mendaftarkan akun...");
            // Tambahkan animasi loading pada button
            const submitBtn = registrationForm.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerText = "Memproses...";
            }
        });
    }

    console.log("Halaman daftar akun siap!");
});