<x-admin.layout-admin title="Dashboard">
    <div class="flex flex-col h-full space-y-6">
        
        <!-- BAGIAN HEADER DASHBOARD & FILTER -->
        <div class="flex flex-col md:flex-row md:justify-between md:items-end gap-4">
            <div>
                <h1 class="text-2xl font-bold text-[#EDEDED] mb-1">Dashboard Admin SINEK-PADI</h1>
                <p class="text-sm text-[#d1d5dc]">Sistem Informasi Retribusi & Sensus Wisatawan Pasir Padi</p>
            </div>
            
            <!-- Tombol Filter & Export -->
            <div class="flex flex-wrap items-center gap-3 text-sm">
                <button class="bg-[#141c1a] border border-[#243733] text-[#d1d5dc] px-4 py-2 rounded-lg hover:bg-[#2E4540] transition cursor-pointer">
                    Mode: Harian ▾
                </button>
                <button class="bg-[#141c1a] border border-[#243733] text-[#d1d5dc] px-4 py-2 rounded-lg hover:bg-[#2E4540] transition flex items-center space-x-2 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>05/07/2026 ▾</span>
                </button>
                <button class="bg-[#C4C4FA] text-[#0B0909] font-semibold px-4 py-2 rounded-lg hover:bg-[#aeb1f0] transition flex items-center space-x-2 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    <span>Unduh Rekap</span>
                </button>
            </div>
        </div>

        <!-- MAIN GRID CONTENT (3 KIRI, 1 KANAN) -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 flex-1">
            
            <!-- KIRI: 3 Kolom -->
            <div class="col-span-1 lg:col-span-3 flex flex-col space-y-6">
                
                <!-- 3 Kartu Statistik Atas -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Card 1 -->
                    <div class="bg-[#141c1a] border border-[#243733] p-5 rounded-xl flex flex-col justify-center">
                        <div class="w-10 h-10 rounded-full bg-[#3aafa9]/20 text-[#3aafa9] flex items-center justify-center mb-4">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <p class="text-sm text-[#d1d5dc] font-medium">Total Pendapatan Harian</p>
                        <h3 class="text-2xl font-bold text-white mt-1">Rp 200.000,00</h3>
                    </div>

                    <!-- Card 2 -->
                    <div class="bg-[#141c1a] border border-[#243733] p-5 rounded-xl flex flex-col justify-center">
                        <div class="w-10 h-10 rounded-full bg-[#3aafa9]/20 text-[#3aafa9] flex items-center justify-center mb-4">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                        </div>
                        <p class="text-sm text-[#d1d5dc] font-medium">Total Kendaraan Harian</p>
                        <h3 class="text-2xl font-bold text-white mt-1">200 Unit</h3>
                    </div>

                    <!-- Card 3 -->
                    <div class="bg-[#141c1a] border border-[#243733] p-5 rounded-xl flex flex-col justify-center">
                        <div class="w-10 h-10 rounded-full bg-[#3aafa9]/20 text-[#3aafa9] flex items-center justify-center mb-4">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        </div>
                        <p class="text-sm text-[#d1d5dc] font-medium">Total Wisatawan Harian</p>
                        <h3 class="text-2xl font-bold text-white mt-1">200 Orang</h3>
                    </div>
                </div>

                <!-- Line Chart Box -->
                <div class="bg-[#141c1a] border border-[#243733] p-6 rounded-xl flex-1 flex flex-col min-h-[320px]">
                    <div class="flex items-center space-x-3 mb-6">
                        <div class="w-8 h-8 rounded-lg bg-[#3aafa9]/20 text-[#3aafa9] flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/></svg>
                        </div>
                        <h2 class="text-[#EDEDED] font-semibold text-lg">Tren Kunjungan Harian Perjam</h2>
                    </div>
                    
                    <!-- Simulasi Garis Sesuai Gambar -->
                    <div class="flex-1 relative flex flex-col justify-between py-2 border-b border-l border-[#243733] ml-6 mb-6">
                        <!-- Garis Horizontal Grid -->
                        <div class="w-full border-t border-[#243733] absolute top-[25%] left-0"></div>
                        <div class="w-full border-t border-[#243733] absolute top-[50%] left-0"></div>
                        <div class="w-full border-t border-[#243733] absolute top-[75%] left-0"></div>

                        <!-- Label Sumbu Y -->
                        <div class="absolute -left-7 top-0 text-[10px] text-[#d1d5dc]">100-</div>
                        <div class="absolute -left-6 top-[25%] text-[10px] text-[#d1d5dc]">75-</div>
                        <div class="absolute -left-6 top-[50%] text-[10px] text-[#d1d5dc]">50-</div>
                        <div class="absolute -left-6 top-[75%] text-[10px] text-[#d1d5dc]">25-</div>
                        <div class="absolute -left-5 bottom-0 text-[10px] text-[#d1d5dc]">0--</div>

                        <!-- Sumbu X Label Jam -->
                        <div class="absolute -bottom-6 w-full flex justify-between text-[10px] text-[#d1d5dc] px-1">
                            <span>06:00</span>
                            <span>07:00</span>
                            <span>08:00</span>
                            <span>09:00</span>
                            <span>10:00</span>
                            <span>11:00</span>
                            <span>12:00</span>
                            <span>13:00</span>
                            <span>14:00</span>
                            <span>15:00</span>
                            <span>16:00</span>
                            <span>17:00</span>
                            <span>18:00</span>
                        </div>
                    </div>
                </div>

            </div>

            <!-- KANAN: 1 Kolom -->
            <div class="col-span-1 flex flex-col space-y-6">
                
                <!-- Donut Chart 1 -->
                <div class="bg-[#141c1a] border border-[#243733] p-6 rounded-xl flex-1 flex flex-col min-h-[250px]">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-8 h-8 rounded-lg bg-[#3aafa9]/20 text-[#3aafa9] flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </div>
                        <h2 class="text-[#EDEDED] font-semibold text-sm leading-tight">Sensus Wisatawan Harian</h2>
                    </div>
                    
                    <div class="flex-1 flex flex-col items-center justify-center">
                         <div class="w-28 h-28 rounded-full border-[18px] border-[#3aafa9] mb-4 flex items-center justify-center"></div>
                         <div class="flex space-x-3 text-[10px] text-[#d1d5dc]">
                             <span class="flex items-center"><span class="w-2 h-2 rounded-full bg-[#3aafa9] mr-1"></span>Lokal</span>
                             <span class="flex items-center"><span class="w-2 h-2 rounded-full bg-white mr-1"></span>Mancanegara</span>
                         </div>
                    </div>
                </div>

                <!-- Donut Chart 2 -->
                <div class="bg-[#141c1a] border border-[#243733] p-6 rounded-xl flex-1 flex flex-col min-h-[250px]">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-8 h-8 rounded-lg bg-[#3aafa9]/20 text-[#3aafa9] flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                        </div>
                        <h2 class="text-[#EDEDED] font-semibold text-sm leading-tight">Kendaraan Harian Perkategori</h2>
                    </div>

                    <div class="flex-1 flex flex-col items-center justify-center">
                         <div class="w-28 h-28 rounded-full border-[18px] border-[#d1d5dc] mb-4 flex items-center justify-center"></div>
                         <div class="flex space-x-3 text-[10px] text-[#d1d5dc]">
                             <span class="flex items-center"><span class="w-2 h-2 rounded-full bg-[#3aafa9] mr-1"></span>Roda 2</span>
                             <span class="flex items-center"><span class="w-2 h-2 rounded-full bg-white mr-1"></span>Roda 4</span>
                         </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-admin.layout-admin>