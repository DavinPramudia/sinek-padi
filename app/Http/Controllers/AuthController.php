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
        $request->validate([
            'username' => ['required'], 
            'password' => ['required'],
        ]);

        $user = User::where('username', $request->username)->first();

        // Karena tadi hasilnya "ADA" dan "YA", ini pasti tembus!
        if ($user && Hash::check($request->password, $user->password)) {
            
            // Login-kan user secara resmi ke sistem Laravel
            Auth::login($user);
            
            // Regenerate session agar aman dan terbaca oleh middleware auth
            $request->session()->regenerate();

            // Arahkan sesuai role
            if ($user->id_roles == 1) {
                return redirect()->intended('/admin/dashboard');
            } elseif ($user->id_roles == 2) {
                return redirect()->intended('/petugas/loket');
            }

            Auth::logout();
            return back()->withErrors(['username' => 'Role akun tidak terdaftar.']);
        }

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