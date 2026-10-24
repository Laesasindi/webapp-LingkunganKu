
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminLaporanController;
use App\Http\Controllers\AdminPengaturanController;
use App\Http\Controllers\FrontendLaporanController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Middleware\AdminMiddleware;

/*
|--------------------------------------------------------------------------
| Halaman Website Warga
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('beranda');
})->name('beranda');

// Halaman login dan register warga
Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/register', function () {
    return view('register');
})->name('register');

// Halaman laporan warga (dinamis dari database)
Route::get('/laporan', [FrontendLaporanController::class, 'index'])
    ->name('laporan');

Route::get('/buat-laporan', function () {
    return view('buat-laporan');
})->name('buat-laporan');

// Memproses pengiriman laporan warga
Route::post('/buat-laporan', [LaporanController::class, 'store'])
    ->name('buat-laporan.store');

Route::get('/notifikasi', function () {
    return view('notifikasi');
})->name('notifikasi');

// API: ambil notifikasi user berdasarkan email (untuk frontend JS)
Route::get('/api/notifikasi', [NotifikasiController::class, 'index'])
    ->name('api.notifikasi');

Route::get('/profil', function () {
    return view('profil');
})->name('profil');

Route::get('/cari-laporan', function () {
    return view('cari-laporan');
})->name('cari-laporan');

Route::get('/detail-laporan', function () {
    return view('detail-laporan');
})->name('detail-laporan');

Route::get('/detail-penanganan', function () {
    return view('detail-penanganan');
})->name('detail-penanganan');

// Halaman detail pemberitahuan
Route::get('/pemberitahuan/jadwal-sampah', function () {
    return view('pemberitahuan.jadwal-sampah');
})->name('pemberitahuan.jadwal-sampah');

Route::get('/pemberitahuan/update-app', function () {
    return view('pemberitahuan.update-app');
})->name('pemberitahuan.update-app');

// Sub-halaman notifikasi
Route::get('/notifikasi-laporan', function () {
    return redirect('/notifikasi?tab=laporan');
});

Route::get('/notifikasi-pemberitahuan', function () {
    return redirect('/notifikasi?tab=info');
});

Route::get('/notifikasi-semua', function () {
    return redirect('/notifikasi');
});

// Halaman laporan dengan filter status
Route::get('/laporan-semua', function () {
    return redirect('/laporan');
});

Route::get('/laporan-diproses', function () {
    return redirect('/laporan?status=diproses');
});

Route::get('/laporan-selesai', function () {
    return redirect('/laporan?status=selesai');
});

Route::get('/laporan-ditolak', function () {
    return redirect('/laporan?status=ditolak');
});

/*
|--------------------------------------------------------------------------
| Autentikasi Admin
|--------------------------------------------------------------------------
*/

Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])
    ->name('admin.login');

Route::post('/admin/login', [AdminAuthController::class, 'login'])
    ->middleware('throttle:5,1')
    ->name('admin.login.submit');

/*
|--------------------------------------------------------------------------
| Halaman Admin yang Dilindungi
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->name('admin.')
    ->middleware(AdminMiddleware::class)
    ->group(function () {

        // Dashboard admin
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        // Semua laporan
        Route::get('/laporan', [AdminLaporanController::class, 'index'])
            ->name('laporan');

        // Laporan baru
        Route::get('/laporan/baru', [AdminLaporanController::class, 'baru'])
            ->name('laporan.baru');

        // Detail laporan
        Route::get('/laporan/{laporan}', [AdminLaporanController::class, 'show'])
            ->name('laporan.show');

        // Update status laporan
        Route::patch('/laporan/{laporan}/status', [AdminLaporanController::class, 'updateStatus'])
            ->name('laporan.updateStatus');

        // Hapus laporan
        Route::delete('/laporan/{laporan}', [AdminLaporanController::class, 'destroy'])
            ->name('laporan.destroy');

        // Pengaturan
        Route::get('/pengaturan', [AdminPengaturanController::class, 'index'])
            ->name('pengaturan');
        Route::post('/pengaturan/profil', [AdminPengaturanController::class, 'updateProfil'])
            ->name('pengaturan.profil');
        Route::post('/pengaturan/notifikasi', [AdminPengaturanController::class, 'updateNotifikasi'])
            ->name('pengaturan.notifikasi');

        // Logout admin
        Route::post('/logout', [AdminAuthController::class, 'logout'])
            ->name('logout');
    });
