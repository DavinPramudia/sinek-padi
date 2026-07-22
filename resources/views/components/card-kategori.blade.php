<div class="bg-brand-card rounded-3xl p-5 shadow-lg flex flex-col justify-between space-y-6 h-full">
    
    <div class="space-y-6">
        {{-- Header Judul Utama Kontainer Kiri --}}
        <div class="pb-2 border-b border-[#3b5952]">
            <h2 class="text-lg font-semibold text-brand-text">
                Input Transaksi Tiket & Data Wisatawan
            </h2>
        </div>

        {{-- Bagian Kategori Kendaraan --}}
        <div>
            <label class="block text-sm font-semibold text-brand-text mb-3">
                Kategori Kendaraan
            </label>
            
            <div class="grid grid-cols-2 gap-4">
                @php
                    $kendaraan = [
                        ['id' => 'motor', 'label' => 'Motor', 'icon' => 'motorcycle.png'],
                        ['id' => 'mobil', 'label' => 'Mobil', 'icon' => 'car.png'],
                    ];
                @endphp

                @foreach ($kendaraan as $item)
                    <button type="button"
                            id="btn-{{ $item['id'] }}"
                            onclick="pilihKategori('{{ $item['id'] }}')"
                            class="bg-[#408175] hover:bg-[#3aafa9] text-brand-text rounded-xl p-4 flex flex-col items-center justify-center text-center w-full transition duration-150 shadow-md">
                        <img src="{{ asset('assets/icons/' . $item['icon']) }}" class="w-10 h-10 object-contain mb-1" alt="{{ $item['label'] }}">
                        <span class="text-xs font-semibold text-[#d1d5dc]">{{ $item['label'] }}</span>
                    </button>

                {{-- Tombol Motor --}}
                {{-- <button type="button"
                        id="btn-motor"
                        onclick="pilihKategori('motor')"
                        class="bg-[#408175] hover:bg-[#3aafa9] text-brand-text rounded-xl p-4 flex flex-col items-center justify-center text-center w-full transition duration-150 shadow-md">
                    <img src="{{ asset('assets/icons/motorcycle.png') }}" class="w-10 h-10 object-contain mb-1" alt="Motor">
                    <span class="text-xs font-semibold text-[#d1d5dc]">Motor</span>
                </button> --}}

                {{-- Tombol Mobil --}}
                {{-- <button type="button"   
                        id="btn-mobil"
                        onclick="pilihKategori('mobil')"
                        class="bg-[#408175] hover:bg-[#3aafa9] text-brand-text rounded-xl p-4 flex flex-col items-center justify-center text-center w-full transition duration-150 shadow-md">
                    <img src="{{ asset('assets/icons/car.png') }}" class="w-10 h-10 object-contain mb-1" alt="Mobil">
                    <span class="text-xs font-semibold text-[#d1d5dc]">Mobil</span>
                </button> --}}
                
            </div>
        </div>

        {{-- Bagian Kategori Wisatawan --}}
        <div>
            <label class="block text-sm font-semibold text-[#d1d5dc] mb-3">
                Kategori Wisatawan
            </label>
        
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                
                {{-- 1. Lokal Bangka --}}
                <div class="bg-[#243733] border border-[#3b5952] p-3 rounded-xl flex flex-col justify-between">
                    <div class="mb-2">
                        <span class="block text-xs font-semibold text-[#d1d5dc] text-center">Lokal Bangka</span>
                    </div>
                    <div class="flex items-center justify-between bg-[#1c2b28] rounded-lg p-1">
                        <button type="button" class="w-7 h-7 rounded bg-[#2a3d38] text-[#d1d5dc] flex items-center justify-center font-bold text-sm hover:bg-[#3b544e] transition active:scale-95">-</button>
                        <input type="number" value="0" min="0" readonly class="w-8 bg-transparent text-[#d1d5dc] text-center font-bold text-xs focus:outline-none">
                        <button type="button" class="w-7 h-7 rounded bg-[#408175] text-[#d1d5dc] flex items-center justify-center font-bold text-sm hover:bg-[#4ea091] transition active:scale-95">+</button>
                    </div>
                </div>

                {{-- 2. Wisatawan Nusantara --}}
                <div class="bg-[#243733] border border-[#3b5952] p-3 rounded-xl flex flex-col justify-between">
                    <div class="mb-2">
                        <span class="block text-xs font-semibold text-[#d1d5dc] text-center">Nusantara</span>
                    </div>
                    <div class="flex items-center justify-between bg-[#1c2b28] rounded-lg p-1">
                        <button type="button" class="w-7 h-7 rounded bg-[#2a3d38] text-[#d1d5dc] flex items-center justify-center font-bold text-sm hover:bg-[#3b544e] transition active:scale-95">-</button>
                        <input type="number" value="0" min="0" readonly class="w-8 bg-transparent text-[#d1d5dc] text-center font-bold text-xs focus:outline-none">
                        <button type="button" class="w-7 h-7 rounded bg-[#408175] text-[#d1d5dc] flex items-center justify-center font-bold text-sm hover:bg-[#4ea091] transition active:scale-95">+</button>
                    </div>
                </div>

                {{-- 3. Wisatawan Asing --}}
                <div class="bg-[#243733] border border-[#3b5952] p-3 rounded-xl flex flex-col justify-between">
                    <div class="mb-2">
                        <span class="block text-xs font-semibold text-[#d1d5dc] text-center">Mancanegara</span>
                    </div>
                    <div class="flex items-center justify-between bg-[#1c2b28] rounded-lg p-1">
                        <button type="button" class="w-7 h-7 rounded bg-[#2a3d38] text-[#d1d5dc] flex items-center justify-center font-bold text-sm hover:bg-[#3b544e] transition active:scale-95">-</button>
                        <input type="number" value="0" min="0" readonly class="w-8 bg-transparent text-[#d1d5dc] text-center font-bold text-xs focus:outline-none">
                        <button type="button" class="w-7 h-7 rounded bg-[#408175] text-[#d1d5dc] flex items-center justify-center font-bold text-sm hover:bg-[#4ea091] transition active:scale-95">+</button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Bagian TOTAL BAYAR & TOMBOL CETAK TIKET --}}
    <div class="pt-4 border-t border-[#3b5952]">
        <div class="flex justify-between items-end mb-4">
            <div>
                <span class="block text-xs text-text">Total Pembayaran</span>
                <span class="text-2xl font-bold text-[#3aafa9]">Rp 22.000</span>
            </div>
            <span class="text-xs text-text">3 Pengunjung</span>
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