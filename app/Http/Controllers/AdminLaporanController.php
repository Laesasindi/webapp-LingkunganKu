<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\RiwayatPenanganan;
use Illuminate\Http\Request;

class AdminLaporanController extends Controller
{
    // ── Daftar semua laporan (bisa difilter status) ──────────────────
    public function index(Request $request)
    {
        $query = Laporan::with('user')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $laporan       = $query->paginate(15)->withQueryString();
        $jumlahBaru    = Laporan::where('status', 'baru')->count();

        return view('admin.laporan.index', compact('laporan', 'jumlahBaru'));
    }

    // ── Laporan baru saja ────────────────────────────────────────────
    public function baru()
    {
        $laporan    = Laporan::with('user')
            ->where('status', 'baru')
            ->latest()
            ->paginate(15);

        $jumlahBaru = Laporan::where('status', 'baru')->count();

        return view('admin.laporan.baru', compact('laporan', 'jumlahBaru'));
    }

    // ── Detail satu laporan ──────────────────────────────────────────
    public function show(Laporan $laporan)
    {
        $laporan->load(['user', 'riwayatPenanganan.admin']);
        $jumlahBaru = Laporan::where('status', 'baru')->count();

        return view('admin.laporan.show', compact('laporan', 'jumlahBaru'));
    }

    // ── Hapus laporan ────────────────────────────────────────────────
    public function destroy(Laporan $laporan)
    {
        // Hapus foto dari storage jika ada
        if ($laporan->foto) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($laporan->foto);
        }

        $laporan->delete();

        return redirect()
            ->route('admin.laporan')
            ->with('sukses', 'Laporan berhasil dihapus.');
    }
    public function updateStatus(Request $request, Laporan $laporan)
    {
        $request->validate([
            'status'        => 'required|in:baru,diproses,selesai,ditolak',
            'catatan_admin' => 'nullable|string|max:2000',
        ]);

        $statusLama = $laporan->status;
        $statusBaru = $request->status;

        // Simpan ke laporan
        $laporan->update([
            'status'        => $statusBaru,
            'catatan_admin' => $request->catatan_admin,
        ]);

        // Catat riwayat kalau status berubah
        if ($statusLama !== $statusBaru) {
            RiwayatPenanganan::create([
                'laporan_id'        => $laporan->id,
                'admin_id'          => null, // admin tidak pakai Laravel Auth
                'status_sebelumnya' => $statusLama,
                'status_baru'       => $statusBaru,
                'catatan'           => $request->catatan_admin,
            ]);
        }

        return redirect()
            ->route('admin.laporan.show', $laporan)
            ->with('sukses', 'Status laporan berhasil diperbarui.');
    }
}
