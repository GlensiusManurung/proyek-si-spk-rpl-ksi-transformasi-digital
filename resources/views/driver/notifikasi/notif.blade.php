<!-- Notification Dropdown - DRIVER -->
<style>
.notification-dropdown {
    position: relative;
    display: flex;
    align-items: center;
}

.notification-toggle {
    position: relative;
    background: transparent;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 8px;
    cursor: pointer;
    color: #4a5568;
    padding: 0;
    transition: background 0.2s;
    flex-shrink: 0;
}
.notification-toggle:hover { background: #f0f2f5; }

.notification-badge {
    position: absolute;
    top: 4px;
    right: 4px;
    background: #dc3545;
    color: white;
    font-size: 9px;
    font-weight: 700;
    padding: 1px 4px;
    border-radius: 20px;
    min-width: 16px;
    height: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    pointer-events: none;
    border: 2px solid white;
    line-height: 1;
}

/* ===== MENU — desktop ===== */
.notification-menu {
    display: none;
    position: absolute;
    top: calc(100% + 10px);
    right: 0;
    left: auto;
    width: 320px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.13);
    border: 1px solid #e2e8f0;
    z-index: 99999;
    overflow: hidden;
}
.notification-menu.show { display: block; animation: notifFade 0.2s ease; }
@keyframes notifFade {
    from { opacity:0; transform:translateY(-8px); }
    to   { opacity:1; transform:translateY(0); }
}

/* ===== MENU — mobile ===== */
@media (max-width: 768px) {
    .notification-menu {
        position: fixed;
        top: 65px;
        right: 12px;
        left: auto;
        width: calc(100vw - 24px);
        max-width: 340px;
    }
}

.notification-header {
    padding: 14px 16px;
    font-weight: 600;
    font-size: 14px;
    border-bottom: 1px solid #e9ecef;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #fafafa;
}
.notification-header a {
    font-size: 12px;
    color: #3498db;
    text-decoration: none;
    font-weight: 400;
}

