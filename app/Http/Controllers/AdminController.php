<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminController extends Controller
{
    public function manajemenAkun(Request $request)
    {
        $search = $request->input('search');
        $users = User::when($search, function ($query, $search) {
                        return $query->where('name', 'like', "%{$search}%")
                                     ->orWhere('username', 'like', "%{$search}%");
                    })
                    ->paginate(5)
                    ->withQueryString();

        return view('admin.manajemen-akun', compact('users'));
    }

    // 1. Tampilkan Form Tambah
    public function create()
    {
        return view('admin.manajemen-akun.tambah');
    }

    // 2. Simpan Data Baru ke Database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username',
            'password' => 'required|min:8|same:password_confirmation',
            'id_roles' => 'required|integer',
        ]);

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'id_roles' => $request->id_roles,
        ]);

        return redirect()->route('admin.manajemen-akun')->with('success', 'Akun berhasil ditambahkan!');
    }

    // 3. Tampilkan Form Edit berdasarkan ID
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.manajemen-akun.edit', compact('user'));
    }

    // 4. Update Data ke Database
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            // Perhatikan bagian belakang ini: pastikan ada ',id_users' agar sesuai dengan database-mu
            'username' => 'required|string|unique:users,username,' . $id . ',id_users',
            'id_roles' => 'required|integer',
        ]);

        $user->name = $request->name;
        $user->username = $request->username;
        
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'min:8|same:password_confirmation',
            ]);
            $user->password = Hash::make($request->password);
        }

        $user->id_roles = $request->id_roles;
        $user->save();

        return redirect()->route('admin.manajemen-akun')->with('success', 'Akun berhasil diperbarui!');
    }

    // 5. Hapus Akun dari Database
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Opsional: Cegah admin menghapus akunnya sendiri yang sedang login
        if ($user->id_users == auth()->id()) {
            return redirect()->route('admin.manajemen-akun')->with('error', 'Anda tidak dapat menghapus akun yang sedang digunakan!');
        }

        $user->delete();

        return redirect()->route('admin.manajemen-akun')->with('success', 'Akun berhasil dihapus!');
    }
}