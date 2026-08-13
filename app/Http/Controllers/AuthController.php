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
        // 1. Validasi input dan ambil kredensialnya
        $credentials = $request->validate([
            'username' => ['required'], 
            'password' => ['required'],
        ]);

        // 2. Gunakan Auth::attempt() (Best Practice untuk autentikasi)
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            $user = Auth::user();

            // 3. Gunakan Named Route ketimbang hardcode URL
            if ($user->id_roles == 1) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->id_roles == 2) {
                return redirect()->route('petugas.loket');
            }

            // Jika role di luar 1 atau 2, keluarkan kembali
            Auth::logout();
            return back()->withErrors(['username' => 'Role akun tidak terdaftar.']);
        }

        // Jika gagal login
        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login'); // Menggunakan named route
    }
}