.notification-list {
    max-height: 380px;
    overflow-y: auto;
}
.notification-list::-webkit-scrollbar { width: 4px; }
.notification-list::-webkit-scrollbar-thumb { background: #dee2e6; border-radius: 4px; }

.notification-item {
    display: flex;
    gap: 10px;
    padding: 12px 16px;
    border-bottom: 1px solid #f0f0f0;
    cursor: pointer;
    transition: background 0.15s;
    align-items: flex-start;
}
.notification-item:hover { background: #f8f9fa; }
.notification-item.unread {
    background: #eef6fd;
    border-left: 3px solid #3498db;
}
.notification-item.unread:hover { background: #e3f0fb; }

.notif-icon { font-size: 1.2rem; flex-shrink: 0; margin-top: 1px; }
.notif-body { flex: 1; min-width: 0; }
.notification-title {
    font-weight: 600;
    font-size: 13px;
    margin-bottom: 3px;
    color: #2d3748;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.notification-message {
    font-size: 12px;
    color: #6c757d;
    margin-bottom: 4px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.notification-time { font-size: 11px; color: #adb5bd; }

.notification-footer {
    padding: 11px 16px;
    text-align: center;
    border-top: 1px solid #e9ecef;
    background: #fafafa;
}
.notification-footer a { color: #3498db; text-decoration: none; font-size: 13px; }

.empty-notification { text-align: center; padding: 36px 20px; color: #adb5bd; }
.empty-notification i { font-size: 2rem; display: block; margin-bottom: 8px; }

/* ===== TOAST ===== */
.toast-wrapper {
    position: fixed;
    top: 80px;
    right: 20px;
    z-index: 999999;
    pointer-events: none;
}
.toast-notification {
    background: white;
    border-radius: 12px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.12);
    border-left: 4px solid #3498db;
    margin-bottom: 10px;
    width: 300px;
    transform: translateX(340px);
    transition: transform 0.3s ease;
    pointer-events: all;
    cursor: pointer;
    overflow: hidden;
}
.toast-notification.show { transform: translateX(0); }
.toast-header {
    padding: 10px 14px;
    border-bottom: 1px solid #f0f0f0;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 13px;
    font-weight: 600;
}
.toast-close {
    background: none; border: none;
    font-size: 16px; cursor: pointer;
    color: #adb5bd; line-height: 1; padding: 0 2px;
}
.toast-body { padding: 10px 14px; font-size: 12px; color: #555; }
.toast-time { padding: 6px 14px; font-size: 10px; color: #999; border-top: 1px solid #f0f0f0; }
</style>

<div class="notification-dropdown" id="notificationDropdown">
    <button class="notification-toggle" id="notificationToggle" aria-label="Notifikasi">
        <i class="bi bi-bell" style="font-size:1.2rem;"></i>
        <span class="notification-badge" id="notificationBadge" style="display:none;">0</span>
    </button>

    <div class="notification-menu" id="notificationMenu">
        <div class="notification-header">
            <span>📢 Notifikasi</span>
            <a href="#" id="markAllReadBtn">Tandai semua</a>
        </div>
        <div class="notification-list" id="notificationList">
            <div class="empty-notification">
                <i class="bi bi-inbox"></i>
                <p>Tidak ada notifikasi</p>
            </div>
        </div>
        <div class="notification-footer">
            <a href="{{ route('driver.notifications') }}">Lihat semua notifikasi</a>
        </div>
    </div>
</div>

<div class="toast-wrapper" id="toastContainer"></div>

<script>
window.NotificationSystem = {
    userId: document.querySelector('meta[name="user-id"]')?.content,
    userRole: document.querySelector('meta[name="user-role"]')?.content,
    notifications: [],
    unreadCount: 0,
    lastCheckTime: localStorage.getItem('last_notif_check_driver') || new Date().toISOString(),
    shownNotifIds: JSON.parse(localStorage.getItem('shown_notif_ids_driver') || '[]'),

    load: async function() {
        try {
            const res = await fetch(`/api/notifications?user_id=${this.userId}&role=${this.userRole}`);
            const data = await res.json();
            if (data.success) {
                this.notifications = data.notifications || [];
                this.unreadCount = data.unread_count || 0;
                this.render();
            }
        } catch(e) { console.error('Load notif error:', e); }
    },

    checkNew: async function() {
        try {
            const res = await fetch(`/api/notifications/new?user_id=${this.userId}&role=${this.userRole}&since=${encodeURIComponent(this.lastCheckTime)}`);
            const data = await res.json();
            
            if (data.success && data.notifications && data.notifications.length > 0) {
                const newNotifs = data.notifications.filter(n => !this.shownNotifIds.includes(n.id));
                
                if (newNotifs.length > 0) {
                    console.log('Notifikasi baru:', newNotifs.length);
                    newNotifs.forEach(n => {
                        this.showToast(n);
                        this.shownNotifIds.push(n.id);
                    });
                    localStorage.setItem('shown_notif_ids_driver', JSON.stringify(this.shownNotifIds));
                    await this.load();
                    this.playSound();
                }
            }
            this.lastCheckTime = new Date().toISOString();
            localStorage.setItem('last_notif_check_driver', this.lastCheckTime);
        } catch(e) { console.error('Check new error:', e); }
    },

    showToast: function(notif) {
        const wrap = document.getElementById('toastContainer');
        if (!wrap) return;
        
        if (document.getElementById(`toast_${notif.id}`)) return;
        
        const toast = document.createElement('div');
        toast.className = 'toast-notification';
        toast.id = `toast_${notif.id}`;
        toast.innerHTML = `
            <div class="toast-header">
                <strong>${this.getIcon(notif.type)} ${this.escapeHtml(notif.title)}</strong>
                <button class="toast-close" onclick="this.closest('.toast-notification').remove()">×</button>
            </div>
            <div class="toast-body">${this.escapeHtml(notif.message)}</div>
            <div class="toast-time">${this.formatTime(notif.created_at)}</div>
        `;
        toast.addEventListener('click', (e) => {
            if (!e.target.classList.contains('toast-close')) {
                this.markAsRead(notif.id, notif.link);
            }
        });
        wrap.appendChild(toast);
        setTimeout(() => toast.classList.add('show'), 50);
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 300);
        }, 5000);
    },

    markAsRead: async function(id, link) {
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
                this.load();
            }
        } catch(e) { console.error('Mark read error:', e); }
    },

    markAllRead: async function() {
        try {
            await fetch('/api/notifications/mark-all-read', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content,
                    'Content-Type': 'application/json'
                }
            });
            this.load();
        } catch(e) { console.error('Mark all read error:', e); }
    },

    playSound: function() {
        try {
            const a = new Audio('/sounds/notification.mp3');
            a.volume = 0.3;
            a.play().catch(() => {});
        } catch(e) {}
    },

    getIcon: function(type) {
        const icons = { chat: '💬', pengiriman: '🚚', pengajuan: '📄', sistem: '⚙️' };
        return icons[type] || '🔔';
    },

    formatTime: function(ts) {
        const date = new Date(ts);
        const now = new Date();
        const diff = Math.floor((now - date) / 1000);
        if (diff < 60) return 'Baru saja';
        if (diff < 3600) return `${Math.floor(diff / 60)} menit lalu`;
        if (diff < 86400) return `${Math.floor(diff / 3600)} jam lalu`;
        if (diff < 604800) return `${Math.floor(diff / 86400)} hari lalu`;
        return date.toLocaleDateString('id-ID');
    },

    escapeHtml: function(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    },

    render: function() {
        const badge = document.getElementById('notificationBadge');
        const list = document.getElementById('notificationList');

        if (badge) {
            if (this.unreadCount > 0) {
                badge.textContent = this.unreadCount > 99 ? '99+' : this.unreadCount;
                badge.style.display = 'flex';
            } else {
                badge.style.display = 'none';
            }
        }

        if (!list) return;
        if (this.notifications.length === 0) {
            list.innerHTML = `<div class="empty-notification"><i class="bi bi-inbox"></i><p>Tidak ada notifikasi</p></div>`;
            return;
        }

        list.innerHTML = this.notifications.map(n => `
            <div class="notification-item ${!n.is_read ? 'unread' : ''}"
                 onclick="NotificationSystem.markAsRead(${n.id}, '${n.link || '#'}')">
                <div class="notif-icon">${this.getIcon(n.type)}</div>
                <div class="notif-body">
                    <div class="notification-title">${this.escapeHtml(n.title)}</div>
                    <div class="notification-message">${this.escapeHtml(n.message)}</div>
                    <div class="notification-time">${this.formatTime(n.created_at)}</div>
                </div>
            </div>
        `).join('');
    }
};

document.addEventListener('DOMContentLoaded', function() {
    const toggle = document.getElementById('notificationToggle');
    const menu = document.getElementById('notificationMenu');

    if (toggle && menu) {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            menu.classList.toggle('show');
        });
    }

    document.addEventListener('click', function(e) {
        if (menu && !menu.contains(e.target) && toggle && !toggle.contains(e.target)) {
            menu.classList.remove('show');
        }
    });

    const markAllBtn = document.getElementById('markAllReadBtn');
    if (markAllBtn) {
        markAllBtn.addEventListener('click', function(e) {
            e.preventDefault();
            NotificationSystem.markAllRead();
        });
    }

    NotificationSystem.load();
    setInterval(() => NotificationSystem.checkNew(), 10000);
    setInterval(() => NotificationSystem.load(), 30000);
});
</script>