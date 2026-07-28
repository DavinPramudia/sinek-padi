@props(['kategoriKendaraan', 'kategoriWisatawan'])

@php
    $tarifMap = [];
    foreach($kategoriKendaraan as $k) {
        $tarifMap[$k->id_tarif] = $k->harga_tarif;
    }

    $qtyMap = [];
    foreach($kategoriWisatawan as $w) {
        $qtyMap[$w->id_kategori_wisatawan] = 0;
    }
@endphp

{{-- Tambahkan parameter ke-3: URL route untuk proses simpan data --}}
<div x-data="loketTransaksi({{ json_encode($tarifMap) }}, {{ json_encode($qtyMap) }}, '{{ route('transaksi.store') }}')" class="bg-[#2E4540] rounded-3xl p-5 shadow-lg flex flex-col justify-between space-y-6 h-full border border-[#3b5952]">
    
    <div class="space-y-6">
        <div class="pb-2 border-b border-[#3b5952]">
            <h2 class="text-lg font-semibold text-[#ededed]">
                Input Transaksi Tiket & Data Wisatawan
            </h2>
        </div>

        {{-- Kategori Kendaraan --}}
        <div>
            <label class="block text-sm font-semibold text-[#d1d5dc] mb-3">Kategori Kendaraan</label>
            <div class="grid grid-cols-2 gap-4">
                @foreach ($kategoriKendaraan as $item)
                    <button type="button"
                            @click="kategoriKendaraan = '{{ $item->id_tarif }}'"
                            :class="kategoriKendaraan === '{{ $item->id_tarif }}' ? '!bg-[#3aafa9] ring-4 ring-amber-400 font-bold' : 'bg-[#408175]'"
                            class="hover:bg-[#3aafa9] text-[#d1d5dc] rounded-xl p-5 flex flex-col items-center justify-center text-center w-full transition duration-150 shadow-md active:scale-95 border border-[#3b5952]">
                        <span class="text-base font-bold text-[#d1d5dc]">{{ $item->nama_kendaraan }}</span>
                        <span class="text-xs text-[#d1d5dc] mt-1">Rp {{ number_format($item->harga_tarif, 0, ',', '.') }}</span>
                    </button>
                @endforeach
            </div>
        </div>

        {{-- Kategori Wisatawan --}}
        <div>
            <label class="block text-sm font-semibold text-[#d1d5dc] mb-3">Kategori Wisatawan</label>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                @foreach ($kategoriWisatawan as $wisatawan)
                    <div class="bg-[#243733] border border-[#3b5952] p-3 rounded-xl flex flex-col justify-between shadow-inner">
                        <div class="mb-2">
                            <span class="block text-xs font-semibold text-[#d1d5dc] text-center">
                                {{ $wisatawan->nama_kategori_wisatawan }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between bg-[#1C2B28] rounded-lg p-1 border border-[#3b5952]">
                            <button type="button" @click="kurang('{{ $wisatawan->id_kategori_wisatawan }}')" class="w-7 h-7 rounded bg-[#2a3d38] text-[#d1d5dc] flex items-center justify-center font-bold text-sm hover:bg-[#3b544e] transition active:scale-95">-</button>
                            <span class="w-8 bg-transparent text-[#d1d5dc] text-center font-bold text-xs" x-text="qty['{{ $wisatawan->id_kategori_wisatawan }}']">0</span>
                            <button type="button" @click="tambah('{{ $wisatawan->id_kategori_wisatawan }}')" class="w-7 h-7 rounded bg-[#408175] text-[#d1d5dc] flex items-center justify-center font-bold text-sm hover:bg-[#4ea091] transition active:scale-95">+</button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- TOTAL BAYAR & TOMBOL CETAK --}}
    <div class="pt-4 border-t border-[#3b5952]">
        <div class="flex justify-between items-end mb-4">
            <div>
                <span class="block text-xs text-[#ededed]">Total Pembayaran</span>
                <span class="text-2xl font-bold text-[#3aafa9]" x-text="formatRupiah(totalBayar)"></span>
            </div>
            <span class="text-xs text-[#d1d5dc]"><span x-text="totalPengunjung">0</span> Pengunjung</span>
        </div>

        <button type="button" 
                @click="bukaModal()"
                class="w-full bg-[#408175] hover:bg-[#3aafa9] active:scale-95 text-white font-bold py-3.5 rounded-xl shadow-lg transition duration-150 flex items-center justify-center space-x-2">
            <span>Cetak Tiket & Bayar</span>
        </button>
    </div>
    <x-print-modal />
    <x-alert-modal />
</div>