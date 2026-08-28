<nav class="bg-[#0B0909]/50 border-b border-[#EDEDED] py-1 px-6 flex justify-between items-center sticky top-0 z-50">
    {{-- Kiri --}}
    <div class="flex items-center space-x-0">
        <span class="font-bold text-xl text-[#EDEDED]">Sinek Padi</span>
        <span class="text-sm text-[#EDEDED] pl-4">Dinas Pariwisata Kota Pangkal Pinang</span>
    </div>

    {{-- Kanan --}}
    <div class="flex items-center space-x-4" x-data="{ openLogoutModal: false }">
        {{-- Nama user otomatis dari session --}}
        <span class="text-sm text-[#EDEDED]">Halo, <strong class="text-[#3aafa9]">{{ Auth::user()->name }}</strong></span>
        
        <a href="{{ route('profile.edit') }}" class="w-8 h-8 flex items-center justify-center bg-transparent text-gray-400 hover:text-[#3aafa9] transition duration-150 cursor-pointer" title="Profil & Ganti Password">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
              <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
            </svg>
        </a>

        {{-- Tombol Logout --}}
        <button @click="openLogoutModal = true" type="button" class="w-8 h-8 flex items-center justify-center bg-transparent text-gray-400 hover:text-red-500 transition duration-150 cursor-pointer" title="Logout">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
            </svg>
        </button>

        {{-- Memanggil Komponen Modal Logout --}}
        <x-logout-modal title="Konfirmasi Logout">
            Apakah kamu yakin ingin keluar ?
        </x-logout-modal>
    </div>
</nav>