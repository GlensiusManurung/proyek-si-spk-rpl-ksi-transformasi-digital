// ============================================
// ADMIN USERS MANAGEMENT - JAVASCRIPT
// ============================================

import Swal from 'sweetalert2';

document.addEventListener('DOMContentLoaded', function() {
    console.log('Admin Users JS loaded');
    
    initAvatarPreview();
    initDeleteHandler();
    initTableResponsive();
    initSearchFilter();
    initAutoDismissAlert();
});

// Preview avatar
function initAvatarPreview() {
    const avatarInput = document.getElementById('avatar');
    const avatarPreview = document.getElementById('avatarPreview');
    const namaInput = document.getElementById('nama');
    
    if (avatarInput && avatarPreview) {
        avatarInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    if (avatarPreview.tagName === 'IMG') {
                        avatarPreview.src = event.target.result;
                    } else {
                        const img = document.createElement('img');
                        img.src = event.target.result;
                        img.className = 'avatar-preview-img';
                        img.id = 'avatarPreview';
                        avatarPreview.parentNode.replaceChild(img, avatarPreview);
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    }
    
    if (namaInput) {
        namaInput.addEventListener('input', function() {
            const nama = this.value;
            const preview = document.getElementById('avatarPreview');
            if (preview && preview.tagName === 'IMG' && !document.getElementById('avatar')?.files.length) {
                const initials = getInitials(nama);
                preview.src = `https://ui-avatars.com/api/?name=${encodeURIComponent(initials)}&background=0f6bff&color=fff&size=120&bold=true`;
            }
        });
    }
}

// DELETE HANDLER dengan SweetAlert2
function initDeleteHandler() {
    const deleteButtons = document.querySelectorAll('.btn-delete');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const userId = this.dataset.userId;
            const userName = this.dataset.userName;
            const deleteUrl = this.dataset.deleteUrl;
            
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: `User "${userName}" akan dihapus secara permanen!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: '<i class="bi bi-trash me-1"></i> Ya, hapus!',
                cancelButtonText: '<i class="bi bi-x-circle me-1"></i> Batal',
                reverseButtons: true,
                showLoaderOnConfirm: true,
                preConfirm: async () => {
                    try {
                        const response = await fetch(deleteUrl, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            }
                        });
                        
                        const data = await response.json();
                        
                        if (!response.ok) {
                            throw new Error(data.error || 'Gagal menghapus user');
                        }
                        
                        return data;
                    } catch (error) {
                        Swal.showValidationMessage(error.message);
                    }
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: `User "${userName}" berhasil dihapus.`,
                        icon: 'success',
                        confirmButtonColor: '#0f6bff',
                        confirmButtonText: '<i class="bi bi-check-circle me-1"></i> OK'
                    }).then(() => {
                        // Refresh halaman atau hapus baris tabel
                        location.reload();
                    });
                }
            });
        });
    });
}

// Table responsive
function initTableResponsive() {
    const tables = document.querySelectorAll('.data-table');
    tables.forEach(table => {
        const headers = table.querySelectorAll('thead th');
        table.querySelectorAll('tbody tr').forEach(row => {
            row.querySelectorAll('td').forEach((cell, index) => {
                if (headers[index]) {
                    cell.setAttribute('data-label', headers[index].textContent);
                }
            });
        });
    });
}

// Search filter
function initSearchFilter() {
    const searchInput = document.getElementById('searchUser');
    const filterRole = document.getElementById('filterRole');
    const tableBody = document.querySelector('#userTable tbody');
    
    if (searchInput && tableBody) {
        function filterTable() {
            const searchTerm = searchInput.value.toLowerCase();
            const roleFilter = filterRole ? filterRole.value : 'all';
            const rows = tableBody.querySelectorAll('tr:not(.empty-row)');
            
            rows.forEach(row => {
                const nama = row.querySelector('td[data-label="Nama"]')?.textContent.toLowerCase() || '';
                const email = row.querySelector('td[data-label="Email"]')?.textContent.toLowerCase() || '';
                const role = row.querySelector('td[data-label="Role"]')?.textContent.toLowerCase() || '';
                
                const matchesSearch = nama.includes(searchTerm) || email.includes(searchTerm);
                const matchesRole = roleFilter === 'all' || role.includes(roleFilter);
                
                row.style.display = (matchesSearch && matchesRole) ? '' : 'none';
            });
        }
        
        searchInput.addEventListener('keyup', filterTable);
        if (filterRole) filterRole.addEventListener('change', filterTable);
    }
}

// Auto dismiss alert
function initAutoDismissAlert() {
    const alerts = document.querySelectorAll('.alert:not(.alert-permanent)');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        }, 5000);
    });
}

// Helper: ambil initial dari nama
function getInitials(nama) {
    if (!nama) return '';
    const words = nama.trim().split(' ');
    if (words.length === 1) return words[0].charAt(0);
    return words[0].charAt(0) + words[words.length - 1].charAt(0);
}