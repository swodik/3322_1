<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    // Menampilkan form login
    public function showLoginForm()
    {
        return view('welcome');
    }

    // Proses login
    public function postLogin(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string', // NIP sebagai password
        ]);

        // Cari pengguna di tabel users berdasarkan username dan nip
        $user = DB::table('m_pegawai')
            ->where('username', $request->username)
            ->where('nip', $request->password) // NIP digunakan sebagai password
            ->first();

        if ($user) {
            // Simpan data ke session
            Session::put('user_id', $user->id);
            Session::put('is_admin', $user->is_admin);
            Session::put('username', $user->username);
            Session::put('nip', $user->nip); // Simpan NIP ke session

            // Redirect berdasarkan peran
            if ($user->is_admin) {
                return redirect()->route('admin.dashboard')->with('success', 'Berhasil login sebagai admin.');
            } else {
                return redirect()->route('staff.dashboard')->with('success', 'Berhasil login sebagai staff.');
            }
        } else {
            // Jika login gagal
            return redirect()->back()->withErrors(['error' => 'Username atau NIP salah.']);
        }
    }

    // Proses logout
    public function logout()
    {
        Session::flush(); // Hapus semua session
        return redirect()->route('home')->with('success', 'Berhasil logout.');
    }
}