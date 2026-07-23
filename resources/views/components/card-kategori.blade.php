<div x-data="loketTransaksi()" class="bg-[#2E4540] rounded-3xl p-5 shadow-lg flex flex-col justify-between space-y-6 h-full border border-[#3b5952]">
    
    <div class="space-y-6">
        {{-- Header Judul Utama --}}
        <div class="pb-2 border-b border-[#3b5952]">
            <h2 class="text-lg font-semibold text-[#ededed]">
                Input Transaksi Tiket & Data Wisatawan
            </h2>
        </div>

        {{-- Bagian Kategori Kendaraan --}}
        <div>
            <label class="block text-sm font-semibold text-[#d1d5dc] mb-3">
                Kategori Kendaraan
            </label>
            
            <div class="grid grid-cols-2 gap-4">
                @php
                    $KategoriKendaraan = [
                        ['id' => 'motor', 'label' => 'Motor (Roda 2)'],
                        ['id' => 'mobil', 'label' => 'Mobil (Roda 4)'],
                    ];
                @endphp

                @foreach ($KategoriKendaraan as $item)
                    <button type="button"
                            @click="kategoriKendaraan = '{{ $item['id'] }}'"
                            :class="kategoriKendaraan === '{{ $item['id'] }}' ? '!bg-[#3aafa9] ring-4 ring-amber-400 font-bold' : 'bg-[#408175]'"
                            class="hover:bg-[#3aafa9] text-[#d1d5dc] rounded-xl p-5 flex flex-col items-center justify-center text-center w-full transition duration-150 shadow-md active:scale-95 outline-none border border-[#3b5952]">
                        <span class="text-base font-bold text-[#d1d5dc]">{{ $item['label'] }}</span>
                    </button>
                @endforeach
            </div>
        </div>

        {{-- Bagian Kategori Wisatawan --}}
        <div>
            <label class="block text-sm font-semibold text-[#d1d5dc] mb-3">
                Kategori Wisatawan
            </label>
        
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                @php
                    $KategoriWisatawan = [
                        ['id' => 'lokal', 'label' => 'Lokal Bangka'],
                        ['id' => 'nusantara', 'label' => 'Nusantara'],
                        ['id' => 'asing', 'label' => 'Mancanegara'],
                    ];
                @endphp

                @foreach ($KategoriWisatawan as $wisatawan)
                    <div class="bg-[#243733] border border-[#3b5952] p-3 rounded-xl flex flex-col justify-between shadow-inner">
                        <div class="mb-2">
                            <span class="block text-xs font-semibold text-[#d1d5dc] text-center">
                                {{ $wisatawan['label'] }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between bg-[#1C2B28] rounded-lg p-1 border border-[#3b5952]">
                            <button type="button" @click="kurang('{{ $wisatawan['id'] }}')" class="w-7 h-7 rounded bg-[#2a3d38] text-[#d1d5dc] flex items-center justify-center font-bold text-sm hover:bg-[#3b544e] transition active:scale-95">
                                -
                            </button>
                            
                            {{-- Menggunakan span agar angkanya muncul reaktif tanpa merusak desain kotak input --}}
                            <span class="w-8 bg-transparent text-[#d1d5dc] text-center font-bold text-xs flex items-center justify-center" x-text="qty.{{ $wisatawan['id'] }}">0</span>
                            
                            <button type="button" @click="tambah('{{ $wisatawan['id'] }}')" class="w-7 h-7 rounded bg-[#408175] text-[#d1d5dc] flex items-center justify-center font-bold text-sm hover:bg-[#4ea091] transition active:scale-95">
                                +
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Bagian TOTAL BAYAR & TOMBOL CETAK TIKET --}}
    <div class="pt-4 border-t border-[#3b5952]">
        <div class="flex justify-between items-end mb-4">
            <div>
                <span class="block text-xs text-[#ededed]">Total Pembayaran</span>
                <span class="text-2xl font-bold text-[#3aafa9]" x-text="formatRupiah(totalBayar)">Rp 0</span>
            </div>
            <span class="text-xs text-[#d1d5dc]"><span x-text="totalPengunjung">0</span> Pengunjung</span>
        </div>

        <button type="button" 
                class="w-full bg-[#408175] hover:bg-[#3aafa9] text-white font-bold py-3.5 rounded-xl shadow-lg transition duration-150 flex items-center justify-center space-x-2 active:scale-95">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 000-4H9a2 2 0 000 4zm8-12V5a2 2 0 00-2-2H7a2 2 0 00-2 2v4h14z"></path>
            </svg>
            <span>Cetak Tiket & Bayar</span>
        </button>
    </div>

</div>
