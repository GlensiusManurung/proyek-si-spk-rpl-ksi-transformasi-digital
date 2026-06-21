// ========== CHAT SUPERADMIN - FULL VERSION ==========
let currentUserId = null;
let refreshInterval = null;
let selectedFile = null;
let isLoadingMessages = false;
let lastMessageId = null;
let isFirstLoad = true;

document.addEventListener('DOMContentLoaded', function() {
    console.log('Chat JS loaded, Auth ID:', window.ChatConfig?.authId);
    
    initEmojiPicker();
    initFileUpload();
    initContactHandlers();
    initMessageForm();
    initSearch();
    initLightbox();
    
    // Update last seen setiap 15 detik
    setInterval(updateLastSeen, 3000);
    
    // Update online status setiap 5 detik
    setInterval(updateOnlineStatus, 1000);
});

function updateLastSeen() {
    fetch('/chat/update-last-seen', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': window.ChatConfig?.csrfToken,
            'Content-Type': 'application/json'
        }
    }).catch(e => console.log('Update last seen error:', e));
}

function updateOnlineStatus() {
    fetch('/chat/online-users')
        .then(response => response.json())
        .then(data => {
            const onlineIds = data.online_ids || [];
            
            document.querySelectorAll('.chat-user').forEach(user => {
                const userId = parseInt(user.dataset.userId);
                const statusDot = user.querySelector('.status-dot');
                const statusLabel = user.querySelector('.contact-online-label');
                const isOnline = onlineIds.includes(userId);
                
                if (statusDot) {
                    statusDot.classList.remove('online', 'offline');
                    statusDot.classList.add(isOnline ? 'online' : 'offline');
                }
                if (statusLabel) {
                    statusLabel.classList.remove('online', 'offline');
                    statusLabel.classList.add(isOnline ? 'online' : 'offline');
                    statusLabel.textContent = isOnline ? 'Online' : 'Offline';
                }
            });
            
            if (currentUserId) {
                const isCurrentOnline = onlineIds.includes(parseInt(currentUserId));
                const hdrDot = document.querySelector('.hdr-dot');
                const hdrText = document.querySelector('.hdr-status-text');
                if (hdrDot) {
                    hdrDot.classList.remove('online', 'offline');
                    hdrDot.classList.add(isCurrentOnline ? 'online' : 'offline');
                }
                if (hdrText) {
                    hdrText.textContent = isCurrentOnline ? 'Online' : 'Offline';
                }
            }
        })
        .catch(e => console.log('Error fetching online status:', e));
}

function initEmojiPicker() {
    const emojiBtn = document.getElementById('emoji-btn');
    const emojiContainer = document.getElementById('emoji-picker-container');
    
    if (!emojiBtn || !emojiContainer) return;
    
    const emojis = ['😀','😃','😄','😁','😆','😅','😂','🤣','😊','😇','🙂','🙃','😉','😌','😍','🥰','😘','😗','😙','😚','😋','😛','😝','😜','🤪','🤨','🧐','🤓','😎','🤩','🥳','😏','😒','😞','😔','😟','😕','🙁','☹️','😣','😖','😫','😩','🥺','😢','😭','😤','😠','😡','🤬','👍','👎','👌','✌️','🤞','🤟','🤘','🤙','👈','👉','👆','👇','☝️','✋','🤚','🖐️','🖖','👋','💪','❤️','🧡','💛','💚','💙','💜','🖤','🤍','🤎','💔','🔥','✨','⭐','🌟','💫','⚡','🎉','🎊','🎈','🎁','🎂','🍕','🍔','☕','🚗','✈️','🚀','💯','❗','❓'];
    
    let grid = '<div style="display:grid;grid-template-columns:repeat(8,1fr);gap:4px;padding:12px;max-height:220px;overflow-y:auto;">';
    emojis.forEach(emoji => {
        grid += `<button type="button" class="emoji-item" style="font-size:24px;padding:6px;border:none;background:transparent;cursor:pointer;border-radius:8px;">${emoji}</button>`;
    });
    grid += '</div>';
    
    emojiContainer.innerHTML = `<div style="padding:8px 12px;border-bottom:1px solid #e5e7eb;"><span style="font-size:13px;">😊 Pilih Emoji</span><button id="close-emoji-picker" style="float:right;background:none;border:none;font-size:18px;cursor:pointer;">&times;</button></div>${grid}`;
    
    emojiContainer.querySelectorAll('.emoji-item').forEach(btn => {
        btn.addEventListener('click', () => {
            const input = document.getElementById('message-input');
            if (input) {
                const cursorPos = input.selectionStart;
                input.value = input.value.substring(0, cursorPos) + btn.textContent + input.value.substring(cursorPos);
                input.selectionStart = cursorPos + btn.textContent.length;
                input.focus();
            }
            emojiContainer.style.display = 'none';
        });
    });
    
    document.getElementById('close-emoji-picker')?.addEventListener('click', () => emojiContainer.style.display = 'none');
    
    emojiBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        emojiContainer.style.display = emojiContainer.style.display === 'flex' ? 'none' : 'flex';
    });
    
    document.addEventListener('click', (e) => {
        if (!emojiContainer.contains(e.target) && e.target !== emojiBtn) {
            emojiContainer.style.display = 'none';
        }
    });
}

