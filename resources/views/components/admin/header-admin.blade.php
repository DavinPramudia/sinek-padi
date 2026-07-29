<header class="bg-[#0B0909]/50 border-b border-[#243733] px-8 py-4 flex justify-between items-center shrink-0">
    
    {{-- Breadcrumb Kiri (Sekarang Dinamis) --}}
    <div class="text-xs text-[#d1d5dc]">
        Sinek Padi / <span class="text-white font-medium">{{ $title }}</span>
    </div>
    
    {{-- Kanan --}}
    {{-- Tambahkan x-data untuk Alpine.js di sini agar setara dengan petugas --}}
    <div class="flex items-center space-x-6 text-xs" x-data="{ openLogoutModal: false }">
        
        {{-- Sapaan User (Warnanya disamakan dengan Petugas: #3aafa9) --}}
        <span class="text-[#d1d5dc] text-sm">
            Halo Selamat Siang, <strong class="text-[#3aafa9]">{{ Auth::user()->name }}</strong>
        </span>
        
        <div class="flex items-center space-x-2">
            <button class="text-[#d1d5dc] hover:text-white p-1 cursor-pointer">?</button>
            
            <button @click="openLogoutModal = true" type="button" class="text-[#d1d5dc] hover:text-red-500 p-1 cursor-pointer transition duration-150" title="Logout">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
            </button>
        </div>

        {{-- Memanggil Komponen Modal Logout agar ada konfirmasi --}}
        <x-logout-modal />
    </div>
    
</header>