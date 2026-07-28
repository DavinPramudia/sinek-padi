<header class="bg-[#0B0909] border-b border-[#243733] px-8 py-4 flex justify-between items-center shrink-0">
    <div class="text-xs text-[#d1d5dc]">
        Home / <span class="text-white font-medium">Dashboard</span>
    </div>
    <div class="flex items-center space-x-6 text-xs">
        <span class="text-[#d1d5dc]">Halo Selamat Siang, <strong class="text-white">Admin</strong></span>
        <div class="flex items-center space-x-2">
            <button class="text-[#d1d5dc] hover:text-white p-1">?</button>
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="text-[#d1d5dc] hover:text-white p-1 cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                </button>
            </form>
        </div>
    </div>
</header>