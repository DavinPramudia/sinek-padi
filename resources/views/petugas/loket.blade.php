<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sinek Padi - Form Petugas</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#0B0909] text-white font-sans antialiased">    
    <nav class="bg-[#0f171e] border-b-2 border-[#3a6073] py-4 px-6 flex justify-between items-center">
        <!-- Sisi Kiri: Logo & Dinas -->
        <div class="flex items-center space-x-4">
            <span class="font-bold text-xl tracking-wider text-[#3aafa9]">🌾 SINEK-PADI</span>
            <span class="hidden md:inline text-xs text-gray-400 border-l border-gray-600 pl-4">
                Dinas Pariwisata Kota Pangkal Pinang
            </span>
        </div>
        <!-- Sisi Kanan: Nama Petugas & Logout -->
        <div class="flex items-center space-x-4">
            <span class="text-sm">Halo, <strong class="text-[#3aafa9]">Andi</strong></span>
            <button class="text-gray-400 hover:text-white text-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
            </button>
        </div>
    </nav>

    <!-- KONTEN UTAMA DENGAN BACKGROUND HIJAU GELAP (#17252a) -->
    <div class="max-w-[1600px] mx-auto p-6">
        <div class="bg-[#17252a] rounded-lg p-6 shadow-2xl">
            
            <!-- GRID ATAS: MEMBAGI INPUT KIRI DAN RINGKASAN KANAN -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                
                <!-- ==================== AREA 2. INPUT TRANSAKSI (KIRI) ==================== -->
                <div class="bg-[#2b3a42] border border-[#3f5159] rounded-md p-5 flex flex-col justify-between">
                    <div>
                        <h2 class="text-sm font-bold tracking-wider text-gray-400 text-uppercase mb-4">
                            INPUT TRANSAKSI TIKET & DATA WISATAWAN
                        </h2>
                        
                        <!-- Kategori Kendaraan -->
                        <div class="mb-5">
                            <label class="block text-xs text-gray-300 font-bold mb-2">Kategori Kendaraan</label>
                            <div class="grid grid-cols-2 gap-3">
                                <!-- Tombol Motor (Status Aktif) -->
                                <div class="bg-[#3aafa9] text-[#17252a] rounded p-3 text-center cursor-pointer font-bold">
                                    <span class="block text-xl">🏍️</span>
                                    <span class="text-xs mt-1 block">Roda 2 (motor)</span>
                                </div>
                                <!-- Tombol Mobil -->
                                <div class="bg-[#3a6073] hover:bg-[#4a7287] rounded p-3 text-center cursor-pointer">
                                    <span class="block text-xl">🚗</span>
                                    <span class="text-xs mt-1 block text-gray-200">Roda 4 (Mobil)</span>
                                </div>
                            </div>
                        </div>

                        <!-- Kategori Wisatawan -->
                        <div class="mb-5">
                            <label class="block text-xs text-gray-300 font-bold mb-2">Kategori Wisatawan</label>
                            <div class="grid grid-cols-3 gap-2">
                                <!-- Lokal -->
                                <div class="bg-[#20303c] border border-[#3f5159] rounded p-2 text-center">
                                    <span class="text-[10px] text-gray-400 block">Lokal (Asal Bangka)</span>
                                    <div class="flex justify-between items-center mt-2 px-1">
                                        <button class="text-[#3aafa9] font-bold text-lg">-</button>
                                        <span class="font-bold text-base">[ 0 ]</span>
                                        <button class="text-[#3aafa9] font-bold text-lg">+</button>
                                    </div>
                                </div>
                                <!-- Non Lokal -->
                                <div class="bg-[#20303c] border border-[#3f5159] rounded p-2 text-center">
                                    <span class="text-[10px] text-gray-400 block">Non Lokal (Luar Bangka)</span>
                                    <div class="flex justify-between items-center mt-2 px-1">
                                        <button class="text-[#3aafa9] font-bold text-lg">-</button>
                                        <span class="font-bold text-base">[ 0 ]</span>
                                        <button class="text-[#3aafa9] font-bold text-lg">+</button>
                                    </div>
                                </div>
                                <!-- Mancanegara -->
                                <div class="bg-[#20303c] border border-[#3f5159] rounded p-2 text-center">
                                    <span class="text-[10px] text-gray-400 block">Mancanegara (Luar Negeri)</span>
                                    <div class="flex justify-between items-center mt-2 px-1">
                                        <button class="text-[#3aafa9] font-bold text-lg">-</button>
                                        <span class="font-bold text-base">[ 0 ]</span>
                                        <button class="text-[#3aafa9] font-bold text-lg">+</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bagian Bawah Form: Harga & Tombol Cetak -->
                    <div class="grid grid-cols-1 sm:grid-cols-5 items-center gap-4 pt-4 border-t border-gray-600 mt-6">
                        <div class="sm:col-span-2">
                            <span class="text-xs text-gray-400 block font-bold">Harga Bayar :</span>
                            <span class="text-xl font-bold text-white block mt-0.5">Rp 2.000,00</span>
                        </div>
                        <div class="sm:col-span-3">
                            <button class="w-100 bg-[#3aafa9] hover:bg-[#2c9690] text-[#17252a] font-bold py-3 px-4 rounded flex items-center justify-center gap-2 text-xs transition duration-200">
                                🖨️ PRINT TIKET & SIMPAN TRANSAKSI
                            </button>
                        </div>
                    </div>
                </div>

                <!-- ==================== AREA 3. RINGKASAN HARI INI (KANAN) ==================== -->
                <div class="bg-[#2b3a42] border border-[#3f5159] rounded-md p-5">
                    <h2 class="text-sm font-bold tracking-wider text-gray-400 text-uppercase mb-4">
                        RINGKASAN HARI INI
                    </h2>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Box 1: Pendapatan -->
                        <div class="bg-[#3a6073] rounded p-4 flex items-center space-x-3">
                            <span class="text-2xl">💵</span>
                            <div>
                                <span class="text-[11px] text-gray-200 block">Total Pendapatan Hari Ini</span>
                                <span class="font-bold text-lg">Rp 200.000,00</span>
                            </div>
                        </div>
                        <!-- Box 2: Total Mobil -->
                        <div class="bg-[#3a6073] rounded p-4 flex items-center space-x-3">
                            <span class="text-2xl">🚗</span>
                            <div>
                                <span class="text-[11px] text-gray-200 block">Total Mobil Hari Ini</span>
                                <span class="font-bold text-lg">Rp 200.000,00</span>
                            </div>
                        </div>
                        <!-- Box 3: Tiket Terjual -->
                        <div class="bg-[#3a6073] rounded p-4 flex items-center space-x-3">
                            <span class="text-2xl">🎫</span>
                            <div>
                                <span class="text-[11px] text-gray-200 block">Total Tiket Terjual Hari Ini</span>
                                <span class="font-bold text-lg">100</span>
                            </div>
                        </div>
                        <!-- Box 4: Total Motor -->
                        <div class="bg-[#3a6073] rounded p-4 flex items-center space-x-3">
                            <span class="text-2xl">🏍️</span>
                            <div>
                                <span class="text-[11px] text-gray-200 block">Total Motor Hari Ini</span>
                                <span class="font-bold text-lg">Rp 200.000,00</span>
                            </div>
                        </div>
                        <!-- Box 5: Total Wisatawan (Memanjang penuh) -->
                        <div class="bg-[#3a6073] rounded p-4 flex items-center space-x-3 sm:col-span-2">
                            <span class="text-2xl">👥</span>
                            <div>
                                <span class="text-[11px] text-gray-200 block">Total Wisatawan Hari Ini</span>
                                <span class="font-bold text-lg">100</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- ==================== AREA 4. TABEL RIWAYAT (BAWAH) ==================== -->
            <div class="bg-[#2b3a42] border border-[#3f5159] rounded-md p-5">
                <h2 class="text-sm font-bold tracking-wider text-gray-400 text-uppercase mb-3">
                    RIWAYAT TERAKHIR
                </h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-[#3f5159] text-xs text-gray-400 uppercase">
                                <th class="pb-3">No Karcis</th>
                                <th class="pb-3">Waktu</th>
                                <th class="pb-3">Jenis Kendaraan</th>
                                <th class="pb-3">Sensus (Lokal, NonLokal, Mancanegara)</th>
                                <th class="pb-3">Biaya</th>
                                <th class="pb-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-xs divide-y divide-[#3f5159]/30">
                            <!-- Baris Data 1 -->
                            <tr class="hover:bg-[#20303c]/50">
                                <td class="py-3 font-mono">KRC260712-0001</td>
                                <td class="py-3 text-gray-300">26/07/2026, 15:30 WIB</td>
                                <td class="py-3 text-gray-300">Motor</td>
                                <td class="py-3 text-gray-300">1 / 2 / 0</td>
                                <td class="py-3 font-bold text-[#3aafa9]">Rp 2.000</td>
                                <td class="py-3 text-center">
                                    <button class="border border-[#3aafa9] text-[#3aafa9] hover:bg-[#3aafa9] hover:text-[#17252a] text-[10px] font-bold py-1 px-3 rounded-full transition duration-150">
                                        🖨️ Print Ulang
                                    </button>
                                </td>
                            </tr>
                            <!-- Baris Data 2 -->
                            <tr class="hover:bg-[#20303c]/50">
                                <td class="py-3 font-mono">KRC260712-0001</td>
                                <td class="py-3 text-gray-300">26/07/2026, 15:30 WIB</td>
                                <td class="py-3 text-gray-300">Motor</td>
                                <td class="py-3 text-gray-300">1 / 2 / 0</td>
                                <td class="py-3 font-bold text-[#3aafa9]">Rp 2.000</td>
                                <td class="py-3 text-center">
                                    <button class="border border-[#3aafa9] text-[#3aafa9] hover:bg-[#3aafa9] hover:text-[#17252a] text-[10px] font-bold py-1 px-3 rounded-full transition duration-150">
                                        🖨️ Print Ulang
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

</body>
</html>