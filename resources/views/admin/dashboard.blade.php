<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - LingkunganKu</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
<div class="admin-page">

    @include('admin.partials.sidebar')

    <main class="admin-main">

        <header class="topbar">
            <div style="display:flex;align-items:center;gap:12px;">
                <button class="hamburger" id="hamburger" aria-label="Buka menu">
                    <span></span><span></span><span></span>
                </button>
                <div>
                    <p class="eyebrow">ADMINISTRATOR</p>
                    <h1>Dashboard</h1>
                </div>
            </div>
            <div class="topbar-user">
                <span class="status-dot"></span>
                <span>{{ $adminName ?? 'Admin LingkunganKu' }}</span>
            </div>
        </header>

        <section class="welcome-panel">
            <div>
                <p class="welcome-label">PUSAT KENDALI</p>
                <h2>Selamat datang, {{ $adminName ?? 'Admin' }}!</h2>
                <p>Pantau dan kelola laporan warga melalui LingkunganKu.</p>
            </div>
            <div class="welcome-icon">🌱</div>
        </section>

        <div class="section-heading">
            <h2>Ringkasan Laporan</h2>
            <p>Data keseluruhan laporan yang masuk dari warga.</p>
        </div>

        <div class="stats-grid">
            <a href="{{ route('admin.laporan') }}" class="stat-card">
                <div class="stat-icon icon-total">▤</div>
                <p>Total Laporan</p>
                <strong>{{ $totalLaporan ?? 0 }}</strong>
                <small>Seluruh laporan warga</small>
            </a>
            <a href="{{ route('admin.laporan.baru') }}" class="stat-card">
                <div class="stat-icon icon-new">◷</div>
                <p>Laporan Baru</p>
                <strong>{{ $laporanBaru ?? 0 }}</strong>
                <small>Menunggu pemeriksaan</small>
            </a>
            <a href="{{ route('admin.laporan') }}?status=diproses" class="stat-card">
                <div class="stat-icon icon-process">↻</div>
                <p>Sedang Diproses</p>
                <strong>{{ $laporanDiproses ?? 0 }}</strong>
                <small>Dalam penanganan</small>
            </a>
            <a href="{{ route('admin.laporan') }}?status=selesai" class="stat-card">
                <div class="stat-icon icon-done">✓</div>
                <p>Laporan Selesai</p>
                <strong>{{ $laporanSelesai ?? 0 }}</strong>
                <small>Telah ditangani</small>
            </a>
        </div>

        <section class="content-panel">
            <div class="panel-heading">
                <div>
                    <h2>Laporan Terbaru</h2>
                    <p>10 laporan warga yang baru masuk.</p>
                </div>
                <a href="{{ route('admin.laporan') }}" style="font-size:13px;color:var(--blue);font-weight:600;">Lihat Semua →</a>
            </div>

            @php $laporanTerbaru = \App\Models\Laporan::latest()->limit(10)->get(); @endphp

            @if ($laporanTerbaru->isEmpty())
                <div class="empty-state">
                    <div class="empty-icon">📋</div>
                    <h3>Belum ada laporan</h3>
                    <p>Laporan warga akan ditampilkan di sini setelah ada pengiriman.</p>
                </div>
            @else
                <div style="overflow-x:auto;">
                    <table style="width:100%;border-collapse:collapse;font-size:13.5px;">
                        <thead>
                            <tr style="background:#f8fafc;">
                                <th style="padding:10px 14px;text-align:left;border-bottom:1px solid #e2e8f0;font-weight:700;color:#475569;">#</th>
                                <th style="padding:10px 14px;text-align:left;border-bottom:1px solid #e2e8f0;font-weight:700;color:#475569;">Judul</th>
                                <th style="padding:10px 14px;text-align:left;border-bottom:1px solid #e2e8f0;font-weight:700;color:#475569;">Kategori</th>
                                <th style="padding:10px 14px;text-align:left;border-bottom:1px solid #e2e8f0;font-weight:700;color:#475569;">Lokasi</th>
                                <th style="padding:10px 14px;text-align:left;border-bottom:1px solid #e2e8f0;font-weight:700;color:#475569;">Tanggal</th>
                                <th style="padding:10px 14px;text-align:left;border-bottom:1px solid #e2e8f0;font-weight:700;color:#475569;">Status</th>
                                <th style="padding:10px 14px;text-align:center;border-bottom:1px solid #e2e8f0;font-weight:700;color:#475569;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($laporanTerbaru as $i => $item)
                            <tr style="border-bottom:1px solid #f1f5f9;">
                                <td style="padding:10px 14px;color:#94a3b8;">{{ $i + 1 }}</td>
                                <td style="padding:10px 14px;">
                                    <strong style="color:#1e293b;">{{ $item->judul }}</strong>
                                </td>
                                <td style="padding:10px 14px;color:#64748b;">{{ $item->kategori }}</td>
                                <td style="padding:10px 14px;color:#64748b;max-width:180px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $item->lokasi }}</td>
                                <td style="padding:10px 14px;color:#94a3b8;white-space:nowrap;">{{ $item->created_at->format('d/m/Y') }}</td>
                                <td style="padding:10px 14px;">
                                    @php
                                        $badgeStyle = match($item->status) {
                                            'baru'     => 'background:#fef9c3;color:#854d0e;',
                                            'diproses' => 'background:#dbeafe;color:#1d4ed8;',
                                            'selesai'  => 'background:#dcfce7;color:#15803d;',
                                            'ditolak'  => 'background:#fee2e2;color:#dc2626;',
                                            default    => 'background:#f1f5f9;color:#64748b;',
                                        };
                                    @endphp
                                    <span style="padding:3px 10px;border-radius:20px;font-size:11.5px;font-weight:700;{{ $badgeStyle }}">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </td>
                                <td style="padding:10px 14px;text-align:center;">
                                    <a href="{{ route('admin.laporan.show', $item) }}"
                                       style="padding:5px 12px;border-radius:7px;background:var(--blue-light);color:var(--blue);font-size:12px;font-weight:600;text-decoration:none;">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </section>

        <footer class="admin-footer">
            © {{ date('Y') }} LingkunganKu · Panel Administrator
        </footer>

    </main>
</div>

<div class="sidebar-overlay" id="sidebarOverlay"></div>
<script>
    const hamburger = document.getElementById('hamburger');
    const sidebar   = document.getElementById('sidebar');
    const overlay   = document.getElementById('sidebarOverlay');
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
</script>
</body>
</html>
