<div class="bg-[#2E4540] rounded-3xl p-5 shadow-lg flex flex-col justify-between h-full space-y-4">
    
    {{-- Header Ringkasan --}}
    <div class="flex justify-between items-center mb-1">
        <h2 class="text-lg font-semibold text-[#EDEDED]">
            Ringkasan Hari Ini
        </h2>
        <span class="text-[10px] text-gray-400 bg-[#1c2b28] px-2 py-0.5 rounded border border-[#3b5952]">
            {{ date('d M Y') }}
        </span>
    </div>

    {{-- Grid Box Statistik --}}
    <div class="grid grid-cols-2 gap-3 flex-1">
        
        {{-- Box 1: Total Pendapatan --}}
        <div class="bg-[#1c2b28] p-3.5 rounded-xl border border-[#3b5952] flex flex-col justify-between">
            <span class="block text-[11px] text-gray-400">Total Pendapatan</span>
            <span class="text-base font-bold text-white mt-1">Rp 1.450.000</span>
        </div>

        {{-- Box 2: Total Tiket --}}
        <div class="bg-[#1c2b28] p-3.5 rounded-xl border border-[#3b5952] flex flex-col justify-between">
            <span class="block text-[11px] text-gray-400">Tiket Terbit</span>
            <span class="text-base font-bold text-[#EDEDED] mt-1">128 <span class="text-xs font-normal text-gray-400">Tiket</span></span>
        </div>

        {{-- Box 3: Total Motor --}}
        <div class="bg-[#1c2b28] p-3.5 rounded-xl border border-[#3b5952] flex flex-col justify-between">
            <span class="block text-[11px] text-gray-400">Total Motor</span>
            <span class="text-base font-bold text-white mt-1">85 <span class="text-xs font-normal text-gray-400">Motor</span></span>
        </div>

        {{-- Box 4: Total Mobil --}}
        <div class="bg-[#1c2b28] p-3.5 rounded-xl border border-[#3b5952] flex flex-col justify-between">
            <span class="block text-[11px] text-gray-400">Total Mobil</span>
            <span class="text-base font-bold text-[#EDEDED] mt-1">43 <span class="text-xs font-normal text-gray-400">Mobil</span></span>
        </div>

        {{-- Box 5 & 6: Total Wisatawan --}}
        <div class="col-span-2 bg-[#1c2b28] p-4 rounded-xl border border-[#3b5952] flex justify-between items-center">
            <div>
                <span class="block text-[11px] text-gray-400">Total Wisatawan Hari Ini</span>
                <span class="text-xs text-gray-400">Lokal, Nusantara & Foreign</span>
            </div>
            <span class="text-xl font-bold text-[#3aafa9]">128 <span class="text-xs font-normal text-gray-400">Pengunjung</span></span>
        </div>

    </div>

    {{-- Footer Status --}}
    <div class="pt-3 border-t border-[#3b5952] flex justify-between items-center text-xs text-gray-400">
        <span>Status Server: <strong class="text-emerald-400 font-semibold">Online</strong></span>
        <span>Printer: <strong class="text-[#3aafa9] font-semibold">Terhubung</strong></span>
    </div>

</div>