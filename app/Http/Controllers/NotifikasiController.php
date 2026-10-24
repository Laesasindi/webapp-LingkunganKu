<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\RiwayatPenanganan;
use Illuminate\Http\Request;

class NotifikasiController extends Controller
{
    /**
     * Ambil notifikasi untuk user berdasarkan email.
     * GET /api/notifikasi?email=xxx@yyy.com
     */
    public function index(Request $request)
    {
        $email = $request->query('email');

        if (!$email) {
            return response()->json(['notifikasi' => [], 'total' => 0]);
        }

        // Ambil semua laporan milik email ini
        $laporan = Laporan::where('email_pelapor', $email)
            ->orderByDesc('updated_at')
            ->get();

        $notifikasi = [];

        foreach ($laporan as $item) {
            // Notifikasi 1: laporan berhasil dikirim (selalu ada)
            $notifikasi[] = [
                'id'         => 'laporan-buat-' . $item->id,
                'tipe'       => 'laporan',
                'judul'      => $item->judul,
                'isi'        => 'Laporan "' . $item->judul . '" berhasil dikirim dan sedang menunggu pemeriksaan.',
                'status'     => 'baru',
                'waktu'      => $item->created_at->diffForHumans(),
                'waktu_iso'  => $item->created_at->toISOString(),
                'laporan_id' => $item->id,
                'dibaca'     => false,
            ];

            // Notifikasi 2+: setiap perubahan status dari riwayat
            $riwayat = RiwayatPenanganan::where('laporan_id', $item->id)
                ->orderBy('created_at')
                ->get();

            foreach ($riwayat as $r) {
                $pesan = $this->pesanStatus($r->status_baru, $item->judul, $r->catatan);
                $notifikasi[] = [
                    'id'         => 'riwayat-' . $r->id,
                    'tipe'       => 'laporan',
                    'judul'      => $item->judul,
                    'isi'        => $pesan,
                    'status'     => $r->status_baru,
                    'waktu'      => $r->created_at->diffForHumans(),
                    'waktu_iso'  => $r->created_at->toISOString(),
                    'laporan_id' => $item->id,
                    'dibaca'     => false,
                ];
            }
        }

        // Urutkan dari terbaru
        usort($notifikasi, function ($a, $b) {
            return strcmp($b['waktu_iso'], $a['waktu_iso']);
        });

        return response()->json([
            'notifikasi' => $notifikasi,
            'total'      => count($notifikasi),
        ]);
    }

    private function pesanStatus(string $status, string $judul, ?string $catatan): string
    {
        $pesan = match($status) {
            'diproses' => 'Laporan "' . $judul . '" sedang dalam proses penanganan oleh petugas.',
            'selesai'  => 'Laporan "' . $judul . '" telah selesai ditindaklanjuti.',
            'ditolak'  => 'Laporan "' . $judul . '" tidak dapat diproses.',
            default    => 'Status laporan "' . $judul . '" diperbarui menjadi ' . $status . '.',
        };

        if ($catatan) {
            $pesan .= ' Catatan petugas: ' . $catatan;
        }

        return $pesan;
    }
}
