<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); 
    }

    public function login(Request $request)
    {
        // Validasi input dari form
        $credentials = $request->validate([
            'username' => ['required'], 
            'password' => ['required'],
        ]);

        // Cek kecocokan data ke database menggunakan Auth::attempt
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Ambil data user yang sedang berhasil login
            $user = Auth::user();

            // Pengecekan Role (Hak Akses) untuk diarahkan ke tujuan masing-masing
            if ($user->role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            } elseif ($user->role === 'petugas') {
                return redirect()->intended('/petugas/loket');
            }

            // Jaga-jaga jika ada akun yang rolenya tidak terdaftar
            Auth::logout();
            return back()->withErrors([
                'username' => 'Akun ini tidak valid.',
            ])->onlyInput('username');
        }

        // Jika login gagal (username/password salah)
        return back()->withErrors([
            'username' => 'Username atau password yang Anda masukkan salah.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}