<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LaporanSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $data = [
            [
                'nama_pelapor'  => 'Budi Santoso',
                'email_pelapor' => 'budi@example.com',
                'judul'         => 'Jalan Berlubang Berbahaya',
                'kategori'      => 'Jalan',
                'deskripsi'     => 'Terdapat lubang cukup besar di tengah jalan yang membahayakan pengendara motor dan mobil.',
                'lokasi'        => 'Jl. Kemanggisan Utama, Palmerah',
                'foto'          => 'assets/images/laporan-jalan-berlubang.webp',
                'status'        => 'diproses',
                'catatan_admin' => null,
                'created_at'    => $now->copy()->subHours(2),
                'updated_at'    => $now->copy()->subHours(2),
            ],
            [
                'nama_pelapor'  => 'Siti Rahayu',
                'email_pelapor' => 'siti@example.com',
                'judul'         => 'Sampah Menumpuk di Pinggir Jalan',
                'kategori'      => 'Sampah',
                'deskripsi'     => 'Sampah menumpuk di pinggir jalan sudah beberapa hari dan menimbulkan bau tidak sedap.',
                'lokasi'        => 'Jl. Anggrek No.7, Slipi',
                'foto'          => 'assets/images/laporan-sampah-menumpuk.webp',
                'status'        => 'diproses',
                'catatan_admin' => null,
                'created_at'    => $now->copy()->subHours(5),
                'updated_at'    => $now->copy()->subHours(5),
            ],
            [
                'nama_pelapor'  => 'Ahmad Fauzi',
                'email_pelapor' => 'ahmad@example.com',
                'judul'         => 'Lampu Jalan Mati',
                'kategori'      => 'Penerangan',
                'deskripsi'     => 'Lampu jalan di depan komplek tidak menyala sejak malam kemarin, sangat gelap.',
                'lokasi'        => 'Jl. Panjang, Kebon Jeruk',
                'foto'          => 'assets/images/laporan-lampu-jalan-mati.webp',
                'status'        => 'selesai',
                'catatan_admin' => 'Lampu sudah diperbaiki oleh tim teknis.',
                'created_at'    => $now->copy()->subHours(8),
                'updated_at'    => $now->copy()->subHours(1),
            ],
            [
                'nama_pelapor'  => 'Dewi Lestari',
                'email_pelapor' => 'dewi@example.com',
                'judul'         => 'Selokan Tersumbat',
                'kategori'      => 'Drainase',
                'deskripsi'     => 'Selokan tersumbat oleh sampah dan daun kering sehingga air meluap ke jalan.',
                'lokasi'        => 'Jl. Rawa Belong, Palmerah',
                'foto'          => 'assets/images/laporan-selokan-tersumbat.webp',
                'status'        => 'menunggu',
                'catatan_admin' => null,
                'created_at'    => $now->copy()->subHours(12),
                'updated_at'    => $now->copy()->subHours(12),
            ],
            [
                'nama_pelapor'  => 'Rendi Pratama',
                'email_pelapor' => 'rendi@example.com',
                'judul'         => 'Pohon Tumbang Menutup Jalan',
                'kategori'      => 'Jalan',
                'deskripsi'     => 'Pohon besar tumbang setelah hujan deras dan menutup sebagian badan jalan.',
                'lokasi'        => 'Jl. S. Parman, Tomang',
                'foto'          => 'assets/images/laporan-jalan-berlubang.webp',
                'status'        => 'selesai',
                'catatan_admin' => 'Pohon sudah dipindahkan oleh Dinas Pertamanan.',
                'created_at'    => $now->copy()->subDays(1),
                'updated_at'    => $now->copy()->subHours(3),
            ],
            [
                'nama_pelapor'  => 'Nurul Hidayah',
                'email_pelapor' => 'nurul@example.com',
                'judul'         => 'Got Mampet Menyebabkan Banjir',
                'kategori'      => 'Drainase',
                'deskripsi'     => 'Got di depan rumah mampet dan saat hujan air menggenangi halaman hingga masuk rumah.',
                'lokasi'        => 'Jl. Haji Mencong, Ciledug',
                'foto'          => 'assets/images/laporan-selokan-tersumbat.webp',
                'status'        => 'diproses',
                'catatan_admin' => null,
                'created_at'    => $now->copy()->subDays(1)->subHours(3),
                'updated_at'    => $now->copy()->subDays(1)->subHours(3),
            ],
            [
                'nama_pelapor'  => 'Hendra Wijaya',
                'email_pelapor' => 'hendra@example.com',
                'judul'         => 'Trotoar Rusak dan Berlubang',
                'kategori'      => 'Jalan',
                'deskripsi'     => 'Trotoar di sepanjang jalan rusak parah, banyak lubang besar yang membahayakan pejalan kaki.',
                'lokasi'        => 'Jl. Letjen S. Parman, Grogol',
                'foto'          => 'assets/images/laporan-jalan-berlubang.webp',
                'status'        => 'menunggu',
                'catatan_admin' => null,
                'created_at'    => $now->copy()->subDays(2),
                'updated_at'    => $now->copy()->subDays(2),
            ],
            [
                'nama_pelapor'  => 'Yuli Astuti',
                'email_pelapor' => 'yuli@example.com',
                'judul'         => 'Tiang Listrik Miring Hampir Roboh',
                'kategori'      => 'Listrik',
                'deskripsi'     => 'Tiang listrik di depan gang miring dan hampir roboh, sangat berbahaya bagi warga.',
                'lokasi'        => 'Jl. Kembangan Utara, Kembangan',
                'foto'          => 'assets/images/laporan-lampu-jalan-mati.webp',
                'status'        => 'diproses',
                'catatan_admin' => null,
                'created_at'    => $now->copy()->subDays(2)->subHours(5),
                'updated_at'    => $now->copy()->subDays(2)->subHours(5),
            ],
            [
                'nama_pelapor'  => 'Fajar Nugroho',
                'email_pelapor' => 'fajar@example.com',
                'judul'         => 'Tempat Sampah Umum Penuh',
                'kategori'      => 'Sampah',
                'deskripsi'     => 'Tempat sampah umum di taman sudah penuh dan tidak pernah diangkut lebih dari seminggu.',
                'lokasi'        => 'Taman Kota, Grogol Petamburan',
                'foto'          => 'assets/images/laporan-sampah-menumpuk.webp',
                'status'        => 'selesai',
                'catatan_admin' => 'Sampah sudah diangkut oleh petugas kebersihan.',
                'created_at'    => $now->copy()->subDays(3),
                'updated_at'    => $now->copy()->subDays(1),
            ],
            [
                'nama_pelapor'  => 'Rina Marlina',
                'email_pelapor' => 'rina@example.com',
                'judul'         => 'Saluran Air Bersih Bocor',
                'kategori'      => 'Air',
                'deskripsi'     => 'Pipa air bersih di pinggir jalan bocor, air mengalir sia-sia dan membuat jalan licin.',
                'lokasi'        => 'Jl. Pos Pengumben, Kebon Jeruk',
                'foto'          => 'assets/images/laporan-selokan-tersumbat.webp',
                'status'        => 'ditolak',
                'catatan_admin' => 'Bukan kewenangan kelurahan, sudah diteruskan ke PDAM.',
                'created_at'    => $now->copy()->subDays(4),
                'updated_at'    => $now->copy()->subDays(3),
            ],
        ];

        DB::table('laporan')->insert($data);
    }
}
