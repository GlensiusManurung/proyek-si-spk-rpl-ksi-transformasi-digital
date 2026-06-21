 @vite(['resources/css/chat-admin.css', 'resources/js/chat-admin.js'])
@extends('layoutadmin.dashboard')

@section('title', 'Chat')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/emoji-mart@5.5.2/css/emoji-mart.css" rel="stylesheet">
    @vite(['resources/css/chat-admin.css'])
@endpush

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="auth-id" content="{{ Auth::id() }}">

<div id="image-lightbox">
    <button style="position:absolute;top:20px;right:30px;color:#fff;font-size:30px;background:none;border:none;cursor:pointer">&times;</button>
    <img id="lightbox-img" src="">
</div>

<div class="container-fluid px-3 pt-2 pb-3">
    <div class="chat-page-wrapper">

        {{-- SIDEBAR --}}
        <div class="chat-card chat-sidebar">
            <div class="chat-sidebar-header">
                <h5><i class="bi bi-people-fill me-2"></i>Kontak</h5>
                <div class="chat-search-wrap">
                    <i class="bi bi-search"></i>
                    <input type="text" id="contact-search" placeholder="Cari kontak…" autocomplete="off">
                </div>
            </div>
            <div class="contact-list">
                @forelse($users as $user)
                    @php
                        $avatarUrl = $user->avatar ? Storage::url($user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->nama) . '&background=2563eb&color=white';
                        $unread = \App\Models\Chat::where('sender_id', $user->user_id)->where('receiver_id', Auth::id())->where('is_read', false)->count();
                    @endphp
                    <a href="#" class="chat-user" data-user-id="{{ $user->user_id }}" data-user-name="{{ $user->nama }}" data-user-role="{{ ucfirst($user->role) }}" data-user-avatar="{{ $avatarUrl }}">
                        <div class="avatar-wrap">
                            <img src="{{ $avatarUrl }}" alt="{{ $user->nama }}" loading="lazy">
                            <span class="status-dot offline"></span>
                        </div>
                        <div class="contact-info">
                            <span class="contact-name">{{ $user->nama }}</span>
                            <div class="contact-sub">
                                <span class="contact-role">{{ ucfirst($user->role) }}</span>
                                <span class="contact-online-label offline">Offline</span>
                            </div>
                        </div>
                        @if($unread > 0)
                            <span class="unread-badge">{{ $unread > 99 ? '99+' : $unread }}</span>
                        @endif
                    </a>
                @empty
                    <div class="contact-empty">
                        <i class="bi bi-person-slash fs-2 d-block mb-2"></i>
                        Tidak ada kontak tersedia
                    </div>
                @endforelse
            </div>
        </div>

        {{-- MAIN CHAT --}}
        <div class="chat-card chat-main">
            <div id="chat-header">
                <div class="chat-header-placeholder">
                    <i class="bi bi-chat-dots d-block"></i>
                    <p>Pilih kontak untuk memulai chat</p>
                </div>
            </div>
            <div id="chat-messages">
                <div class="messages-empty">
                    <i class="bi bi-chat-dots"></i>
                    <p>Belum ada pesan</p>
                </div>
            </div>
            <div id="chat-footer" style="display:none;">
                <div id="file-preview-container">
                    <div id="file-preview-content"></div>
                </div>
                <div id="emoji-picker-container"></div>
                <form id="chat-form">
                    @csrf
                    <input type="hidden" id="receiver-id" name="receiver_id">
                    <input type="file" id="file-input" name="file" style="display:none;" accept="image/*,video/*,.pdf,.doc,.docx,.xls,.xlsx,.zip,.rar">
                    <div class="chat-input-row">
                        <button type="button" id="emoji-btn" class="btn-icon" title="Emoji">
                            <i class="bi bi-emoji-smile"></i>
                        </button>
                        <button type="button" id="file-btn" class="btn-icon" title="Lampirkan file">
                            <i class="bi bi-paperclip"></i>
                        </button>
                        <input type="text" id="message-input" name="message" placeholder="Ketik pesan…" autocomplete="off">
                        <button type="submit" id="send-btn">
                            <i class="bi bi-send-fill"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    window.ChatConfig = {
        authId: {{ Auth::id() }},
        csrfToken: '{{ csrf_token() }}'
    };
</script>
@endsection

@push('scripts')
    @vite(['resources/js/chat-admin.js'])
@endpush