function initFileUpload() {
    const fileBtn = document.getElementById('file-btn');
    const fileInput = document.getElementById('file-input');
    
    if (fileBtn && fileInput) {
        fileBtn.addEventListener('click', () => fileInput.click());
        
        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;
            
            if (file.size > 50 * 1024 * 1024) {
                alert('Ukuran file maksimal 50MB!');
                fileInput.value = '';
                return;
            }
            
            selectedFile = file;
            showFilePreview(file);
        });
    }
}

function showFilePreview(file) {
    const container = document.getElementById('file-preview-container');
    const content = document.getElementById('file-preview-content');
    const fileName = file.name;
    const fileSize = formatFileSize(file.size);
    
    if (!container || !content) return;
    
    if (file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = function(e) {
            content.innerHTML = `<div class="fp-inner"><img src="${e.target.result}" class="fp-thumb-img"><div class="fp-details"><strong>${escapeHtml(fileName)}</strong><small>${fileSize}</small><div class="fp-ready">📷 Gambar akan dikirim</div></div><button type="button" id="fp-cancel">&times;</button></div>`;
            container.style.display = 'block';
            document.getElementById('fp-cancel')?.addEventListener('click', clearSelectedFile);
        };
        reader.readAsDataURL(file);
    } else if (file.type.startsWith('video/')) {
        content.innerHTML = `<div class="fp-inner"><div class="fp-icon"><i class="bi bi-camera-reels"></i></div><div class="fp-details"><strong>${escapeHtml(fileName)}</strong><small>${fileSize}</small><div class="fp-ready">🎬 Video akan dikirim</div></div><button type="button" id="fp-cancel">&times;</button></div>`;
        container.style.display = 'block';
        document.getElementById('fp-cancel')?.addEventListener('click', clearSelectedFile);
    } else {
        let icon = 'bi-file-earmark';
        if (fileName.endsWith('.pdf')) icon = 'bi-file-earmark-pdf';
        else if (fileName.match(/\.(doc|docx)$/)) icon = 'bi-file-earmark-word';
        else if (fileName.match(/\.(xls|xlsx)$/)) icon = 'bi-file-earmark-excel';
        
        content.innerHTML = `<div class="fp-inner"><div class="fp-icon"><i class="bi ${icon}"></i></div><div class="fp-details"><strong>${escapeHtml(fileName)}</strong><small>${fileSize}</small><div class="fp-ready">📎 File siap dikirim</div></div><button type="button" id="fp-cancel">&times;</button></div>`;
        container.style.display = 'block';
        document.getElementById('fp-cancel')?.addEventListener('click', clearSelectedFile);
    }
}

function clearSelectedFile() {
    selectedFile = null;
    const fileInput = document.getElementById('file-input');
    const container = document.getElementById('file-preview-container');
    
    if (fileInput) fileInput.value = '';
    if (container) {
        container.style.display = 'none';
        const content = document.getElementById('file-preview-content');
        if (content) content.innerHTML = '';
    }
}

function initContactHandlers() {
    document.querySelectorAll('.chat-user').forEach(contact => {
        contact.addEventListener('click', function(e) {
            e.preventDefault();
            
            document.querySelectorAll('.chat-user').forEach(c => c.classList.remove('active'));
            this.classList.add('active');
            
            currentUserId = this.dataset.userId;
            document.getElementById('receiver-id').value = currentUserId;
            
            document.getElementById('chat-header').innerHTML = `
                <div class="chat-header-info">
                    <img src="${this.dataset.userAvatar}" alt="${this.dataset.userName}">
                    <div>
                        <h5 class="hdr-name">${escapeHtml(this.dataset.userName)}</h5>
                        <div class="hdr-status">
                            <span class="hdr-dot offline"></span>
                            <span class="hdr-status-text">Offline</span>
                        </div>
                    </div>
                </div>
            `;
            
            document.getElementById('chat-footer').style.display = 'block';
            clearSelectedFile();
            
            // Mark all messages as read when opening chat
            markAllAsRead(currentUserId);
            
            lastMessageId = null;
            isFirstLoad = true;
            loadMessagesFull(currentUserId);
            
            if (refreshInterval) clearInterval(refreshInterval);
            refreshInterval = setInterval(() => {
                if (currentUserId) checkNewMessages(currentUserId);
            }, 3000);
        });
    });
}

