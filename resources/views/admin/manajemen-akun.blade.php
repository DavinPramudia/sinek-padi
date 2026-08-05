<x-admin.layout-admin title="Manajemen Akun">
    {{-- Bungkus seluruh konten dengan x-data agar state modal terbaca oleh tabel dan modal sekaligus --}}
    <div x-data="{ openDeleteModal: false, deleteUrl: '' }" class="flex flex-col h-full space-y-6">
        
        {{-- HEADER (Judul & Sub-judul digabung jadi satu di sini) --}}
        <div>
            <h1 class="text-2xl font-bold text-[#EDEDED]">Manajemen Akun SINEK-PADI</h1>
            <p class="text-sm text-[#d1d5dc] mt-1">Daftar Akun Petugas & Admin</p>
        </div>

        {{-- Filter & Tombol Tambah Petugas --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            {{-- Search Bar dengan Tombol Kacamata di Kanan --}}
            <form action="{{ route('admin.manajemen-akun') }}" method="GET" class="relative w-full sm:w-72">
                {{-- Input Search (padding kanan ditambah pr-10 agar teks tidak menabrak ikon) --}}
                <input type="text" name="search" value="{{ request('search') }}" class="bg-[#141c1a] border border-[#243733] text-[#EDEDED] text-xs rounded-lg focus:ring-[#3aafa9] focus:border-[#3aafa9] block w-full pl-4 pr-10 p-2.5 placeholder-[#d1d5dc]/60 outline-none transition" placeholder="Cari username / nama...">
                
                {{-- Tombol Ikon Kacamata di Kanan (Bisa diklik atau tekan Enter) --}}
                <button type="submit" class="absolute inset-y-0 right-0 flex items-center pr-3 text-[#d1d5dc] hover:text-[#EDEDED] transition cursor-pointer" title="Cari">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                </button>
            </form>

            {{-- Tombol Tambah Petugas --}}
            <a href="{{ route('admin.manajemen-akun.tambah') }}" class="bg-[#C4C4FA] text-[#0B0909] font-medium text-xs px-4 py-2.5 rounded-lg hover:bg-[#b0b0f7] transition flex items-center space-x-2 cursor-pointer">
                <span>Tambah Petugas</span>
            </a>
        </div>

        {{-- Kotak Tabel Utama --}}
        <div class="bg-[#141c1a] border border-[#243733] rounded-xl overflow-hidden flex-1 flex flex-col justify-between shadow-lg">
            <div>
                <div class="overflow-x-auto">
                    <table class="w-full text-xs text-left text-[#d1d5dc]">
                        <thead class="text-xs text-[#EDEDED] uppercase bg-[#2E4540] border-b border-[#243733]">
                            <tr>
                                <th scope="col" class="px-6 py-3">ID User</th>
                                <th scope="col" class="px-6 py-3">Username</th>
                                <th scope="col" class="px-6 py-3">Nama Lengkap</th>
                                <th scope="col" class="px-6 py-3">Role</th>
                                <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#243733]">
                            @forelse ($users as $user)
                            <tr class="hover:bg-[#243733]/30 transition">
                                <td class="px-6 py-3.5 font-medium text-white">
                                    USR-{{ str_pad($user->id_users ?? 1, 3, '0', STR_PAD_LEFT) }}
                                </td>
                                <td class="px-6 py-3.5">{{ $user->username ?? '-' }}</td>
                                <td class="px-6 py-3.5">{{ $user->name ?? '-' }}</td>
                                <td class="px-6 py-3.5 capitalize">
                                    {{ $user->role->nama_roles ?? 'Petugas Loket' }}
                                </td>
                                <td class="px-6 py-3.5 text-center space-x-2">
                                    {{-- Tombol Edit --}}
                                    <a href="{{ route('admin.manajemen-akun.edit', $user->id_users ?? $user->id) }}" class="text-orange-400 hover:text-orange-300 transition cursor-pointer inline-flex items-center" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                        </svg>
                                    </a>

                                    {{-- Tombol Hapus yang memicu Modal Alpine.js --}}
                                    <button @click="openDeleteModal = true; deleteUrl = '{{ route('admin.manajemen-akun.destroy', $user->id_users ?? $user->id) }}'" type="button" class="text-red-400 hover:text-red-300 transition cursor-pointer inline-flex items-center" title="Hapus Akun">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-[#d1d5dc]/50">
                                    Belum ada data akun yang tersimpan di database.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Bagian Pagination --}}
            <div class="p-3 border-t border-[#243733] text-xs text-[#d1d5dc]">
                {{ $users->links() }}
            </div>
        </div>

        {{-- PANGGIL KOMPONEN MODAL HAPUS --}}
        <x-admin.delete-modal title="Konfirmasi Hapus Akun">
            Apakah kamu yakin ingin menghapus akun ini? Data petugas yang dihapus tidak dapat dikembalikan.
        </x-admin.delete-modal>

    </div>
</x-admin.layout-admin>