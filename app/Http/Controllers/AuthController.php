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
        $credentials = $request->validate([
            'username' => ['required'], 
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Cek langsung berdasarkan id_roles di database
            // 1 = admin, 2 = petugas
            if ($user->id_roles == 1) {
                return redirect()->intended('/admin/dashboard');
            } elseif ($user->id_roles == 2) {
                return redirect()->intended('/petugas/loket');
            }

            Auth::logout();
            return back()->withErrors([
                'username' => 'Role akun tidak terdaftar.',
            ])->onlyInput('username');
        }

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