<?php
namespace App\Http\Controllers;

use App\Models\Laporan;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'adminName' => session('admin_name', 'Admin LingkunganKu'),

            'totalLaporan' => Laporan::count(),

            'laporanBaru' => Laporan::where('status', 'baru')->count(),

            'laporanDiproses' => Laporan::where('status', 'diproses')->count(),

            'laporanSelesai' => Laporan::where('status', 'selesai')->count(),
        ]);
    }
}