function markAllAsRead(senderId) {
    fetch('/chat/mark-all-as-read', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': window.ChatConfig?.csrfToken,
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ sender_id: senderId })
    }).then(() => {
        // Update badge di sidebar
        const badge = document.querySelector(`.chat-user[data-user-id="${senderId}"] .unread-badge`);
        if (badge) badge.remove();
    }).catch(e => console.log('Mark all as read error:', e));
}

function loadMessagesFull(userId) {
    if (isLoadingMessages) return;
    isLoadingMessages = true;
    
    fetch(`/chat/messages/${userId}`)
        .then(res => res.json())
        .then(messages => {
            const container = document.getElementById('chat-messages');
            if (!container) return;
            
            container.innerHTML = '';
            
            if (messages.length === 0) {
                container.innerHTML = '<div class="messages-empty"><i class="bi bi-chat-dots"></i><p>Belum ada pesan</p></div>';
                lastMessageId = null;
            } else {
                let lastDate = null;
                messages.forEach(msg => {
                    const msgDate = new Date(msg.created_at).toLocaleDateString('id-ID');
                    if (lastDate !== msgDate) {
                        lastDate = msgDate;
                        const dateDiv = document.createElement('div');
                        dateDiv.className = 'date-separator';
                        dateDiv.innerHTML = `<span>${msgDate}</span>`;
                        container.appendChild(dateDiv);
                    }
                    appendMessageToContainer(msg, container);
                });
                lastMessageId = messages[messages.length - 1].id;
                container.scrollTop = container.scrollHeight;
            }
            isFirstLoad = false;
            isLoadingMessages = false;
        })
        .catch(error => { console.error('Error:', error); isLoadingMessages = false; });
}

function checkNewMessages(userId) {
    if (isLoadingMessages || isFirstLoad) return;
    
    fetch(`/chat/messages/${userId}?after_id=${lastMessageId || 0}`)
        .then(res => res.json())
        .then(messages => {
            if (messages.length > 0) {
                const container = document.getElementById('chat-messages');
                const wasAtBottom = container.scrollHeight - container.scrollTop <= container.clientHeight + 50;
                
                const emptyDiv = container.querySelector('.messages-empty');
                if (emptyDiv) emptyDiv.remove();
                
                let newUnreadCount = 0;
                
                messages.forEach(msg => {
                    if (!document.querySelector(`.message[data-msg-id="${msg.id}"]`)) {
                        appendMessageToContainer(msg, container);
                        if (!msg.is_read && msg.sender_id != window.ChatConfig?.authId) {
                            newUnreadCount++;
                        }
                    }
                });
                
                // Update badge if there are new unread messages
                if (newUnreadCount > 0 && currentUserId != userId) {
                    const badge = document.querySelector(`.chat-user[data-user-id="${userId}"] .unread-badge`);
                    if (badge) {
                        let oldCount = parseInt(badge.textContent) || 0;
                        badge.textContent = (oldCount + newUnreadCount) > 99 ? '99+' : (oldCount + newUnreadCount);
                    } else {
                        const badgeHtml = `<span class="unread-badge">${newUnreadCount > 99 ? '99+' : newUnreadCount}</span>`;
                        document.querySelector(`.chat-user[data-user-id="${userId}"]`).insertAdjacentHTML('beforeend', badgeHtml);
                    }
                }
                
                lastMessageId = messages[messages.length - 1].id;
                if (wasAtBottom) container.scrollTop = container.scrollHeight;
            }
        })
        .catch(e => console.error('Error checking messages:', e));
}

