@extends('layoutdriver.dashboard')  

@section('title', 'Semua Notifikasi')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5><i class="bi bi-bell-fill me-2"></i> Semua Notifikasi</h5>
            <div class="d-flex gap-2">
                <button class="btn btn-sm btn-danger" id="deleteSelectedBtn" style="display: none;">
                    <i class="bi bi-trash"></i> Hapus Terpilih
                </button>
                <button class="btn btn-sm btn-warning" id="deleteAllBtn">
                    <i class="bi bi-trash3"></i> Hapus Semua
                </button>
                <button class="btn btn-sm btn-primary" id="markAllReadPage">
                    <i class="bi bi-check2-all"></i> Tandai semua
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="mb-3" id="selectAllContainer">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="selectAllCheckbox">
                    <label class="form-check-label" for="selectAllCheckbox">Pilih Semua</label>
                </div>
            </div>
            <div id="notificationListPage">
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="mt-2">Memuat notifikasi...</p>
                </div>
            </div>
            <div class="mt-3 text-center" id="loadMoreContainer" style="display: none;">
                <button class="btn btn-outline-primary" id="loadMoreBtn">Load More</button>
            </div>
        </div>
    </div>
</div>

<style>
.notification-item-page {
    display: flex; gap: 15px; padding: 15px; border-bottom: 1px solid #e9ecef;
    cursor: pointer; transition: background 0.2s;
    align-items: center;
}
.notification-item-page:hover { background: #f8f9fa; }
.notification-item-page.unread { background: rgba(52,152,219,0.05); border-left: 3px solid #3498db; }
.notification-checkbox { flex-shrink: 0; }
.notification-icon-page {
    width: 45px; height: 45px; border-radius: 50%; display: flex;
    align-items: center; justify-content: center; font-size: 1.3rem; flex-shrink: 0;
    background: rgba(52,152,219,0.1);
}
.notification-content-page { flex: 1; }
.notification-title-page { font-weight: 600; font-size: 15px; margin-bottom: 5px; }
.notification-message-page { font-size: 13px; color: #6c757d; margin-bottom: 5px; }
.notification-time-page { font-size: 11px; color: #adb5bd; }
.notification-delete-btn {
    background: none;
    border: none;
    color: #dc3545;
    cursor: pointer;
    font-size: 1.2rem;
    padding: 5px 10px;
    border-radius: 5px;
    transition: all 0.2s;
}
.notification-delete-btn:hover {
    background: #dc3545;
    color: white;
}
</style>

<script>
let currentPage = 1;
let isLoading = false;
let hasMore = true;
let selectedIds = new Set();

function getIcon(type) {
    const icons = { 'chat': '💬', 'pengiriman': '🚚', 'pengajuan': '📄', 'sistem': '⚙️' };
    return icons[type] || '🔔';
}

function formatTime(timestamp) {
    const date = new Date(timestamp), now = new Date(), diff = Math.floor((now - date) / 1000);
    if (diff < 60) return 'Baru saja';
    if (diff < 3600) return `${Math.floor(diff/60)} menit lalu`;
    if (diff < 86400) return `${Math.floor(diff/3600)} jam lalu`;
    if (diff < 604800) return `${Math.floor(diff/86400)} hari lalu`;
    return date.toLocaleDateString('id-ID');
}

function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

async function loadNotifications(page = 1, append = false) {
    if (isLoading) return;
    isLoading = true;
    
    try {
        const response = await fetch(`/api/notifications/all?page=${page}&limit=20`);
        const data = await response.json();
        
        const container = document.getElementById('notificationListPage');
        const loadMoreContainer = document.getElementById('loadMoreContainer');
        const selectAllContainer = document.getElementById('selectAllContainer');
        
        if (data.notifications && data.notifications.length > 0) {
            if (selectAllContainer) selectAllContainer.style.display = 'block';
            
            const html = data.notifications.map(notif => `
                <div class="notification-item-page ${!notif.is_read ? 'unread' : ''}" data-id="${notif.id}">
                    <div class="notification-checkbox">
                        <input type="checkbox" class="form-check-input notification-checkbox-item" value="${notif.id}" onchange="toggleSelect(${notif.id}, this.checked)">
                    </div>
                    <div class="notification-icon-page" onclick="markAsReadAndRedirect(${notif.id}, '${notif.link || '#'}')">${getIcon(notif.type)}</div>
                    <div class="notification-content-page" onclick="markAsReadAndRedirect(${notif.id}, '${notif.link || '#'}')">
                        <div class="notification-title-page">${escapeHtml(notif.title)}</div>
                        <div class="notification-message-page">${escapeHtml(notif.message)}</div>
                        <div class="notification-time-page">${formatTime(notif.created_at)}</div>
                    </div>
                    <div>
                        <button class="notification-delete-btn" onclick="event.stopPropagation(); deleteSingle(${notif.id})" title="Hapus notifikasi">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            `).join('');
            
            if (append) {
                container.insertAdjacentHTML('beforeend', html);
            } else {
                container.innerHTML = html;
                selectedIds.clear();
                updateDeleteButton();
            }
            
            hasMore = data.has_more;
            if (hasMore && loadMoreContainer) {
                loadMoreContainer.style.display = 'block';
            } else if (loadMoreContainer) {
                loadMoreContainer.style.display = 'none';
            }
        } else if (!append) {
            container.innerHTML = `
                <div class="text-center py-5">
                    <i class="bi bi-inbox" style="font-size: 3rem; opacity: 0.5;"></i>
                    <p class="mt-2">Tidak ada notifikasi</p>
                </div>
            `;
            if (selectAllContainer) selectAllContainer.style.display = 'none';
        }
    } catch (error) {
        console.error('Error loading notifications:', error);
        document.getElementById('notificationListPage').innerHTML = `
            <div class="text-center py-5 text-danger">
                <i class="bi bi-exclamation-triangle" style="font-size: 3rem;"></i>
                <p class="mt-2">Gagal memuat notifikasi</p>
            </div>
        `;
    } finally {
        isLoading = false;
    }
}

function toggleSelect(id, checked) {
    if (checked) {
        selectedIds.add(id);
    } else {
        selectedIds.delete(id);
    }
    updateDeleteButton();
    updateSelectAllCheckbox();
}

function updateDeleteButton() {
    const deleteBtn = document.getElementById('deleteSelectedBtn');
    if (deleteBtn) {
        deleteBtn.style.display = selectedIds.size > 0 ? 'inline-block' : 'none';
    }
}

function updateSelectAllCheckbox() {
    const checkboxes = document.querySelectorAll('.notification-checkbox-item');
    const selectAll = document.getElementById('selectAllCheckbox');
    if (selectAll && checkboxes.length > 0) {
        selectAll.checked = checkboxes.length === selectedIds.size;
        selectAll.indeterminate = selectedIds.size > 0 && selectedIds.size < checkboxes.length;
    }
}

function selectAll() {
    const selectAllCheckbox = document.getElementById('selectAllCheckbox');
    const checkboxes = document.querySelectorAll('.notification-checkbox-item');
    
    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAllCheckbox.checked;
        const id = parseInt(checkbox.value);
        if (selectAllCheckbox.checked) {
            selectedIds.add(id);
        } else {
            selectedIds.delete(id);
        }
    });
    updateDeleteButton();
}

async function deleteSingle(id) {
    if (!confirm('Yakin ingin menghapus notifikasi ini? Data akan hilang permanen.')) return;
    
    try {
        const response = await fetch('/api/notifications', {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ ids: [id] })
        });
        
        const data = await response.json();
        
        if (data.success) {
            currentPage = 1;
            selectedIds.clear();
            await loadNotifications(1, false);
            
            if (window.NotificationSystem) {
                window.NotificationSystem.load();
            }
            
            showAlert('success', data.message);
        } else {
            showAlert('danger', data.message || 'Gagal menghapus notifikasi');
        }
    } catch (error) {
        console.error('Error deleting notification:', error);
        showAlert('danger', 'Gagal menghapus notifikasi');
    }
}

