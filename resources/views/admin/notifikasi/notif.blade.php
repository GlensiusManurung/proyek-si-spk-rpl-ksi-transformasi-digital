<!-- Notification Dropdown Component untuk Admin & Superadmin -->
<style>
.notification-dropdown { position: relative; }
.notification-toggle {
    background: var(--hover-bg); border: none; border-radius: 50%;
    width: 40px; height: 40px; display: flex; align-items: center;
    justify-content: center; cursor: pointer; position: relative;
    color: var(--text-secondary); transition: all 0.3s;
}
.notification-toggle:hover { background: #3498db; color: white; transform: scale(1.05); }
.notification-badge {
    position: absolute; top: -2px; right: -2px; background: #dc3545;
    color: white; font-size: 10px; font-weight: bold; padding: 2px 6px;
    border-radius: 20px; min-width: 18px; text-align: center;
}
.notification-menu {
    position: absolute; top: 100%; right: 0; background: var(--bg-card);
    border-radius: 16px; box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    min-width: 380px; display: none; z-index: 1000; margin-top: 12px;
    border: 1px solid var(--border-color);
}
.notification-menu.show { display: block; animation: fadeInDown 0.3s ease; }
@keyframes fadeInDown { from { opacity: 0; transform: translateY(-20px); }
    to { opacity: 1; transform: translateY(0); } }
.notification-header { padding: 15px 20px; font-weight: 600;
    border-bottom: 1px solid var(--border-color); display: flex;
    justify-content: space-between; align-items: center; }
.notification-header a { font-size: 12px; color: #3498db; text-decoration: none; }
.notification-list { max-height: 400px; overflow-y: auto; }
.notification-item {
    padding: 15px 20px; border-bottom: 1px solid var(--border-color);
    cursor: pointer; transition: all 0.2s; display: flex; gap: 12px;
}
.notification-item:hover { background: var(--hover-bg); }
.notification-item.unread { background: rgba(52,152,219,0.1); border-left: 3px solid #3498db; }
.notification-icon {
    width: 40px; height: 40px; border-radius: 50%; display: flex;
    align-items: center; justify-content: center; font-size: 1.2rem;
    flex-shrink: 0;
}
.notification-icon.chat { background: rgba(52,152,219,0.15); color: #3498db; }
.notification-icon.pengiriman { background: rgba(46,204,113,0.15); color: #2ecc71; }
.notification-icon.pengajuan { background: rgba(241,196,15,0.15); color: #f1c40f; }
.notification-icon.sistem { background: rgba(155,89,182,0.15); color: #9b59b6; }
.notification-content { flex: 1; }
.notification-title { font-weight: 600; font-size: 14px; margin-bottom: 5px; }
.notification-message { font-size: 13px; color: var(--text-secondary); }
.notification-time { font-size: 11px; color: var(--text-muted); margin-top: 5px; }
.notification-footer { padding: 12px 20px; text-align: center; border-top: 1px solid var(--border-color); }
.empty-notification { text-align: center; padding: 40px 20px; color: var(--text-muted); }
.toast-wrapper { position: fixed; top: 80px; right: 20px; z-index: 1100; }
.toast-notification {
    background: var(--bg-card); border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    border-left: 4px solid #3498db; margin-bottom: 10px; width: 320px;
    transform: translateX(400px); transition: transform 0.3s ease;
}
.toast-notification.show { transform: translateX(0); }
.toast-header { padding: 12px 15px; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; }
.toast-body { padding: 12px 15px; font-size: 13px; }
@media (max-width: 768px) { .notification-menu { min-width: 320px; right: -20px; } }
</style>

<div class="notification-dropdown" id="notificationDropdown">
    <button class="notification-toggle" id="notificationToggle">
        <i class="bi bi-bell-fill"></i>
        <span class="notification-badge" id="notificationBadge" style="display:none;">0</span>
    </button>
    <div class="notification-menu" id="notificationMenu">
        <div class="notification-header">
            <span>📢 Notifikasi</span>
            <a href="#" id="markAllReadBtn">Tandai semua</a>
        </div>
        <div class="notification-list" id="notificationList">
            <div class="empty-notification">
                <i class="bi bi-inbox" style="font-size: 2rem;"></i>
                <p>Tidak ada notifikasi</p>
            </div>
        </div>
        <div class="notification-footer">
            <a href="{{ Auth::user()->role === 'driver' ? route('driver.notifications') : route('admin.notifications') }}">
                Lihat semua notifikasi
            </a>
        </div>
    </div>
</div>
<div class="toast-wrapper" id="toastContainer"></div>

<script>
const NotificationSystem = {
    userId: document.querySelector('meta[name="user-id"]')?.content,
    userRole: document.querySelector('meta[name="user-role"]')?.content,
    notifications: [], unreadCount: 0,
    lastCheckTime: localStorage.getItem('last_notif_check') || new Date().toISOString(),
    
    load: async function() {
        try {
            const res = await fetch(`/api/notifications?user_id=${this.userId}&role=${this.userRole}`);
            const data = await res.json();
            this.notifications = data.notifications || [];
            this.unreadCount = data.unread_count || 0;
            this.render();
        } catch(e) { console.error(e); }
    },
    
    checkNew: async function() {
        try {
            const res = await fetch(`/api/notifications/new?user_id=${this.userId}&role=${this.userRole}&since=${encodeURIComponent(this.lastCheckTime)}`);
            const data = await res.json();
            if (data.notifications?.length) {
                this.load();
                this.playSound();
                data.notifications.forEach(n => this.showToast(n));
            }
            this.lastCheckTime = new Date().toISOString();
            localStorage.setItem('last_notif_check', this.lastCheckTime);
        } catch(e) { console.error(e); }
    },
    
    markAsRead: async function(id, link) {
        try {
            await fetch(`/api/notifications/${id}/read`, { 
                method: 'POST', 
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content } 
            });
            if (link && link !== '#') window.location.href = link;
            else this.load();
        } catch(e) { console.error(e); }
    },
    
    markAllRead: async function() {
        await fetch('/api/notifications/mark-all-read', { 
            method: 'POST', 
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content } 
        });
        this.load();
    },
    
    playSound: function() {
        const audio = new Audio('/sounds/notification.mp3');
        audio.volume = 0.3;
        audio.play().catch(e => console.log('Audio play failed:', e));
    },
    
    getIcon: function(type) {
        const icons = { 'chat': '💬', 'pengiriman': '🚚', 'pengajuan': '📄', 'sistem': '⚙️' };
        const bgColors = { 'chat': 'chat', 'pengiriman': 'pengiriman', 'pengajuan': 'pengajuan', 'sistem': 'sistem' };
        return { icon: icons[type] || '🔔', bg: bgColors[type] || 'sistem' };
    },
    
    formatTime: function(ts) {
        const date = new Date(ts), now = new Date(), diff = Math.floor((now - date) / 1000);
        if (diff < 60) return 'Baru saja';
        if (diff < 3600) return `${Math.floor(diff/60)} menit lalu`;
        if (diff < 86400) return `${Math.floor(diff/3600)} jam lalu`;
        if (diff < 604800) return `${Math.floor(diff/86400)} hari lalu`;
        return date.toLocaleDateString('id-ID');
    },
    
    showToast: function(n) {
        const icon = this.getIcon(n.type);
        const toast = document.createElement('div');
        toast.className = 'toast-notification';
        toast.innerHTML = `
            <div class="toast-header">
                <strong>${icon.icon} ${this.escapeHtml(n.title)}</strong>
                <button onclick="this.closest('.toast-notification').remove()">×</button>
            </div>
            <div class="toast-body">${this.escapeHtml(n.message)}</div>
        `;
        document.getElementById('toastContainer')?.appendChild(toast);
        setTimeout(() => toast.classList.add('show'), 100);
        setTimeout(() => { 
            toast.classList.remove('show'); 
            setTimeout(() => toast.remove(), 300); 
        }, 5000);
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
                badge.style.display = 'block';
            } else {
                badge.style.display = 'none';
            }
        }
        
        if (list) {
            if (this.notifications.length === 0) {
                list.innerHTML = `<div class="empty-notification"><i class="bi bi-inbox" style="font-size: 2rem;"></i><p>Tidak ada notifikasi</p></div>`;
                return;
            }
            
            list.innerHTML = this.notifications.map(n => {
                const icon = this.getIcon(n.type);
                return `
                    <div class="notification-item ${!n.is_read ? 'unread' : ''}" onclick="NotificationSystem.markAsRead(${n.id}, '${n.link || '#'}')">
                        <div class="notification-icon ${icon.bg}">${icon.icon}</div>
                        <div class="notification-content">
                            <div class="notification-title">${this.escapeHtml(n.title)}</div>
                            <div class="notification-message">${this.escapeHtml(n.message)}</div>
                            <div class="notification-time">${this.formatTime(n.created_at)}</div>
                        </div>
                    </div>
                `;
            }).join('');
        }
    }
};

// Event Listeners
document.addEventListener('DOMContentLoaded', function() {
    const toggleBtn = document.getElementById('notificationToggle');
    const menu = document.getElementById('notificationMenu');
    
    if (toggleBtn && menu) {
        toggleBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            menu.classList.toggle('show');
        });
    }
    
    document.addEventListener('click', function(e) {
        if (menu && !menu.contains(e.target) && !toggleBtn?.contains(e.target)) {
            menu.classList.remove('show');
        }
    });
    
    document.getElementById('markAllReadBtn')?.addEventListener('click', function(e) {
        e.preventDefault();
        NotificationSystem.markAllRead();
    });
    
    NotificationSystem.load();
    setInterval(() => NotificationSystem.checkNew(), 10000);
    setInterval(() => NotificationSystem.load(), 30000);
});

window.NotificationSystem = NotificationSystem;
</script>