function appendMessageToContainer(msg, container) {
    const isSent = msg.sender_id == window.ChatConfig?.authId;
    const div = document.createElement('div');
    div.className = `message ${isSent ? 'message-sent' : 'message-received'}`;
    div.setAttribute('data-msg-id', msg.id);
    
    let html = `<div class="msg-bubble">`;
    if (!isSent && msg.sender) html += `<div class="msg-sender-name">${escapeHtml(msg.sender.nama)}</div>`;
    if (msg.message) html += `<div>${escapeHtml(msg.message)}</div>`;
    
    if (msg.file_path) {
        if (msg.is_image) {
            html += `<img src="${msg.file_url}" class="msg-image" onclick="window.openLightbox('${msg.file_url}')">`;
        } else if (msg.file_type && msg.file_type.startsWith('video/')) {
            html += `<video controls class="msg-video"><source src="${msg.file_url}" type="${msg.file_type}"></video>`;
        } else {
            html += `<a href="${msg.file_url}" download="${msg.file_name}" class="msg-file"><i class="bi bi-file-earmark-fill fs-3"></i><div class="msg-file-info"><strong>${escapeHtml(msg.file_name)}</strong><small>${msg.file_size || ''}</small></div></a>`;
        }
    }
    
    // Format waktu dengan tanggal
    const msgDate = new Date(msg.created_at);
    const today = new Date();
    const isToday = msgDate.toDateString() === today.toDateString();
    
    let timeStr = '';
    if (isToday) {
        timeStr = msg.created_at_formatted || msgDate.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
    } else {
        timeStr = msgDate.toLocaleDateString('id-ID', { day: 'numeric', month: 'short' }) + ' ' + msgDate.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
    }
    
    html += `<div class="msg-time">${timeStr}`;
    
    // Read receipt (centang) untuk pesan yang dikirim
    if (isSent) {
        if (msg.is_read) {
            html += ` <i class="bi bi-check2-all" style="font-size: 10px;" title="Dibaca"></i>`;
        } else {
            html += ` <i class="bi bi-check2" style="font-size: 10px;" title="Terkirim"></i>`;
        }
    }
    
    html += `</div>`;
    html += `</div>`;
    
    div.innerHTML = html;
    container.appendChild(div);
}

function initMessageForm() {
    const form = document.getElementById('chat-form');
    if (!form) return;
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const message = document.getElementById('message-input')?.value.trim() || '';
        const receiverId = document.getElementById('receiver-id')?.value;
        
        if ((!message && !selectedFile) || !receiverId) {
            if (!receiverId) alert('Pilih kontak dulu!');
            return;
        }
        
        const formData = new FormData();
        formData.append('receiver_id', receiverId);
        if (message) formData.append('message', message);
        if (selectedFile) formData.append('file', selectedFile);
        
        const sendBtn = document.getElementById('send-btn');
        sendBtn.disabled = true;
        sendBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
        
        fetch('/chat/send', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': window.ChatConfig?.csrfToken, 'Accept': 'application/json' },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                document.getElementById('message-input').value = '';
                clearSelectedFile();
                if (data.message && currentUserId) {
                    const container = document.getElementById('chat-messages');
                    const emptyDiv = container.querySelector('.messages-empty');
                    if (emptyDiv) emptyDiv.remove();
                    appendMessageToContainer(data.message, container);
                    container.scrollTop = container.scrollHeight;
                    if (data.message.id) lastMessageId = data.message.id;
                }
            } else {
                alert('Gagal kirim: ' + (data.error || 'Error'));
            }
            sendBtn.disabled = false;
            sendBtn.innerHTML = '<i class="bi bi-send-fill"></i>';
        })
        .catch(err => {
            console.error(err);
            alert('Gagal kirim pesan!');
            sendBtn.disabled = false;
            sendBtn.innerHTML = '<i class="bi bi-send-fill"></i>';
        });
    });
    
    document.getElementById('message-input')?.addEventListener('keypress', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            document.getElementById('chat-form').dispatchEvent(new Event('submit'));
        }
    });
}

function initSearch() {
    const searchInput = document.getElementById('contact-search');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            const term = this.value.toLowerCase();
            document.querySelectorAll('.chat-user').forEach(contact => {
                const name = contact.dataset.userName?.toLowerCase() || '';
                contact.style.display = name.includes(term) ? 'flex' : 'none';
            });
        });
    }
}

function initLightbox() {
    const lightbox = document.getElementById('image-lightbox');
    const closeBtn = document.getElementById('lightbox-close');
    if (lightbox && closeBtn) {
        closeBtn.addEventListener('click', () => lightbox.classList.remove('show'));
        lightbox.addEventListener('click', (e) => { if (e.target === lightbox) lightbox.classList.remove('show'); });
    }
}

function formatFileSize(bytes) {
    if (bytes >= 1073741824) return (bytes / 1073741824).toFixed(2) + ' GB';
    if (bytes >= 1048576) return (bytes / 1048576).toFixed(2) + ' MB';
    if (bytes >= 1024) return (bytes / 1024).toFixed(2) + ' KB';
    return bytes + ' bytes';
}

function escapeHtml(text) {
    if (!text) return '';
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

window.openLightbox = function(url) {
    const lightbox = document.getElementById('image-lightbox');
    const img = document.getElementById('lightbox-img');
    if (lightbox && img) {
        img.src = url;
        lightbox.classList.add('show');
    }
};


