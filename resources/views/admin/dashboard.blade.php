<x-admin.layout-admin title="Dashboard">
    <div class="flex flex-col h-full space-y-6">
        
        <!-- HEADER DASHBOARD -->
        <div class="flex flex-col lg:flex-row lg:justify-between lg:items-end gap-4">
            <div>
                <h1 class="text-2xl font-bold text-[#EDEDED] mb-1">Panel Kontrol Admin SINEK-PADI</h1>
                <p class="text-sm text-[#d1d5dc]">Sistem Informasi Retribusi & Sensus Wisatawan Pasir Padi</p>
            </div>

            <!-- FORM FILTER DI SEBELAH KANAN HEADER -->
            <form method="GET" action="{{ route('admin.dashboard') }}" class="flex flex-wrap items-center gap-2 bg-[#141c1a] border border-[#243733] p-2 rounded-xl">
                
                <!-- Pilihan Mode Filter -->
                <div class="flex items-center space-x-1 bg-[#0B0909] border border-[#243733] rounded-lg px-3 py-1.5">
                    <span class="text-xs text-[#d1d5dc]">Mode:</span>
                    <select name="filter_type" id="filterType" onchange="changeFilterInput()" class="bg-transparent text-[#EDEDED] text-xs font-semibold focus:outline-none cursor-pointer">
                        <option value="harian" {{ (request('filter_type', 'harian') == 'harian') ? 'selected' : '' }} class="bg-[#0B0909]">Harian</option>
                        <option value="bulanan" {{ (request('filter_type') == 'bulanan') ? 'selected' : '' }} class="bg-[#0B0909]">Bulanan</option>
                        <option value="tahunan" {{ (request('filter_type') == 'tahunan') ? 'selected' : '' }} class="bg-[#0B0909]">Tahunan</option>
                        <option value="triwulanan" {{ (request('filter_type') == 'triwulanan') ? 'selected' : '' }} class="bg-[#0B0909]">Triwulanan</option>
                    </select>
                </div>

                <!-- 1. Input Harian -->
                <div id="wrapperHarian" class="filter-input-wrapper relative flex items-center">
                    <span onclick="document.getElementById('inputHarian').showPicker()" class="absolute left-2.5 text-[#d1d5dc] cursor-pointer flex items-center hover:text-white transition">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" /></svg>
                    </span>
                    <input type="date" id="inputHarian" name="tanggal" value="{{ request('tanggal', date('Y-m-d')) }}" class="bg-[#0B0909] border border-[#243733] text-[#EDEDED] text-xs rounded-lg pl-8 pr-2.5 py-1.5 focus:outline-none w-36">
                </div>

                <!-- 2. Input Bulanan -->
                <div id="wrapperBulanan" class="filter-input-wrapper relative flex items-center hidden">
                    <span onclick="document.getElementById('inputBulanan').showPicker()" class="absolute left-2.5 text-[#d1d5dc] cursor-pointer flex items-center hover:text-white transition">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" /></svg>
                    </span>
                    <input type="month" id="inputBulanan" name="bulan" value="{{ request('bulan', date('Y-m')) }}" class="bg-[#0B0909] border border-[#243733] text-[#EDEDED] text-xs rounded-lg pl-8 pr-2.5 py-1.5 focus:outline-none w-36">
                </div>

                <!-- 3. Input Tahunan -->
                <div id="wrapperTahunan" class="filter-input-wrapper relative flex items-center hidden">
                    <span class="absolute left-2.5 text-[#d1d5dc] pointer-events-none flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" /></svg>
                    </span>
                    <input type="text" name="tahun" maxlength="4" placeholder="YYYY" value="{{ request('tahun', date('Y')) }}" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="bg-[#0B0909] border border-[#243733] text-[#EDEDED] text-xs rounded-lg pl-8 pr-2.5 py-1.5 focus:outline-none w-36">
                </div>

                <!-- 4. Input Triwulanan -->
                <div id="wrapperTriwulanan" class="filter-input-wrapper relative flex items-center hidden gap-1">
                    <!-- Pilih Tribulan -->
                    <div class="relative flex items-center">
                        <span class="absolute left-2.5 text-[#d1d5dc] flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" /></svg>
                        </span>
                        <select name="triwulan" class="bg-[#0B0909] border border-[#243733] text-[#EDEDED] text-xs rounded-lg pl-8 pr-2.5 py-1.5 focus:outline-none cursor-pointer appearance-none">
                            <option value="1" {{ request('triwulan') == '1' ? 'selected' : '' }} class="bg-[#0B0909]">Tribulan 1</option>
                            <option value="2" {{ request('triwulan') == '2' ? 'selected' : '' }} class="bg-[#0B0909]">Tribulan 2</option>
                            <option value="3" {{ request('triwulan') == '3' ? 'selected' : '' }} class="bg-[#0B0909]">Tribulan 3</option>
                            <option value="4" {{ request('triwulan') == '4' ? 'selected' : '' }} class="bg-[#0B0909]">Tribulan 4</option>
                        </select>
                    </div>
                    <!-- Pilih Tahun Triwulanan dengan Ikon Kalender -->
                    <div class="relative flex items-center">
                        <span class="absolute left-2.5 text-[#d1d5dc] flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" /></svg>
                        </span>
                        <select name="tahun_triwulan" class="bg-[#0B0909] border border-[#243733] text-[#EDEDED] text-xs rounded-lg pl-8 pr-2.5 py-1.5 focus:outline-none cursor-pointer">
                            @for($y = date('Y'); $y >= 2024; $y--)
                                <option value="{{ $y }}" {{ request('tahun_triwulan', date('Y')) == $y ? 'selected' : '' }} class="bg-[#0B0909]">{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <!-- Tombol Submit -->
                <button type="submit" class="bg-[#3aafa9] hover:bg-[#2b8a85] text-white text-xs font-semibold px-3 py-1.5 rounded-lg transition">
                    Filter
                </button>
            </form>
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