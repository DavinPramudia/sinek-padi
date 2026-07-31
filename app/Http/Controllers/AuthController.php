<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); 
    }

    public function login(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'username' => ['required'], 
            'password' => ['required'],
        ]);

        // 2. Cari user berdasarkan username
        $user = User::where('username', $request->username)->first();

        // 3. Cek apakah user ada dan passwordnya cocok
        if ($user && Hash::check($request->password, $user->password)) {
            
            // Catat login & buat session baru
            Auth::login($user);
            $request->session()->regenerate();
            
            // Arahkan sesuai id_roles
            if ($user->id_roles == 1) {
                return redirect('/admin/dashboard');
            } elseif ($user->id_roles == 2) {
                return redirect('/petugas/loket');
            }

            // Jika role di luar 1 atau 2, keluarkan lagi
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
        return redirect('/login');
    }
}