<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan - Admin LingkunganKu</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <style>
        /* ── Tab navigation ─────────────────────────────────────── */
        .setting-tabs {
            display: flex;
            gap: 4px;
            margin-bottom: 24px;
            border-bottom: 2px solid var(--border);
        }
        .setting-tab {
            padding: 10px 20px;
            font-size: 13.5px;
            font-weight: 600;
            color: var(--muted);
            cursor: pointer;
            border: none;
            background: transparent;
            border-bottom: 2px solid transparent;
            margin-bottom: -2px;
            transition: color .15s, border-color .15s;
        }
        .setting-tab.active, .setting-tab:hover {
            color: var(--blue);
            border-bottom-color: var(--blue);
        }
        .tab-panel { display: none; }
        .tab-panel.active { display: block; }

        /* ── Form rows ──────────────────────────────────────────── */
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }
        .form-group { margin-bottom: 18px; }
        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: #374151;
            margin-bottom: 7px;
        }
        .form-group input {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid var(--border);
            border-radius: 10px;
            font-size: 14px;
            outline: none;
            background: white;
            transition: border-color .15s, box-shadow .15s;
            font-family: inherit;
        }
        .form-group input:focus {
            border-color: var(--blue);
            box-shadow: 0 0 0 3px rgba(37,99,235,.1);
        }
        .form-group input.is-error { border-color: #dc2626; }
        .field-error {
            font-size: 12px;
            color: #dc2626;
            margin-top: 4px;
        }
        .form-divider {
            border: none;
            border-top: 1px solid var(--border);
            margin: 24px 0;
        }
        .btn-save {
            padding: 11px 28px;
            border: none;
            border-radius: 10px;
            background: var(--blue);
            color: white;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: background .15s;
        }
        .btn-save:hover { background: var(--blue-dark); }

        /* ── Toggle switch ──────────────────────────────────────── */
        .toggle-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 0;
            border-bottom: 1px solid var(--border);
        }
        .toggle-row:last-child { border-bottom: none; }
        .toggle-label { font-size: 14px; font-weight: 600; color: #1e293b; }
        .toggle-desc  { font-size: 12.5px; color: var(--muted); margin-top: 3px; }
        .toggle-switch {
            position: relative;
            width: 46px;
            height: 26px;
            flex-shrink: 0;
        }
        .toggle-switch input { opacity: 0; width: 0; height: 0; }
        .toggle-slider {
            position: absolute;
            inset: 0;
            background: #cbd5e1;
            border-radius: 999px;
            cursor: pointer;
            transition: background .2s;
        }
        .toggle-slider::before {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            left: 3px;
            top: 3px;
            background: white;
            border-radius: 50%;
            transition: transform .2s;
            box-shadow: 0 1px 4px rgba(0,0,0,.2);
        }
        .toggle-switch input:checked + .toggle-slider { background: var(--blue); }
        .toggle-switch input:checked + .toggle-slider::before { transform: translateX(20px); }

        /* ── Sistem info ────────────────────────────────────────── */
        .info-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 0;
            border-bottom: 1px solid var(--border);
            font-size: 14px;
        }
        .info-row:last-child { border-bottom: none; }
        .info-label { color: var(--muted); font-weight: 600; }
        .info-value { color: #1e293b; font-weight: 600; }
        .badge-ok  { padding:3px 12px;border-radius:20px;background:#dcfce7;color:#15803d;font-size:12px;font-weight:700; }
        .badge-err { padding:3px 12px;border-radius:20px;background:#fee2e2;color:#dc2626;font-size:12px;font-weight:700; }

        /* ── Alert ─────────────────────────────────────────────── */
        .alert-ok  { padding:12px 18px;border-radius:10px;background:#dcfce7;border:1px solid #86efac;color:#15803d;margin-bottom:20px;font-size:13.5px;font-weight:600; }
        .alert-err { padding:12px 18px;border-radius:10px;background:#fee2e2;border:1px solid #fca5a5;color:#dc2626;margin-bottom:20px;font-size:13.5px; }

        @media (max-width: 640px) {
            .form-row { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
<div class="admin-page">
    @include('admin.partials.sidebar')

    <main class="admin-main">

        {{-- Topbar --}}
        <header class="topbar">
            <div style="display:flex;align-items:center;gap:12px;">
                <button class="hamburger" id="hamburger" aria-label="Buka menu">
                    <span></span><span></span><span></span>
                </button>
                <div>
                    <p class="eyebrow">ADMINISTRATOR</p>
                    <h1>Pengaturan</h1>
                </div>
            </div>
            <div class="topbar-user">
                <span class="status-dot"></span>
                <span>{{ session('admin_name', 'Admin LingkunganKu') }}</span>
            </div>
        </header>

        {{-- Flash messages --}}
        @if (session('sukses_profil'))
            <div class="alert-ok">✓ {{ session('sukses_profil') }}</div>
        @endif
        @if (session('sukses_notif'))
            <div class="alert-ok">✓ {{ session('sukses_notif') }}</div>
        @endif

        {{-- Tab Navigation --}}
        @php $tabAktif = session('tab_aktif', 'profil'); @endphp

        <div class="setting-tabs">
            <button class="setting-tab {{ $tabAktif === 'profil' ? 'active' : '' }}"
                    onclick="bukaTab('profil')">👤 Profil Admin</button>
            <button class="setting-tab {{ $tabAktif === 'notifikasi' ? 'active' : '' }}"
                    onclick="bukaTab('notifikasi')">🔔 Notifikasi</button>
            <button class="setting-tab {{ $tabAktif === 'sistem' ? 'active' : '' }}"
                    onclick="bukaTab('sistem')">🖥️ Informasi Sistem</button>
        </div>

        {{-- ═══════════ TAB 1: PROFIL ═══════════ --}}
        <div class="tab-panel {{ $tabAktif === 'profil' ? 'active' : '' }}" id="tab-profil">
            <section class="content-panel">
                <div class="panel-heading" style="margin-bottom:24px;">
                    <div>
                        <h2>Profil Admin</h2>
                        <p>Ubah nama, email, dan kata sandi akun administrator.</p>
                    </div>
                </div>

                @if ($errors->any() && session('tab_aktif') === 'profil')
                    <div class="alert-err" style="margin-bottom:16px;">
                        <strong>Ada kesalahan:</strong>
                        <ul style="margin:6px 0 0 18px;font-size:13px;">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.pengaturan.profil') }}" method="POST">
                    @csrf

                    {{-- Nama & Email --}}
                    <div class="form-row">
                        <div class="form-group">
                            <label for="name">Nama Lengkap</label>
                            <input type="text" id="name" name="name"
                                   value="{{ old('name', $admin?->name ?? session('admin_name')) }}"
                                   placeholder="Nama administrator"
                                   class="{{ $errors->has('name') ? 'is-error' : '' }}">
                            @error('name') <p class="field-error">{{ $message }}</p> @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email"
                                   value="{{ old('email', $admin?->email ?? session('admin_email')) }}"
                                   placeholder="email@contoh.com"
                                   class="{{ $errors->has('email') ? 'is-error' : '' }}">
                            @error('email') <p class="field-error">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <hr class="form-divider">
                    <p style="font-size:13px;color:var(--muted);margin-bottom:18px;">
                        Kosongkan kolom kata sandi jika tidak ingin mengubahnya.
                    </p>

                    {{-- Password --}}
                    <div class="form-group">
                        <label for="password_lama">Kata Sandi Lama</label>
                        <input type="password" id="password_lama" name="password_lama"
                               placeholder="Masukkan kata sandi saat ini"
                               autocomplete="current-password"
                               class="{{ $errors->has('password_lama') ? 'is-error' : '' }}">
                        @error('password_lama') <p class="field-error">{{ $message }}</p> @enderror
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="password">Kata Sandi Baru</label>
                            <input type="password" id="password" name="password"
                                   placeholder="Min. 8 karakter"
                                   autocomplete="new-password"
                                   class="{{ $errors->has('password') ? 'is-error' : '' }}">
                            @error('password') <p class="field-error">{{ $message }}</p> @enderror
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Konfirmasi Kata Sandi Baru</label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                   placeholder="Ulangi kata sandi baru"
                                   autocomplete="new-password">
                        </div>
                    </div>

                    <button type="submit" class="btn-save">Simpan Perubahan</button>
                </form>
            </section>
        </div>

        {{-- ═══════════ TAB 2: NOTIFIKASI ═══════════ --}}
        <div class="tab-panel {{ $tabAktif === 'notifikasi' ? 'active' : '' }}" id="tab-notifikasi">
            <section class="content-panel">
                <div class="panel-heading" style="margin-bottom:24px;">
                    <div>
                        <h2>Preferensi Notifikasi</h2>
                        <p>Atur notifikasi yang ingin Anda terima di panel admin.</p>
                    </div>
                </div>

                <form action="{{ route('admin.pengaturan.notifikasi') }}" method="POST">
                    @csrf

                    <div class="toggle-row">
                        <div>
                            <div class="toggle-label">Notifikasi Laporan Baru</div>
                            <div class="toggle-desc">Tampilkan badge dan peringatan ketika ada laporan baru masuk.</div>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" name="notif_laporan_baru" value="1"
                                   {{ ($admin?->notif_laporan_baru ?? true) ? 'checked' : '' }}>
                            <span class="toggle-slider"></span>
                        </label>
                    </div>

                    <div class="toggle-row">
                        <div>
                            <div class="toggle-label">Notifikasi Perubahan Status</div>
                            <div class="toggle-desc">Tampilkan peringatan saat status laporan berubah (diproses, selesai, ditolak).</div>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" name="notif_perubahan_status" value="1"
                                   {{ ($admin?->notif_perubahan_status ?? true) ? 'checked' : '' }}>
                            <span class="toggle-slider"></span>
                        </label>
                    </div>

                    <div style="margin-top:24px;">
                        <button type="submit" class="btn-save">Simpan Preferensi</button>
                    </div>
                </form>
            </section>
        </div>

        {{-- ═══════════ TAB 3: SISTEM ═══════════ --}}
        <div class="tab-panel {{ $tabAktif === 'sistem' ? 'active' : '' }}" id="tab-sistem">
            <section class="content-panel">
                <div class="panel-heading" style="margin-bottom:24px;">
                    <div>
                        <h2>Informasi Sistem</h2>
                        <p>Detail teknis aplikasi LingkunganKu.</p>
                    </div>
                </div>

                <div class="info-row">
                    <span class="info-label">Nama Aplikasi</span>
                    <span class="info-value">{{ config('app.name', 'LingkunganKu') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Versi Aplikasi</span>
                    <span class="info-value">v1.0.0</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Framework</span>
                    <span class="info-value">Laravel {{ app()->version() }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Versi PHP</span>
                    <span class="info-value">PHP {{ PHP_VERSION }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Environment</span>
                    <span class="info-value">{{ ucfirst(config('app.env')) }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Database</span>
                    <span class="info-value">{{ ucfirst(config('database.default')) }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Status Koneksi Database</span>
                    <span>
                        @if ($dbOk)
                            <span class="badge-ok">✓ {{ $dbStatus }}</span>
                        @else
                            <span class="badge-err">✗ {{ $dbStatus }}</span>
                        @endif
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Total Laporan di Database</span>
                    <span class="info-value">{{ \App\Models\Laporan::count() }} laporan</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Laporan Baru (belum diproses)</span>
                    <span class="info-value">
                        <span class="badge-ok">{{ \App\Models\Laporan::where('status','baru')->count() }}</span>
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Server Time</span>
                    <span class="info-value">{{ now()->format('d M Y, H:i:s') }}</span>
                </div>
            </section>
        </div>

        <footer class="admin-footer">
            © {{ date('Y') }} LingkunganKu · Panel Administrator
        </footer>
    </main>
</div>

<div class="sidebar-overlay" id="sidebarOverlay"></div>

<script>
    // Hamburger
    const hamburger = document.getElementById('hamburger');
    const sidebar   = document.getElementById('sidebar');
    const overlay   = document.getElementById('sidebarOverlay');
    if (hamburger) {
        hamburger.addEventListener('click', () => {
            sidebar.classList.add('open');
            overlay.classList.add('open');
            document.body.style.overflow = 'hidden';
        });
        overlay.addEventListener('click', () => {
            sidebar.classList.remove('open');
            overlay.classList.remove('open');
            document.body.style.overflow = '';
        });
    }

    // Tab switching
    function bukaTab(id) {
        document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
        document.querySelectorAll('.setting-tab').forEach(t => t.classList.remove('active'));
        document.getElementById('tab-' + id).classList.add('active');
        event.currentTarget.classList.add('active');
    }
</script>
</body>
</html>
