<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LaporanController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori'      => 'required|in:jalan,lampu-jalan,sampah,selokan,taman,lainnya',
            'deskripsi'     => 'required|string|max:5000',
            'kecamatan'     => 'required|string|max:100',
            'kelurahan'     => 'required|string|max:100',
            'titik_maps'    => [
                'nullable',
                'regex:/^-?\d{1,3}(?:\.\d+)?,\s*-?\d{1,3}(?:\.\d+)?$/',
            ],
            'foto_laporan'   => 'nullable',
            'foto_laporan.*' => 'image|mimes:jpg,jpeg,png,webp|max:5120',
            'persetujuan'   => 'accepted',
            'nama_pelapor'  => 'nullable|string|max:255',
            'email_pelapor' => 'nullable|string|max:255',
        ]);

        // ── Simpan foto (support multiple) ──────────────────────────────
        $fotoPaths = [];

        if ($request->hasFile('foto_laporan')) {
            $files = $request->file('foto_laporan');
            // Normalkan: bisa array (multiple) atau single
            if (!is_array($files)) {
                $files = [$files];
            }
            foreach ($files as $file) {
                if ($file && $file->isValid()) {
                    $fotoPaths[] = $file->store('laporan', 'public');
                }
            }
        }

        $fotoPrimary = $fotoPaths[0] ?? null;

        // ── Nama kategori yang lebih rapi ────────────────────────────────
        $namaKategori = [
            'jalan'      => 'Jalan',
            'lampu-jalan'=> 'Lampu Jalan',
            'sampah'     => 'Sampah',
            'selokan'    => 'Selokan',
            'taman'      => 'Taman',
            'lainnya'    => 'Lainnya',
        ];

        $lokasi = ucfirst($validated['kelurahan'])
            . ', Kec. '
            . ucfirst($validated['kecamatan']);

        if (!empty($validated['titik_maps'])) {
            $lokasi .= ' (' . $validated['titik_maps'] . ')';
        }

        // ── Simpan ke database ───────────────────────────────────────────
        try {
            Laporan::create([
                'user_id'       => auth()->id(),
                'nama_pelapor'  => $validated['nama_pelapor'] ?? null,
                'email_pelapor' => $validated['email_pelapor'] ?? null,
                'judul'         => 'Laporan ' . $namaKategori[$validated['kategori']],
                'kategori'      => $namaKategori[$validated['kategori']],
                'deskripsi'     => $validated['deskripsi'],
                'lokasi'        => $lokasi,
                'foto'          => $fotoPrimary,
                'status'        => 'baru',
                'catatan_admin' => null,
            ]);
        } catch (\Throwable $e) {
            // Hapus foto jika gagal simpan
            foreach ($fotoPaths as $path) {
                Storage::disk('public')->delete($path);
            }
            throw $e;
        }

        return redirect()
            ->route('notifikasi')
            ->with('laporan_terkirim', true);
    }
}