async function deleteSelected() {
    if (selectedIds.size === 0) return;
    if (!confirm(`Yakin ingin menghapus ${selectedIds.size} notifikasi yang dipilih? Data akan hilang permanen.`)) return;
    
    const ids = Array.from(selectedIds);
    
    try {
        const response = await fetch('/api/notifications', {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ ids: ids })
        });
        
        const data = await response.json();
        
        if (data.success) {
            currentPage = 1;
            selectedIds.clear();
            await loadNotifications(1, false);
            
            if (window.NotificationSystem) {
                window.NotificationSystem.load();
            }
            
            showAlert('success', data.message);
        } else {
            showAlert('danger', data.message || 'Gagal menghapus notifikasi');
        }
    } catch (error) {
        console.error('Error deleting notifications:', error);
        showAlert('danger', 'Gagal menghapus notifikasi');
    }
}

async function deleteAll() {
    if (!confirm('Yakin ingin menghapus SEMUA notifikasi? Tindakan ini tidak dapat dibatalkan dan data akan hilang permanen!')) return;
    
    try {
        const response = await fetch('/api/notifications/all', {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
                'Content-Type': 'application/json'
            }
        });
        
        const data = await response.json();
        
        if (data.success) {
            currentPage = 1;
            selectedIds.clear();
            await loadNotifications(1, false);
            
            if (window.NotificationSystem) {
                window.NotificationSystem.load();
            }
            
            showAlert('success', data.message);
        } else {
            showAlert('danger', data.message || 'Gagal menghapus semua notifikasi');
        }
    } catch (error) {
        console.error('Error deleting all notifications:', error);
        showAlert('danger', 'Gagal menghapus semua notifikasi');
    }
}

async function markAsReadAndRedirect(id, link) {
    try {
        await fetch(`/api/notifications/${id}/read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
                'Content-Type': 'application/json'
            }
        });
        
        if (link && link !== '#') {
            window.location.href = link;
        } else {
            loadNotifications(1, false);
            if (window.NotificationSystem) {
                window.NotificationSystem.load();
            }
        }
    } catch (error) {
        console.error('Error:', error);
    }
}

function showAlert(type, message) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    const container = document.querySelector('.card-body');
    const notificationList = document.getElementById('notificationListPage');
    container.insertBefore(alertDiv, notificationList);
    
    setTimeout(() => alertDiv.remove(), 3000);
}

// Event Listeners
document.getElementById('markAllReadPage')?.addEventListener('click', async function() {
    try {
        await fetch('/api/notifications/mark-all-read', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
                'Content-Type': 'application/json'
            }
        });
        loadNotifications(1, false);
        if (window.NotificationSystem) {
            window.NotificationSystem.load();
        }
        showAlert('success', 'Semua notifikasi telah ditandai sudah dibaca');
    } catch (error) {
        console.error('Error:', error);
        showAlert('danger', 'Gagal menandai notifikasi');
    }
});

document.getElementById('selectAllCheckbox')?.addEventListener('change', function() {
    selectAll();
});

document.getElementById('deleteSelectedBtn')?.addEventListener('click', deleteSelected);
document.getElementById('deleteAllBtn')?.addEventListener('click', deleteAll);

document.getElementById('loadMoreBtn')?.addEventListener('click', function() {
    if (!isLoading && hasMore) {
        currentPage++;
        loadNotifications(currentPage, true);
    }
});

loadNotifications(1, false);
</script>
@endsection