<x-admin.layout-admin title="Manajemen Akun">
    <div class="flex flex-col h-full space-y-6">
        
        {{-- 1. HEADER MANAJEMEN AKUN --}}
        <div class="flex flex-col md:flex-row md:justify-between md:items-end gap-4">
            <div>
                <h1 class="text-2xl font-bold text-[#EDEDED] mb-1">Manajemen Akun SINEK-PADI</h1>
                <p class="text-sm text-[#d1d5dc]">Kelola data pengguna, petugas loket, dan hak akses sistem.</p>
            </div>
            
            {{-- Tombol Aksi (Cari & Tambah) --}}
            <div class="flex flex-wrap items-center gap-3 text-sm">
                {{-- Search Bar --}}
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-[#d1d5dc]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <input type="text" class="bg-[#141c1a] border border-[#243733] text-[#EDEDED] text-sm rounded-lg focus:ring-[#3aafa9] focus:border-[#3aafa9] block w-full pl-10 p-2.5 placeholder-[#d1d5dc]/50 outline-none transition" placeholder="Cari pengguna...">
                </div>

                {{-- Tombol Tambah Akun --}}
                <button class="bg-[#3aafa9] text-[#0B0909] font-semibold px-4 py-2.5 rounded-lg hover:bg-[#2b8681] transition flex items-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>Tambah Akun</span>
                </button>
            </div>
        </div>

        {{-- 2. TABEL DATA PENGGUNA --}}
        <div class="bg-[#141c1a] border border-[#243733] rounded-xl overflow-hidden flex-1">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-[#d1d5dc]">
                    <thead class="text-xs text-[#EDEDED] uppercase bg-[#243733]/50 border-b border-[#243733]">
                        <tr>
                            <th scope="col" class="px-6 py-4">No</th>
                            <th scope="col" class="px-6 py-4">Nama Lengkap</th>
                            <th scope="col" class="px-6 py-4">Username / Email</th>
                            <th scope="col" class="px-6 py-4">Role / Peran</th>
                            <th scope="col" class="px-6 py-4">Status</th>
                            <th scope="col" class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <!-- Contoh Baris 1 (Admin) -->
                        <tr class="border-b border-[#243733] hover:bg-[#243733]/30 transition">
                            <td class="px-6 py-4">1</td>
                            <td class="px-6 py-4 font-medium text-white">Administrator Sinek</td>
                            <td class="px-6 py-4">admin@sinekpadi.com</td>
                            <td class="px-6 py-4">
                                <span class="bg-[#3aafa9]/20 text-[#3aafa9] px-2.5 py-1 rounded-md text-xs font-semibold border border-[#3aafa9]/30">Admin</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="h-2.5 w-2.5 rounded-full bg-green-500 mr-2"></div> Aktif
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <button class="text-[#3aafa9] hover:text-white transition px-2">Edit</button>
                                <button class="text-red-400 hover:text-red-500 transition px-2">Hapus</button>
                            </td>
                        </tr>

                        <!-- Contoh Baris 2 (Petugas) -->
                        <tr class="border-b border-[#243733] hover:bg-[#243733]/30 transition">
                            <td class="px-6 py-4">2</td>
                            <td class="px-6 py-4 font-medium text-white">Budi Santoso</td>
                            <td class="px-6 py-4">budi.loket</td>
                            <td class="px-6 py-4">
                                <span class="bg-[#d1d5dc]/10 text-[#d1d5dc] px-2.5 py-1 rounded-md text-xs font-semibold border border-[#d1d5dc]/20">Petugas Loket</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="h-2.5 w-2.5 rounded-full bg-green-500 mr-2"></div> Aktif
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <button class="text-[#3aafa9] hover:text-white transition px-2">Edit</button>
                                <button class="text-red-400 hover:text-red-500 transition px-2">Hapus</button>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>

            {{-- Bagian Pagination (Bawah Tabel) --}}
            <div class="p-4 border-t border-[#243733] flex justify-between items-center text-xs text-[#d1d5dc]">
                <span>Menampilkan 1 sampai 2 dari 2 entri</span>
                <div class="flex space-x-1">
                    <button class="px-3 py-1.5 border border-[#243733] rounded-md hover:bg-[#243733] transition text-[#EDEDED]">Sebelumnya</button>
                    <button class="px-3 py-1.5 bg-[#3aafa9] border border-[#3aafa9] rounded-md text-[#0B0909] font-medium">1</button>
                    <button class="px-3 py-1.5 border border-[#243733] rounded-md hover:bg-[#243733] transition text-[#EDEDED]">Selanjutnya</button>
                </div>
            </div>
        </div>

    </div>
</x-admin.layout-admin>