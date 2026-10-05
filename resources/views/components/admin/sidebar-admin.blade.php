<aside class="w-64 bg-[#141c1a] border-r border-[#243733] flex flex-col justify-between p-5 shrink-0 h-full">
    <div class="space-y-8">
        <!-- Logo Sinek Padi -->
        <div class="flex justify-center items-center px-2 py-2">
            <img src="/assets/images/logo-sinek-padi.png" alt="Logo Sinek Padi" class="h-20 w-auto object-contain" />
        </div>

        <!-- Menu Navigasi Sidebar -->
        <nav class="space-y-1.5 text-xs font-medium">
    
            <!-- Dashboard -->
            <a href="{{ route('admin.dashboard') }}" 
            class="flex items-center space-x-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('admin.dashboard*') ? 'bg-[#2E4540] text-[#3aafa9]' : 'hover:bg-[#243733] text-[#d1d5dc]' }}">
                <span>Dashboard</span>
            </a>

            <!-- Laporan Transaksi -->
            <a href="{{ route('admin.laporan-transaksi') }}" 
            class="flex items-center space-x-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('admin.laporan*') ? 'bg-[#2E4540] text-[#3aafa9]' : 'hover:bg-[#243733] text-[#d1d5dc]' }}">
                <span>Laporan Transaksi</span>
            </a>

            <!-- Manajemen Akun -->
            <a href="{{ route('admin.manajemen-akun') }}" 
            class="flex items-center space-x-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('admin.manajemen-akun*') ? 'bg-[#2E4540] text-[#3aafa9]' : 'hover:bg-[#243733] text-[#d1d5dc]' }}">
                <span>Manajemen Akun</span>
            </a>

            <!-- Pengaturan -->
            <a href="{{ route('admin.pengaturan') }}" 
            class="flex items-center space-x-3 px-4 py-3 rounded-xl transition {{ request()->routeIs('admin.pengaturan*') ? 'bg-[#2E4540] text-[#3aafa9]' : 'hover:bg-[#243733] text-[#d1d5dc]' }}">
                <span>Pengaturan</span>
            </a>

        </nav>
    </div>

    <!-- Profil Admin di Bagian Bawah Sidebar -->
    <div class="border-t border-[#243733] pt-4 px-2">
        <div class="flex items-center space-x-3 text-xs text-[#d1d5dc]">
            
            <div class="w-7 h-7 rounded-full bg-[#2E4540] flex items-center justify-center font-bold text-[#3aafa9] shrink-0">
                {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
            </div>
            
            <div class="flex flex-col overflow-hidden">
                <span class="font-medium text-white truncate">{{ auth()->user()->name ?? 'User' }}</span>
            </div>
        </div>
    </div>
</aside>