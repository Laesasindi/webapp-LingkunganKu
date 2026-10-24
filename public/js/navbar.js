(function () {
  var host = document.querySelector('.site-header');
  if (!host) return;

  var FOTO_DEFAULT = '/assets/images/avatar-default.png';

  // Tentukan menu aktif dari pathname Laravel
  var path  = location.pathname;
  var aktif = host.getAttribute('data-aktif');
  if (!aktif) {
    if (path === '/' || path === '') aktif = 'beranda';
    else if (path.indexOf('/buat-laporan') === 0) aktif = 'buat';
    else if (path.indexOf('/notifikasi') === 0)   aktif = 'notifikasi';
    else if (path.indexOf('/profil') === 0)        aktif = 'profil';
    else if (path.indexOf('/laporan') === 0 || path.indexOf('/cari-laporan') === 0 ||
             path.indexOf('/detail-') === 0)       aktif = 'laporan';
  }

  var MENU = [
    { id: 'beranda',    teks: 'Beranda',      href: '/' },
    { id: 'laporan',    teks: 'Laporan',      href: '/laporan' },
    { id: 'buat',       teks: 'Buat Laporan', href: '/buat-laporan' },
    { id: 'notifikasi', teks: 'Notifikasi',   href: '/notifikasi' },
    { id: 'profil',     teks: 'Profil',       href: '/profil' }
  ];

  var menuHtml = MENU.map(function (m) {
    return '<li><a href="' + m.href + '"' +
      (m.id === aktif ? ' aria-current="page"' : '') + '>' + m.teks + '</a></li>';
  }).join('');

  host.innerHTML =
    '<div class="navbar">' +
      '<a class="brand" href="/">' +
        '<img src="/assets/images/logo.png" alt="Logo LingkunganKu"><span class="brand-teks">Lingkungan<span class="brand-ku">Ku</span></span>' +
      '</a>' +
      '<nav aria-label="Menu Situs"><ul>' + menuHtml + '</ul></nav>' +
      '<div class="nav-aksi">' +
        '<div class="nav-tamu" id="nav-tamu">' +
          '<a class="nav-masuk" href="/login">Masuk</a>' +
          '<a class="nav-daftar" href="/register">Daftar</a>' +
        '</div>' +
        '<a class="nav-user" id="nav-user" href="/profil" hidden>' +
          '<img id="nav-user-foto" src="' + FOTO_DEFAULT + '" alt="">' +
          '<span id="nav-user-nama"></span>' +
        '</a>' +
      '</div>' +
      '<button class="nav-hamburger" id="nav-hamburger" aria-label="Buka menu" aria-expanded="false" aria-controls="nav-mobile-menu">' +
        '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>' +
      '</button>' +
    '</div>';

  // Hamburger toggle
  var hamburger = document.getElementById('nav-hamburger');
  var navMenu   = host.querySelector('nav[aria-label="Menu Situs"]');
  if (hamburger && navMenu) {
    navMenu.id = 'nav-mobile-menu';
    hamburger.addEventListener('click', function () {
      var isOpen = navMenu.classList.toggle('open');
      hamburger.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
      hamburger.innerHTML = isOpen
        ? '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>'
        : '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>';
    });

    // Tutup menu saat Escape ditekan
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && navMenu.classList.contains('open')) {
        navMenu.classList.remove('open');
        hamburger.setAttribute('aria-expanded', 'false');
        hamburger.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>';
        hamburger.focus(); // kembalikan fokus ke tombol hamburger
      }
    });

    // Tutup menu saat klik di luar navbar
    document.addEventListener('click', function (e) {
      if (!host.contains(e.target) && navMenu.classList.contains('open')) {
        navMenu.classList.remove('open');
        hamburger.setAttribute('aria-expanded', 'false');
        hamburger.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>';
      }
    });
  }

  // Jika sudah login: ganti Masuk/Daftar dengan foto dan nama pengguna
  var nama = localStorage.getItem('lingkunganku_nama');
  if (localStorage.getItem('lingkunganku_logged_in') === 'true' && nama) {
    document.getElementById('nav-tamu').hidden = true;
    document.getElementById('nav-user').hidden = false;
    document.getElementById('nav-user-nama').textContent = nama.split(' ')[0];
    document.getElementById('nav-user-foto').src =
      localStorage.getItem('lingkunganku_foto') || FOTO_DEFAULT;
  }
  
   // Efek kaca bertahap: nilai 0 (di atas) sampai 1 (setelah gulir 80px)
  var menunggu = false;
  function aturGulir() {
    var g = Math.min(Math.max(window.scrollY / 80, 0), 1);
    host.style.setProperty('--nb-g', g.toFixed(3));
    menunggu = false;
  }
  window.addEventListener('scroll', function () {
    if (!menunggu) { menunggu = true; requestAnimationFrame(aturGulir); }
  }, { passive: true });
  aturGulir();

  // ── Bottom Navigation Bar (mobile only) ─────────────────────────
  var bottomNav = document.createElement('nav');
  bottomNav.id = 'bottom-nav';
  bottomNav.setAttribute('aria-label', 'Navigasi bawah');

  var SVG_BERANDA = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12L12 3l9 9"/><path d="M9 21V12h6v9"/></svg>';
  var SVG_LAPORAN = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="5" y="2" width="14" height="20" rx="2"/><line x1="9" y1="7" x2="15" y2="7"/><line x1="9" y1="11" x2="15" y2="11"/><line x1="9" y1="15" x2="13" y2="15"/></svg>';
  var SVG_TAMBAH  = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>';
  var SVG_NOTIF   = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>';
  var SVG_PROFIL  = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>';

  // Ambil foto profil dari localStorage jika sudah login
  var isLoggedIn = localStorage.getItem('lingkunganku_logged_in') === 'true';
  var fotoUser   = localStorage.getItem('lingkunganku_foto') || FOTO_DEFAULT;

  // Ikon profil: gunakan foto jika sudah login, fallback ke SVG
  var profilIconHtml = isLoggedIn
    ? '<img src="' + fotoUser + '" alt="Profil" class="bn-foto-profil" onerror="this.onerror=null;this.src=\'' + FOTO_DEFAULT + '\'">'
    : SVG_PROFIL;

  var navItems = [
    { id: 'beranda',    icon: SVG_BERANDA,      label: 'Beranda',    href: '/' },
    { id: 'laporan',    icon: SVG_LAPORAN,      label: 'Laporan',    href: '/laporan' },
    { id: 'buat',       icon: SVG_TAMBAH,       label: 'Lapor',      href: '/buat-laporan', plus: true },
    { id: 'notifikasi', icon: SVG_NOTIF,        label: 'Notifikasi', href: '/notifikasi' },
    { id: 'profil',     icon: profilIconHtml,   label: 'Profil',     href: '/profil' }
  ];

  bottomNav.innerHTML = navItems.map(function(item) {
    var isAktif = item.id === aktif;
    return '<a href="' + item.href + '" class="bn-item' +
      (item.plus ? ' bn-plus' : '') +
      (isAktif ? ' bn-aktif' : '') + '">' +
      '<span class="bn-icon">' + item.icon + '</span>' +
      '<span class="bn-label">' + item.label + '</span>' +
    '</a>';
  }).join('');

  // Tambahkan padding bawah konten agar tidak tertutup bottom nav
  document.addEventListener('DOMContentLoaded', function() {
    var main = document.querySelector('main, .laporan-page, .notif-page');
    if (main) main.style.paddingBottom = 'calc(72px + env(safe-area-inset-bottom))';
  });

  document.body.appendChild(bottomNav);

  // Update foto profil di bottom nav saat localStorage berubah (misal setelah simpan profil)
  window.addEventListener('storage', function(e) {
    if (e.key === 'lingkunganku_foto' || e.key === 'lingkunganku_logged_in') {
      updateBnProfil();
    }
  });

  // Juga listen custom event dari halaman yang sama (misal profil.js)
  window.addEventListener('lingkunganku:profil-update', function() {
    updateBnProfil();
  });

  function updateBnProfil() {
    var bnProfil = bottomNav.querySelector('a[href="/profil"] .bn-icon');
    if (!bnProfil) return;
    var loggedIn = localStorage.getItem('lingkunganku_logged_in') === 'true';
    var foto = localStorage.getItem('lingkunganku_foto') || FOTO_DEFAULT;
    if (loggedIn) {
      bnProfil.innerHTML = '<img src="' + foto + '" alt="Profil" class="bn-foto-profil" onerror="this.onerror=null;this.src=\'' + FOTO_DEFAULT + '\'">';
    } else {
      bnProfil.innerHTML = SVG_PROFIL;
    }
  }
})();