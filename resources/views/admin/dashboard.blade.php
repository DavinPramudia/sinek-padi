<x-admin.layout-admin title="Dashboard">
    <div class="flex flex-col h-full space-y-6">
        
        <!-- HEADER DASHBOARD -->
        <div class="flex flex-col lg:flex-row lg:justify-between lg:items-end gap-4">
            <div>
                <h1 class="text-2xl font-bold text-[#EDEDED] mb-1">Panel Kontrol Admin SINEK-PADI</h1>
                <p class="text-sm text-[#d1d5dc]">Sistem Informasi Retribusi & Sensus Wisatawan Pasir Padi</p>
            </div>

            <!-- MEMANGGIL KOMPONEN FILTER -->
            <x-admin.filter-header :routeAction="route('admin.dashboard')" />
        </div>

        <!-- MAIN GRID CONTENT -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 flex-1">
            
            <!-- KIRI: 3 Kolom -->
            <div class="col-span-1 lg:col-span-3 flex flex-col space-y-6">
                
                <!-- Statistik Atas -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-[#141c1a] border border-[#243733] p-5 rounded-xl flex flex-col justify-center">
                        <p class="text-sm text-[#d1d5dc] font-medium">Total Pendapatan {{ $labelPeriode }}</p>
                        <h3 class="text-2xl font-bold text-white mt-1">Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}</h3>
                    </div>
                    <div class="bg-[#141c1a] border border-[#243733] p-5 rounded-xl flex flex-col justify-center">
                        <p class="text-sm text-[#d1d5dc] font-medium">Total Kendaraan {{ $labelPeriode }}</p>
                        <h3 class="text-2xl font-bold text-white mt-1">{{ $totalKendaraan ?? 0 }} Unit</h3>
                    </div>
                    <div class="bg-[#141c1a] border border-[#243733] p-5 rounded-xl flex flex-col justify-center">
                        <p class="text-sm text-[#d1d5dc] font-medium">Total Wisatawan {{ $labelPeriode }}</p>
                        <h3 class="text-2xl font-bold text-white mt-1">{{ $totalWisatawan ?? 0 }} Orang</h3>
                    </div>
                </div>

                <!-- Line Chart Box -->
                <div class="bg-[#141c1a] border border-[#243733] p-6 rounded-xl flex-1 flex flex-col min-h-[320] line-chart-container"
                    data-tren="{{ json_encode($trenKunjungan ?? []) }}"
                    data-labels="{{ json_encode($labelsGrafik ?? []) }}"
                    data-max="{{ $chartConfig['max'] }}"
                    data-step="{{ $chartConfig['step'] }}">
                    
                    <h2 class="text-[#EDEDED] font-semibold text-lg mb-6">
                        Tren Kunjungan {{ $labelPeriode }} {{ $satuanWaktu }}
                    </h2>
                    
                    <div class="flex-1 relative w-full h-[240]">
                        <canvas id="trenChart"></canvas>
                    </div>
                </div>

            </div>

            <!-- KANAN: 1 Kolom -->
            <div class="col-span-1 flex flex-col space-y-6">
                
                <!-- 1. Chart Sensus Wisatawan -->
                <div class="bg-[#141c1a] border border-[#243733] p-6 rounded-xl flex-1 flex flex-col min-h-[250] donut-wisatawan-container"
                    data-lokal="{{ $wisatawanLokal ?? 0 }}"
                    data-nusantara="{{ $wisatawanNusantara ?? 0 }}"
                    data-mancanegara="{{ $wisatawanMancanegara ?? 0 }}">

                    <h2 class="text-[#EDEDED] font-semibold text-sm leading-tight mb-4">Sensus Wisatawan {{ $labelPeriode }}</h2>
                    
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

                <!-- 2. Chart Kendaraan -->
                <div class="bg-[#141c1a] border border-[#243733] p-6 rounded-xl flex-1 flex flex-col min-h-[250] donut-kategori-kendaraan-container"
                    data-motor="{{ $kendaraanMotor ?? 0 }}"
                    data-mobil="{{ $kendaraanMobil ?? 0 }}">

                    <h2 class="text-[#EDEDED] font-semibold text-sm leading-tight mb-4">Kendaraan {{ $labelPeriode }} Perkategori</h2>
                    
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