<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;

class FrontendLaporanController extends Controller
{
    public function show(Request $request)
    {
        $id = $request->query('id');

        if (!is_string($id) || !ctype_digit($id)) {
            return view('detail-laporan');
        }

        $laporan = Laporan::with('user')->findOrFail((int) $id);

        return view('detail-laporan', compact('laporan'));
    }

    public function showHandling(Request $request)
    {
        $id = $request->query('id');

        if (!is_string($id) || !ctype_digit($id)) {
            return view('detail-penanganan');
        }

        $laporan = Laporan::with(['user', 'riwayatPenanganan'])->findOrFail((int) $id);

        return view('detail-penanganan', compact('laporan'));
    }

    public function index(Request $request)
    {
        $query = Laporan::latest();

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter pencarian
        if ($request->filled('q')) {
            $cari = $request->q;
            $query->where(function ($q) use ($cari) {
                $q->where('judul',    'like', '%' . $cari . '%')
                  ->orWhere('kategori', 'like', '%' . $cari . '%')
                  ->orWhere('deskripsi', 'like', '%' . $cari . '%')
                  ->orWhere('lokasi',  'like', '%' . $cari . '%');
            });
        }

        $laporan      = $query->paginate(12)->withQueryString();
        $statusAktif  = $request->get('status', '');
        $cariAktif    = $request->get('q', '');

        return view('laporan-semua', compact('laporan', 'statusAktif', 'cariAktif'));
    }
}
