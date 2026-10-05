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
        
        <div class="bg-[#1c2b28] p-3.5 rounded-xl border border-[#3b5952] flex flex-col justify-between">
            <span class="block text-[11px] text-[#d1d5dc]">Total Pendapatan</span>
            <span class="text-base font-bold text-[#EDEDED] mt-1">
                Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}
            </span>
        </div>

        <div class="bg-[#1c2b28] p-3.5 rounded-xl border border-[#3b5952] flex flex-col justify-between">
            <span class="block text-[11px] text-[#d1d5dc]">Tiket Terbit</span>
            <span class="text-base font-bold text-[#EDEDED] mt-1">
                {{ $totalTiket ?? 0 }} <span class="text-xs font-normal text-[#d1d5dc]">Tiket</span>
            </span>
        </div>

        @foreach($statistikKendaraan as $kendaraan)
            <div class="bg-[#1c2b28] p-3.5 rounded-xl border border-[#3b5952] flex flex-col justify-between">
                <span class="block text-[11px] text-[#d1d5dc]">Total {{ $kendaraan->nama }}</span>
                <span class="text-base font-bold text-[#EDEDED] mt-1">
                    {{ $kendaraan->total ?? 0 }} <span class="text-xs font-normal text-[#d1d5dc]">{{ $kendaraan->nama }}</span>
                </span>
            </div>
        @endforeach

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

</div>