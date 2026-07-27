<nav class="bg-[#0B0909] border-b border-[#EDEDED] py-1 px-6 flex justify-between items-center">
    {{-- Kiri --}}
    <div class="flex items-center space-x-0">
        <span class="font-bold text-xl text-[#EDEDED]">Sinek Padi</span>
        <span class="text-sm text-[#EDEDED] pl-4">Dinas Pariwisata Kota Pangkal Pinang</span>
    </div>

    {{-- Kanan --}}
    <div class="flex items-center space-x-4" x-data="{ openLogoutModal: false }">
        {{-- Nama user otomatis dari session --}}
        <span class="text-sm text-[#EDEDED]">Halo, <strong class="text-[#3aafa9]">{{ Auth::user()->name }}</strong></span>
        
        {{-- Tombol Logout (Memicu Modal Terbuka, BUKAN langsung submit) --}}
        <button @click="openLogoutModal = true" type="button" class="w-8 h-8 flex items-center justify-center bg-transparent text-gray-400 hover:text-red-500 transition duration-150 cursor-pointer" title="Logout">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
            </svg>
        </button>

        {{-- Memanggil Komponen Modal yang Sudah Kita Buat --}}
        <x-logout-modal />
    </div>
</nav>