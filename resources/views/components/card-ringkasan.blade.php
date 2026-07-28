<div class="bg-[#2E4540] rounded-3xl p-5 shadow-lg flex flex-col justify-between h-full space-y-4 border border-[#3b5952]">
    
    {{-- Header Ringkasan --}}
    <div class="flex justify-between items-center pb-2 border-b border-[#3b5952]">
        <h2 class="text-lg font-semibold text-[#EDEDED]">
            Ringkasan Hari Ini
        </h2>
        <span class="text-[10px] text-[#d1d5dc] bg-[#1c2b28] px-2 py-0.5 rounded border border-[#3b5952]">
            {{ now()->format('d M Y') }}
        </span>
    </div>

    {{-- Grid Box Statistik --}}
    <div class="grid grid-cols-2 gap-3 flex-1">
        
        {{-- Box 1: Total Pendapatan --}}
        <div class="bg-[#1c2b28] p-3.5 rounded-xl border border-[#3b5952] flex flex-col justify-between">
            <span class="block text-[11px] text-[#d1d5dc]">Total Pendapatan</span>
            <span class="text-base font-bold text-[#EDEDED] mt-1">
                Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}
            </span>
        </div>

        {{-- Box 2: Total Tiket --}}
        <div class="bg-[#1c2b28] p-3.5 rounded-xl border border-[#3b5952] flex flex-col justify-between">
            <span class="block text-[11px] text-[#d1d5dc]">Tiket Terbit</span>
            <span class="text-base font-bold text-[#EDEDED] mt-1">
                {{ $totalTiket ?? 0 }} <span class="text-xs font-normal text-[#d1d5dc]">Tiket</span>
            </span>
        </div>

        {{-- Box 3: Total Motor --}}
        <div class="bg-[#1c2b28] p-3.5 rounded-xl border border-[#3b5952] flex flex-col justify-between">
            <span class="block text-[11px] text-[#d1d5dc]">Total Motor</span>
            <span class="text-base font-bold text-[#EDEDED] mt-1">
                {{ $totalMotor ?? 0 }} <span class="text-xs font-normal text-[#d1d5dc]">Motor</span>
            </span>
        </div>

        {{-- Box 4: Total Mobil --}}
        <div class="bg-[#1c2b28] p-3.5 rounded-xl border border-[#3b5952] flex flex-col justify-between">
            <span class="block text-[11px] text-[#d1d5dc]">Total Mobil</span>
            <span class="text-base font-bold text-[#EDEDED] mt-1">
                {{ $totalMobil ?? 0 }} <span class="text-xs font-normal text-[#d1d5dc]">Mobil</span>
            </span>
        </div>

        {{-- Box 5: Total Wisatawan --}}
        <div class="col-span-2 bg-[#1c2b28] p-4 rounded-xl border border-[#3b5952] flex justify-between items-center">
            <div>
                <span class="block text-[11px] text-[#d1d5dc]">Total Wisatawan Hari Ini</span>
                <span class="text-xs text-[#d1d5dc]">Lokal, Nusantara & Mancanegara</span>
            </div>
            <span class="text-xl font-bold text-[#3aafa9]">
                {{ $totalWisatawan ?? 0 }} <span class="text-xs font-normal text-[#d1d5dc]">Pengunjung</span>
            </span>
        </div>

    </div>

    {{-- Footer Status dengan Indikator Animasi --}}
    <div class="pt-3 border-t border-[#3b5952] flex justify-between items-center text-xs text-[#d1d5dc]">
        <span class="flex items-center space-x-1.5">
            <span class="relative flex h-2 w-2">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
            </span>
            <span>Status Server: <strong class="text-emerald-400 font-semibold">Online</strong></span>
        </span>
        
        <span class="flex items-center space-x-1.5">
            <span class="relative flex h-2 w-2">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-teal-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-2 w-2 bg-[#3aafa9]"></span>
            </span>
            <span>Printer: <strong class="text-[#3aafa9] font-semibold">Terhubung</strong></span>
        </span>
    </div>

</div>