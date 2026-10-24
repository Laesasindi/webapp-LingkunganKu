<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminPengaturanController extends Controller
{
    // ── Tampilkan halaman pengaturan ────────────────────────────────
    public function index()
    {
        $admin = User::find(session('admin_id'));

        // Cek koneksi database
        try {
            DB::connection()->getPdo();
            $dbStatus = 'Terhubung';
            $dbOk     = true;
        } catch (\Exception $e) {
            $dbStatus = 'Gagal terhubung';
            $dbOk     = false;
        }

        return view('admin.pengaturan', compact('admin', 'dbStatus', 'dbOk'));
    }

    // ── Simpan perubahan profil ─────────────────────────────────────
    public function updateProfil(Request $request)
    {
        $admin = User::findOrFail(session('admin_id'));

        $rules = [
            'name'  => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:users,email,' . $admin->id,
        ];

        // Validasi password hanya jika diisi
        if ($request->filled('password')) {
            $rules['password_lama']     = 'required|string';
            $rules['password']          = 'required|string|min:8|confirmed';
        }

        $validated = $request->validate($rules);

        // Cek password lama jika ingin ganti password
        if ($request->filled('password')) {
            if (!Hash::check($request->password_lama, $admin->password)) {
                return back()
                    ->withErrors(['password_lama' => 'Password lama tidak sesuai.'])
                    ->withInput()
                    ->with('tab_aktif', 'profil');
            }
            $admin->password = Hash::make($request->password);
        }

        $admin->name  = $validated['name'];
        $admin->email = $validated['email'];
        $admin->save();

        // Update session
        session(['admin_name' => $admin->name, 'admin_email' => $admin->email]);

        return redirect()
            ->route('admin.pengaturan')
            ->with('sukses_profil', 'Profil berhasil diperbarui.')
            ->with('tab_aktif', 'profil');
    }

    // ── Simpan preferensi notifikasi ────────────────────────────────
    public function updateNotifikasi(Request $request)
    {
        $admin = User::findOrFail(session('admin_id'));

        $admin->notif_laporan_baru      = $request->boolean('notif_laporan_baru');
        $admin->notif_perubahan_status  = $request->boolean('notif_perubahan_status');
        $admin->save();

        return redirect()
            ->route('admin.pengaturan')
            ->with('sukses_notif', 'Preferensi notifikasi berhasil disimpan.')
            ->with('tab_aktif', 'notifikasi');
    }
}
