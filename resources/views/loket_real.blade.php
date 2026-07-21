<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sinek Padi - Form Petugas</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#0B0909]">

    <nav class="bg-[#0B0909] border-b border-[#EDEDED] py-4 px-6 flex justify-between items-center">
        {{-- Kiri --}}
        <div class="flex items-center space-x-0">
            <span class="font-bold text-xl text-[#EDEDED]">Sinek Padi</span>
            <span class="text-sm text-[#EDEDED] pl-4">Dinas Pariwisata Kota Pangkal Pinang</span>
        </div>

        {{-- Kanan --}}
        <div class="flex items-center space-x-4">
            <span class="text-sm text-[#EDEDED]">Halo, <strong class="text-[#3aafa9]">Andi</strong></span>
            <button class="w-8 h-8 flex items-center justify-center bg-transparent text-gray-400 hover:text-red-500 transition duration-150" title="Logout">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
            </button>
        </div>
    </nav>

    {{-- body --}}
    <div class="max-w-7xl mx-auto px-4 py-5">

        {{-- Pembagi Kolom --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">   

            {{-- Kontainer Kiri --}}
            <div class="bg-[#2E4540] rounded-3xl p-5 shadow-lg">
                
                {{-- Bagian Kategori Kendaraan  --}}
                <div class="mb-6">
                    <label class="block text-xl font-semibold text-[#EDEDED] mb-3">
                        Kategori Kendaraan
                    </label>
                    
                    {{-- Dibagi 2 --}}
                    <div class="grid grid-cols-2 gap-4">
                        {{-- Tombol Motor --}}
                        <button type="button"
                                id="btn-motor"
                                onclick="pilihKategori('motor')"
                                class="bg-[#408175] hover:bg-[#3aafa9] text-[#EDEDED] rounded-xl p-4 flex flex-col items-center justify-center text-center w-full transition duration-150 shadow-md">
                            <img src="{{ asset('assets/icons/motorcycle.png') }}" class="w-12 h-12 object-contain mb-2" alt="Motor">
                            <span class="text-xs font-medium">Roda 2 (Motor)</span>
                        </button>

                        {{-- Tombol Mobil --}}
                        <button type="button"   
                                id="btn-mobil"
                                onclick="pilihKategori('mobil')"
                                class="bg-[#408175] hover:bg-[#3aafa9] text-[#EDEDED] rounded-xl p-4 flex flex-col items-center justify-center text-center w-full transition duration-150 shadow-md">
                            <img src="{{ asset('assets/icons/car.png') }}" class="w-12 h-12 object-contain mb-2" alt="Mobil">
                            <span class="text-xs font-medium">Roda 4 (Mobil)</span>
                        </button>
                    </div>
                </div>

                {{-- Bagian Kategori Wisatawan  --}}
                <div>
                    <label class="block text-xl font-semibold text-[#EDEDED] mb-3">
                        Kategori Wisatawan
                    </label>
                
                    {{-- Dibagi 3 Kartu --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        
                        {{-- 1. Lokal Bangka --}}
                        <div class="bg-[#243733] border border-[#3b5952] p-3 rounded-xl flex flex-col justify-between">
                            <div class="mb-1">
                                <span class="block text-xs font-semibold text-[#EDEDED] text-center">Lokal Bangka</span>
                            </div>
                            <div class="flex items-center justify-between bg-[#1c2b28] rounded-lg p-1">
                                <button type="button" class="w-7 h-7 rounded bg-[#2a3d38] text-white flex items-center justify-center font-bold text-sm hover:bg-[#3b544e] transition">-</button>
                                <input type="number" value="0" min="0" readonly class="w-8 bg-transparent text-white text-center font-bold text-xs focus:outline-none">
                                <button type="button" class="w-7 h-7 rounded bg-[#408175] text-white flex items-center justify-center font-bold text-sm hover:bg-[#4ea091] transition">+</button>
                            </div>
                        </div>

                        {{-- 2. Wisatawan Nusantara --}}
                        <div class="bg-[#243733] border border-[#3b5952] p-3 rounded-xl flex flex-col justify-between">
                            <div class="mb-1">
                                <span class="block text-xs font-semibold text-[#EDEDED] text-center">Nusantara</span>
                            </div>
                            <div class="flex items-center justify-between bg-[#1c2b28] rounded-lg p-1">
                                <button type="button" class="w-7 h-7 rounded bg-[#2a3d38] text-white flex items-center justify-center font-bold text-sm hover:bg-[#3b544e] transition">-</button>
                                <input type="number" value="0" min="0" readonly class="w-8 bg-transparent text-white text-center font-bold text-xs focus:outline-none">
                                <button type="button" class="w-7 h-7 rounded bg-[#408175] text-white flex items-center justify-center font-bold text-sm hover:bg-[#4ea091] transition">+</button>
                            </div>
                        </div>

                        {{-- 3. Wisatawan Asing --}}
                        <div class="bg-[#243733] border border-[#3b5952] p-3 rounded-xl flex flex-col justify-between">
                            <div class="mb-1">
                                <span class="block text-xs font-semibold text-[#EDEDED] text-center">Mancanegara</span>
                            </div>
                            <div class="flex items-center justify-between bg-[#1c2b28] rounded-lg p-1">
                                <button type="button" class="w-7 h-7 rounded bg-[#2a3d38] text-white flex items-center justify-center font-bold text-sm hover:bg-[#3b544e] transition">-</button>
                                <input type="number" value="0" min="0" readonly class="w-8 bg-transparent text-white text-center font-bold text-xs focus:outline-none">
                                <button type="button" class="w-7 h-7 rounded bg-[#408175] text-white flex items-center justify-center font-bold text-sm hover:bg-[#4ea091] transition">+</button>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            {{-- Kontainer Kanan (Untuk Rincian / Total Harga Nanti) --}}
            <div>
                <!-- Area ini siap diisi rincian pembayaran -->
            </div>

        </div> 
    </div>
</body>
</html>