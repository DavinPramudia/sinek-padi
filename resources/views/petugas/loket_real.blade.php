<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sinek Padi - Form Petugas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Hilangkan spinner panah bawaan input number */
        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        input[type="number"] { -moz-appearance: textfield; }
    </style>
</head>

<body class="bg-[#0B0909] text-[#EDEDED] font-sans antialiased">

    <x-header-petugas></x-header-petugas>

    {{-- Body Utama --}}
    <div class="max-w-7xl mx-auto px-4 py-5 space-y-6">

        {{-- GRID ATAS: PEMBAGI 2 KOLOM (KIRI: INPUT, KANAN: STATISTIK) --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-stretch"> 

            {{-- ========================================================= --}}
            {{-- 1. KONTANER KIRI (INPUT TRANSAKSI)                       --}}
            {{-- ========================================================= --}}
            <div class="bg-[#2E4540] rounded-3xl p-5 shadow-lg flex flex-col justify-between space-y-6 h-full">
                
                <div class="space-y-6">
                    {{-- Bagian Kategori Kendaraan --}}
                    <div>
                        <label class="block text-lg font-semibold text-[#EDEDED] mb-3">
                            Kategori Kendaraan
                        </label>
                        
                        <div class="grid grid-cols-2 gap-4">
                            {{-- Tombol Motor --}}
                            <button type="button"
                                    id="btn-motor"
                                    onclick="pilihKategori('motor')"
                                    class="bg-[#408175] hover:bg-[#3aafa9] text-[#EDEDED] rounded-xl p-4 flex flex-col items-center justify-center text-center w-full transition duration-150 shadow-md">
                                <img src="{{ asset('assets/icons/motorcycle.png') }}" class="w-10 h-10 object-contain mb-1" alt="Motor">
                                <span class="text-xs font-semibold">Motor</span>
                            </button>

                            {{-- Tombol Mobil --}}
                            <button type="button"   
                                    id="btn-mobil"
                                    onclick="pilihKategori('mobil')"
                                    class="bg-[#408175] hover:bg-[#3aafa9] text-[#EDEDED] rounded-xl p-4 flex flex-col items-center justify-center text-center w-full transition duration-150 shadow-md">
                                <img src="{{ asset('assets/icons/car.png') }}" class="w-10 h-10 object-contain mb-1" alt="Mobil">
                                <span class="text-xs font-semibold">Mobil</span>
                            </button>
                        </div>
                    </div>

                    {{-- Bagian Kategori Wisatawan --}}
                    <div>
                        <label class="block text-lg font-semibold text-[#EDEDED] mb-3">
                            Kategori Wisatawan
                        </label>
                    
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                            
                            {{-- 1. Lokal Bangka --}}
                            <div class="bg-[#243733] border border-[#3b5952] p-3 rounded-xl flex flex-col justify-between">
                                <div class="mb-2">
                                    <span class="block text-xs font-semibold text-[#EDEDED] text-center">Lokal Bangka</span>
                                </div>
                                <div class="flex items-center justify-between bg-[#1c2b28] rounded-lg p-1">
                                    <button type="button" class="w-7 h-7 rounded bg-[#2a3d38] text-white flex items-center justify-center font-bold text-sm hover:bg-[#3b544e] transition active:scale-95">-</button>
                                    <input type="number" value="0" min="0" readonly class="w-8 bg-transparent text-white text-center font-bold text-xs focus:outline-none">
                                    <button type="button" class="w-7 h-7 rounded bg-[#408175] text-white flex items-center justify-center font-bold text-sm hover:bg-[#4ea091] transition active:scale-95">+</button>
                                </div>
                            </div>

                            {{-- 2. Wisatawan Nusantara --}}
                            <div class="bg-[#243733] border border-[#3b5952] p-3 rounded-xl flex flex-col justify-between">
                                <div class="mb-2">
                                    <span class="block text-xs font-semibold text-[#EDEDED] text-center">Nusantara</span>
                                </div>
                                <div class="flex items-center justify-between bg-[#1c2b28] rounded-lg p-1">
                                    <button type="button" class="w-7 h-7 rounded bg-[#2a3d38] text-white flex items-center justify-center font-bold text-sm hover:bg-[#3b544e] transition active:scale-95">-</button>
                                    <input type="number" value="0" min="0" readonly class="w-8 bg-transparent text-white text-center font-bold text-xs focus:outline-none">
                                    <button type="button" class="w-7 h-7 rounded bg-[#408175] text-white flex items-center justify-center font-bold text-sm hover:bg-[#4ea091] transition active:scale-95">+</button>
                                </div>
                            </div>

                            {{-- 3. Wisatawan Asing --}}
                            <div class="bg-[#243733] border border-[#3b5952] p-3 rounded-xl flex flex-col justify-between">
                                <div class="mb-2">
                                    <span class="block text-xs font-semibold text-[#EDEDED] text-center">Mancanegara</span>
                                </div>
                                <div class="flex items-center justify-between bg-[#1c2b28] rounded-lg p-1">
                                    <button type="button" class="w-7 h-7 rounded bg-[#2a3d38] text-white flex items-center justify-center font-bold text-sm hover:bg-[#3b544e] transition active:scale-95">-</button>
                                    <input type="number" value="0" min="0" readonly class="w-8 bg-transparent text-white text-center font-bold text-xs focus:outline-none">
                                    <button type="button" class="w-7 h-7 rounded bg-[#408175] text-white flex items-center justify-center font-bold text-sm hover:bg-[#4ea091] transition active:scale-95">+</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- Bagian TOTAL BAYAR & TOMBOL CETAK TIKET --}}
                <div class="pt-4 border-t border-[#3b5952]">
                    <div class="flex justify-between items-end mb-4">
                        <div>
                            <span class="block text-xs text-gray-400">Total Pembayaran</span>
                            <span class="text-2xl font-bold text-[#3aafa9]">Rp 22.000</span>
                        </div>
                        <span class="text-[11px] text-gray-400">3 Pengunjung</span>
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

            {{-- ========================================================= --}}
            {{-- 2. KONTANER KANAN (RINGKASAN HARI INI FULL BOX)           --}}
            {{-- ========================================================= --}}
            <div class="bg-[#2E4540] rounded-3xl p-5 shadow-lg flex flex-col justify-between h-full space-y-4">
                
                {{-- Header Ringkasan (Font Disamakan) --}}
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

                    {{-- Box 5 & 6: Melebar Penuh di Baris Paling Bawah (col-span-2) --}}
                    <div class="col-span-2 bg-[#1c2b28] p-4 rounded-xl border border-[#3b5952] flex justify-between items-center">
                        <div>
                            <span class="block text-[11px] text-gray-400">Total Wisatawan Hari Ini</span>
                            <span class="text-xs text-gray-400">Lokal, Nusantara & Foreign</span>
                        </div>
                        <span class="text-xl font-bold text-[#3aafa9]">128 <span class="text-xs font-normal text-gray-400">Pengunjung</span></span>
                    </div>

                </div>

                {{-- Footer Info Tambahan Penyeimbang --}}
                <div class="pt-3 border-t border-[#3b5952] flex justify-between items-center text-xs text-gray-400">
                    <span>Status Server: <strong class="text-emerald-400 font-semibold">Online</strong></span>
                    <span>Printer: <strong class="text-[#3aafa9] font-semibold">Terhubung</strong></span>
                </div>

            </div>

        </div> 

        {{-- ========================================================= --}}
        {{-- 3. AREA TABEL RIWAYAT TERAKHIR (LEBAR FULL DI BAWAH)        --}}
        {{-- ========================================================= --}}
        <div class="bg-[#2E4540] rounded-3xl p-5 shadow-lg border border-[#3b5952]/50">
            
            {{-- Header Tabel Riwayat (Font Disamakan) --}}
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold text-[#EDEDED]">
                    Riwayat Transaksi Terakhir
                </h2>
                <span class="text-[11px] text-gray-400">Menampilkan transaksi terbaru hari ini</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-[#3b5952] text-[11px] text-gray-400 uppercase tracking-wider">
                            <th class="pb-3 pl-2">No Karcis</th>
                            <th class="pb-3">Waktu</th>
                            <th class="pb-3">Kendaraan</th>
                            <th class="pb-3 text-center">Sensus (L / N / M)</th>
                            <th class="pb-3">Biaya</th>
                            <th class="pb-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-xs divide-y divide-[#3b5952]/40">
                        
                        <!-- Baris Data 1 -->
                        <tr class="hover:bg-[#1c2b28]/60 transition duration-150">
                            <td class="py-3 pl-2 font-mono text-white font-semibold">KRC260712-0001</td>
                            <td class="py-3 text-gray-300">26/07/2026, 15:30 WIB</td>
                            <td class="py-3">
                                <span class="bg-[#243733] text-gray-200 px-2.5 py-1 rounded-md text-[11px] border border-[#3b5952]">
                                    Motor
                                </span>
                            </td>
                            <td class="py-3 text-center">
                                <span class="bg-[#1c2b28] text-[#3aafa9] font-mono px-2.5 py-1 rounded border border-[#3b5952] text-[11px]">
                                    1 / 2 / 0
                                </span>
                            </td>
                            <td class="py-3 font-bold text-[#3aafa9] text-sm">Rp 12.000</td>
                            <td class="py-3 text-center">
                                <button type="button" class="border border-[#3aafa9] text-[#3aafa9] hover:bg-[#3aafa9] hover:text-[#0B0909] text-[10px] font-bold py-1.5 px-3 rounded-xl transition duration-150 flex items-center justify-center space-x-1.5 mx-auto active:scale-95">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 000-4H9a2 2 0 000 4zm8-12V5a2 2 0 00-2-2H7a2 2 0 00-2 2v4h14z"></path>
                                    </svg>
                                    <span>Print Ulang</span>
                                </button>
                            </td>
                        </tr>

                        <!-- Baris Data 2 -->
                        <tr class="hover:bg-[#1c2b28]/60 transition duration-150">
                            <td class="py-3 pl-2 font-mono text-white font-semibold">KRC260712-0002</td>
                            <td class="py-3 text-gray-300">26/07/2026, 15:35 WIB</td>
                            <td class="py-3">
                                <span class="bg-[#243733] text-gray-200 px-2.5 py-1 rounded-md text-[11px] border border-[#3b5952]">
                                    Mobil
                                </span>
                            </td>
                            <td class="py-3 text-center">
                                <span class="bg-[#1c2b28] text-[#3aafa9] font-mono px-2.5 py-1 rounded border border-[#3b5952] text-[11px]">
                                    2 / 1 / 1
                                </span>
                            </td>
                            <td class="py-3 font-bold text-[#3aafa9] text-sm">Rp 40.000</td>
                            <td class="py-3 text-center">
                                <button type="button" class="border border-[#3aafa9] text-[#3aafa9] hover:bg-[#3aafa9] hover:text-[#0B0909] text-[10px] font-bold py-1.5 px-3 rounded-xl transition duration-150 flex items-center justify-center space-x-1.5 mx-auto active:scale-95">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 000-4H9a2 2 0 000 4zm8-12V5a2 2 0 00-2-2H7a2 2 0 00-2 2v4h14z"></path>
                                    </svg>
                                    <span>Print Ulang</span>
                                </button>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>

    </div>
</body>
</html>