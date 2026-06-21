{{--
    resources/views/chat/superadmin.blade.php
    Extends: layouts.superadmin
    Requires @stack('styles') dan @stack('scripts') di layout.
--}}
@extends('layouts.superadmin')

@section('title', 'Chat')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/emoji-mart@5.5.2/css/emoji-mart.css" rel="stylesheet">
    {{-- Jika pakai Vite: --}}
    @vite(['resources/css/chat-superadmin.css'])
    {{-- Jika tidak pakai Vite (file statis): --}}
    {{-- <link href="{{ asset('css/chat-superadmin.css') }}" rel="stylesheet"> --}}
@endpush

@section('content')

{{-- ════════════════════════════════════════════════════════
     Lightbox (global, di luar card supaya z-index benar)
════════════════════════════════════════════════════════ --}}
<div id="image-lightbox" role="dialog" aria-modal="true" aria-label="Pratinjau gambar">
    <button id="lightbox-close" aria-label="Tutup lightbox">
        <i class="bi bi-x-lg"></i>
    </button>
    <img id="lightbox-img" src="" alt="Pratinjau gambar">
</div>

<div class="container-fluid px-3 pt-2 pb-3">
    <div class="chat-page-wrapper">

        {{-- ════════════════════════════════════════════════
             SIDEBAR — Daftar Kontak
        ════════════════════════════════════════════════ --}}
        <div class="chat-card chat-sidebar">

            {{-- Header sidebar --}}
            <div class="chat-sidebar-header">
                <h5><i class="bi bi-people-fill me-2"></i>Kontak</h5>
                <div class="chat-search-wrap">
                    <i class="bi bi-search"></i>
                    <input type="text"
                           id="contact-search"
                           placeholder="Cari kontak…"
                           autocomplete="off"
                           aria-label="Cari kontak">
                </div>
            </div>

            {{-- Daftar kontak --}}
            <div class="contact-list" role="list" aria-label="Daftar kontak">

                @forelse($users as $user)
                    @php
                        $avatarUrl = $user->avatar
                            ? Storage::url($user->avatar)
                            : 'https://ui-avatars.com/api/?name=' . urlencode($user->nama) . '&background=2563eb&color=white';

                        $unread = \App\Models\Chat::where('sender_id', $user->user_id)
                                    ->where('receiver_id', Auth::id())
                                    ->where('is_read', false)
                                    ->count();
                    @endphp

                    <a href="#"
                       class="chat-user"
                       role="listitem"
                       data-user-id="{{ $user->user_id }}"
                       data-user-name="{{ $user->nama }}"
                       data-user-role="{{ ucfirst($user->role) }}"
                       data-user-avatar="{{ $avatarUrl }}"
                       aria-label="Chat dengan {{ $user->nama }}">

                        {{-- Avatar --}}
                        <div class="avatar-wrap">
                            <img src="{{ $avatarUrl }}"
                                 alt="{{ $user->nama }}"
                                 loading="lazy">
                            {{-- Mulai sebagai offline; JS akan update via polling --}}
                            <span class="status-dot offline" aria-hidden="true"></span>
                        </div>

                        {{-- Info kontak --}}
                        <div class="contact-info">
                            <span class="contact-name">{{ $user->nama }}</span>
                            <div class="contact-sub">
                                <span class="contact-role">{{ ucfirst($user->role) }}</span>
                                {{-- Label online/offline; JS akan update --}}
                                <span class="contact-online-label offline">Offline</span>
                            </div>
                        </div>

                        {{-- Badge pesan belum dibaca --}}
                        @if($unread > 0)
                            <span class="unread-badge" aria-label="{{ $unread }} pesan belum dibaca">
                                {{ $unread > 99 ? '99+' : $unread }}
                            </span>
                        @endif
                    </a>

                @empty
                    <div class="contact-empty">
                        <i class="bi bi-person-slash fs-2 d-block mb-2"></i>
                        Tidak ada kontak tersedia
                    </div>
                @endforelse

            </div>{{-- /.contact-list --}}
        </div>{{-- /.chat-sidebar --}}

        {{-- ════════════════════════════════════════════════
             MAIN — Area Chat
        ════════════════════════════════════════════════ --}}
        <div class="chat-card chat-main">

            {{-- ── Header ───────────────────────────────── --}}
            <div id="chat-header">
                <div class="chat-header-placeholder">
                    <i class="bi bi-chat-dots d-block"></i>
                    <p>Pilih kontak untuk memulai chat</p>
                </div>
            </div>

            {{-- ── Pesan ────────────────────────────────── --}}
            <div id="chat-messages"
                 role="log"
                 aria-live="polite"
                 aria-relevant="additions"
                 aria-label="Percakapan">
                <div class="messages-empty">
                    <i class="bi bi-chat-dots"></i>
                    <p>Belum ada pesan</p>
                </div>
            </div>

            {{-- ── Footer / Input ───────────────────────── --}}
            <div id="chat-footer" style="display:none;">

                {{-- Typing indicator --}}
                <div id="typing-indicator" aria-live="polite">
                    <i class="bi bi-three-dots me-1"></i> Sedang mengetik…
                </div>

                {{-- File preview --}}
                <div id="file-preview-container" aria-label="Pratinjau file">
                    <div id="file-preview-content"></div>
                </div>

                {{-- Emoji picker mount --}}
                <div id="emoji-picker-container" aria-label="Pilih emoji"></div>

                {{-- Form --}}
                <form id="chat-form" novalidate aria-label="Form kirim pesan">
                    @csrf
                    <input type="hidden" id="receiver-id" name="receiver_id">
                    <input type="file"
                           id="file-input"
                           name="file"
                           style="display:none;"
                           accept="image/*,video/*,.pdf,.doc,.docx,.xls,.xlsx,.zip,.rar">

                    <div class="chat-input-row">

                        <button type="button"
                                id="emoji-btn"
                                class="btn-icon"
                                title="Emoji"
                                aria-label="Buka emoji picker">
                            <i class="bi bi-emoji-smile"></i>
                        </button>

                        <button type="button"
                                id="file-btn"
                                class="btn-icon"
                                title="Lampirkan file"
                                aria-label="Lampirkan file">
                            <i class="bi bi-paperclip"></i>
                        </button>

                        <input type="text"
                               id="message-input"
                               name="message"
                               placeholder="Ketik pesan…"
                               autocomplete="off"
                               aria-label="Tulis pesan">

                        <button type="submit"
                                id="send-btn"
                                aria-label="Kirim pesan">
                            <i class="bi bi-send-fill"></i>
                        </button>

                    </div>
                </form>

            </div>{{-- /#chat-footer --}}

        </div>{{-- /.chat-main --}}

    </div>{{-- /.chat-page-wrapper --}}
</div>{{-- /.container-fluid --}}

@endsection
<script>
    window.ChatConfig = {
        authId: {{ Auth::id() }},
        csrfToken: '{{ csrf_token() }}'
    };
</script>
@push('scripts')
    {{-- EmojiMart --}}
    <script src="https://cdn.jsdelivr.net/npm/emoji-mart@5.5.2/dist/browser.js"></script>

    {{-- Expose PHP config ke JS --}}
    <script>
        window.ChatConfig = {
            authId:          {{ (int) Auth::id() }},
            messagesBaseUrl: '{{ url('/chat/messages') }}',
            sendUrl:         '{{ url('/chat/send') }}',
            onlineUrl:       '{{ url('/chat/online-users') }}',
            csrfToken:       '{{ csrf_token() }}'
        };
    </script>

    {{-- Jika pakai Vite: --}}
    @vite(['resources/js/chat-superadmin.js'])
    {{-- Jika tidak pakai Vite (file statis): --}}
    {{-- <script src="{{ asset('js/chat-superadmin.js') }}"></script> --}}
@endpush