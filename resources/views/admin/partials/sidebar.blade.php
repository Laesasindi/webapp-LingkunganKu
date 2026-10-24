@php
    $jumlahBaru = $jumlahBaru ?? \App\Models\Laporan::where('status', 'baru')->count();
@endphp

<aside class="sidebar" id="sidebar">
    <a href="{{ route('admin.dashboard') }}" class="brand">
        <span class="brand-mark">L</span>
        <span>Lingkungan<span class="brand-green">Ku</span></span>
    </a>

    <p class="nav-caption">MENU UTAMA</p>

    <a href="{{ route('admin.dashboard') }}"
       class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <span>▦</span> Dashboard
    </a>

    <a href="{{ route('admin.laporan') }}"
       class="nav-link {{ request()->routeIs('admin.laporan') && !request()->query('status') ? 'active' : '' }}">
        <span>▤</span> Semua Laporan
    </a>

    <a href="{{ route('admin.laporan.baru') }}"
       class="nav-link {{ request()->routeIs('admin.laporan.baru') ? 'active' : '' }}">
        <span>◷</span>
        Laporan Baru
        @if ($jumlahBaru > 0)
            <span class="sidebar-badge">{{ $jumlahBaru }}</span>
        @endif
    </a>

    <a href="{{ route('admin.pengaturan') }}"
       class="nav-link {{ request()->routeIs('admin.pengaturan') ? 'active' : '' }}">
        <span>⚙</span> Pengaturan
    </a>

    <div class="sidebar-bottom">
        <div class="admin-profile">
            <div class="avatar">{{ strtoupper(substr(session('admin_name', 'A'), 0, 1)) }}</div>
            <div class="profile-copy">
                <strong>{{ session('admin_name', 'Admin LingkunganKu') }}</strong>
                <small>Administrator</small>
            </div>
        </div>
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-button">↪ &nbsp;Keluar</button>
        </form>
    </div>
</aside>
