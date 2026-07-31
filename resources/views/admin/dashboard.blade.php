<x-admin.layout-admin title="Dashboard">
    <div class="flex flex-col h-full space-y-6">
        
        <!-- HEADER DASHBOARD -->
        <div class="flex flex-col md:flex-row md:justify-between md:items-end gap-4">
            <div>
                <h1 class="text-2xl font-bold text-[#EDEDED] mb-1">Dashboard Admin SINEK-PADI</h1>
                <p class="text-sm text-[#d1d5dc]">Sistem Informasi Retribusi & Sensus Wisatawan Pasir Padi</p>
            </div>
        </div>

        <!-- MAIN GRID CONTENT -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 flex-1">
            
            <!-- KIRI: 3 Kolom -->
            <div class="col-span-1 lg:col-span-3 flex flex-col space-y-6">
                
                <!-- Statistik Atas -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-[#141c1a] border border-[#243733] p-5 rounded-xl flex flex-col justify-center">
                        <p class="text-sm text-[#d1d5dc] font-medium">Total Pendapatan Harian</p>
                        <h3 class="text-2xl font-bold text-white mt-1">Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}</h3>
                    </div>
                    <div class="bg-[#141c1a] border border-[#243733] p-5 rounded-xl flex flex-col justify-center">
                        <p class="text-sm text-[#d1d5dc] font-medium">Total Kendaraan Harian</p>
                        <h3 class="text-2xl font-bold text-white mt-1">{{ $totalKendaraan ?? 0 }} Unit</h3>
                    </div>
                    <div class="bg-[#141c1a] border border-[#243733] p-5 rounded-xl flex flex-col justify-center">
                        <p class="text-sm text-[#d1d5dc] font-medium">Total Wisatawan Harian</p>
                        <h3 class="text-2xl font-bold text-white mt-1">{{ $totalWisatawan ?? 0 }} Orang</h3>
                    </div>
                </div>

                <!-- Line Chart Box (Statis) -->
                <div class="bg-[#141c1a] border border-[#243733] p-6 rounded-xl flex-1 flex flex-col min-h-[320px]">
                    <h2 class="text-[#EDEDED] font-semibold text-lg mb-6">Tren Kunjungan Harian Perjam</h2>
                    <div class="flex-1 relative flex flex-col justify-between py-2 border-b border-l border-[#243733] ml-6 mb-6">
                        <div class="w-full border-t border-[#243733] absolute top-[50%] left-0"></div>
                        <div class="absolute -bottom-6 w-full flex justify-between text-[10px] text-[#d1d5dc] px-1">
                            <span>06:00</span><span>12:00</span><span>18:00</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- KANAN: 1 Kolom -->
            <div class="col-span-1 flex flex-col space-y-6">
                
                <!-- 1. Chart Sensus Wisatawan (Yang sudah ada) -->
                <div class="bg-[#141c1a] border border-[#243733] p-6 rounded-xl flex-1 flex flex-col min-h-[250px] donut-wisatawan-container"
                    data-lokal="{{ $wisatawanLokal ?? 0 }}"
                    data-nusantara="{{ $wisatawanNusantara ?? 0 }}"
                    data-mancanegara="{{ $wisatawanMancanegara ?? 0 }}">

                    <h2 class="text-[#EDEDED] font-semibold text-sm leading-tight mb-4">Sensus Wisatawan Harian</h2>
                    
                    <div class="flex-1 flex flex-col items-center justify-center relative">
                        <div class="w-32 h-32 relative">
                            <canvas id="donutWisatawanChart"></canvas>
                        </div>
                        <div class="flex space-x-3 text-[10px] text-[#d1d5dc] mt-3">
                            <span class="flex items-center"><span class="w-2 h-2 rounded-full bg-[#3aafa9] mr-1"></span>Lokal ({{ $wisatawanLokal }})</span>
                            <span class="flex items-center"><span class="w-2 h-2 rounded-full bg-[#E17055] mr-1"></span>Nusantara ({{ $wisatawanNusantara }})</span>
                            <span class="flex items-center"><span class="w-2 h-2 rounded-full bg-[#EDEDED] mr-1"></span>Manca ({{ $wisatawanMancanegara }})</span>
                        </div>
                    </div>
                </div>

                <!-- 2. Chart Tambahan di Bawahnya (Contoh: Kendaraan Harian) -->
                <div class="bg-[#141c1a] border border-[#243733] p-6 rounded-xl flex-1 flex flex-col min-h-[250px] donut-kategori-kendaraan-container"
                    data-motor="{{ $kendaraanMotor ?? 0 }}"
                    data-mobil="{{ $kendaraanMobil ?? 0 }}">

                    <h2 class="text-[#EDEDED] font-semibold text-sm leading-tight mb-4">Kendaraan Harian Perkategori</h2>
                    
                    <div class="flex-1 flex flex-col items-center justify-center relative">
                        <div class="w-32 h-32 relative">
                            <canvas id="donutKategoriKendaraan"></canvas>
                        </div>
                        <div class="flex space-x-3 text-[10px] text-[#d1d5dc] mt-3">
                            <span class="flex items-center"><span class="w-2 h-2 rounded-full bg-[#3aafa9] mr-1"></span>Motor ({{ $kendaraanMotor ?? 0 }})</span>
                            <span class="flex items-center"><span class="w-2 h-2 rounded-full bg-[#EDEDED] mr-1"></span>Mobil ({{ $kendaraanMobil ?? 0 }})</span>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-admin.layout-admin>