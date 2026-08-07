<x-admin.layout-admin title="Laporan Transaksi">
    <div class="flex flex-col h-full space-y-6">
        
        <!-- HEADER & FILTER -->
        <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-[#EDEDED]">Laporan Transaksi SINEK-PADI</h1>
                <!-- MENAMPILKAN PERIODE AKTIF -->
                <p class="text-sm text-[#d1d5dc] mt-1">Menampilkan data untuk periode: <span class="text-[#3aafa9] font-semibold">{{ $labelPeriode ?? 'Hari Ini' }}</span></p>
            </div>

            <!-- MEMANGGIL KOMPONEN FILTER -->
            <x-admin.filter-header :routeAction="route('admin.laporan-transaksi')" />
        </div>

        <!-- SEARCH BAR & TOMBOL UNDUH -->
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <form method="GET" action="{{ route('admin.laporan-transaksi') }}" class="relative w-full sm:w-72">
                <!-- Membawa parameter filter agar saat pencarian filter tidak reset -->
                <input type="hidden" name="filter_type" value="{{ request('filter_type', 'harian') }}">
                <input type="hidden" name="tanggal" value="{{ request('tanggal') }}">
                <input type="hidden" name="bulan" value="{{ request('bulan') }}">
                <input type="hidden" name="tahun" value="{{ request('tahun') }}">
                <input type="hidden" name="triwulan" value="{{ request('triwulan') }}">
                <input type="hidden" name="tahun_triwulan" value="{{ request('tahun_triwulan') }}">

                <!-- Ikon Search di Kanan -->
                <span class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-[#d1d5dc]">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" /></svg>
                </span>

                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari No. Tiket..." class="w-full bg-[#141c1a] border border-[#243733] text-[#EDEDED] text-xs rounded-xl pl-4 pr-9 py-2 focus:outline-none">
            </form>

            <a href="#" class="bg-[#141c1a] border border-[#243733] text-[#EDEDED] hover:bg-[#243733] text-xs font-semibold px-4 py-2 rounded-xl transition flex items-center space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#3aafa9" class="size-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                </svg>
                <span>Unduh Rekap</span>
            </a>
        </div>

        <!-- RINGKASAN STATISTIK ATAS -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-[#141c1a] border border-[#243733] p-5 rounded-xl flex flex-col justify-center">
                <p class="text-sm text-[#d1d5dc] font-medium">Total Transaksi ({{ $labelPeriode ?? 'Periode Ini' }})</p>
                <h3 class="text-2xl font-bold text-white mt-1">{{ $totalTransaksi }} Unit</h3>
            </div>
            <div class="bg-[#141c1a] border border-[#243733] p-5 rounded-xl flex flex-col justify-center">
                <p class="text-sm text-[#d1d5dc] font-medium">Total Pendapatan ({{ $labelPeriode ?? 'Periode Ini' }})</p>
                <h3 class="text-2xl font-bold text-white mt-1">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
            </div>
        </div>

        <!-- TABEL LAPORAN TRANSAKSI (Dengan Scroll Boks Internal) -->
        <div class="bg-[#141c1a] border border-[#243733] rounded-xl overflow-hidden shadow-lg flex flex-col flex-1 min-h-0">
            <div class="overflow-y-auto overflow-x-auto flex-1">
                <table class="w-full text-left border-collapse text-xs">
                    <thead class="sticky top-0 bg-[#243733] z-10">
                        <tr class="text-[#EDEDED] uppercase tracking-wider">
                            <th class="p-3.5">No Tiket</th>
                            <th class="p-3.5">Waktu</th>
                            <th class="p-3.5">Kategori Kendaraan</th>
                            <th class="p-3.5 text-center">( L / N / M )</th>
                            <th class="p-3.5">Total Bayar</th>
                            <th class="p-3.5">Petugas</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#243733] text-[#d1d5dc]">
                        @forelse($transaksi as $item)
                            <tr class="hover:bg-[#1c2b28] transition">
                                <td class="p-3.5 font-medium text-white">{{ $item->no_karcis ?? $item->no_tiket }}</td>
                                <td class="p-3.5">{{ \Carbon\Carbon::parse($item->waktu)->format('H:i') }}</td>
                                <td class="p-3.5">{{ $item->kategori_kendaraan ?? 'Mobil/Motor' }}</td>
                                
                                <!-- Kolom Sensus di Tengah dengan Format L / N / M -->
                                <td class="p-3.5 text-center font-medium tracking-wider">
                                    {{ $item->sensus_rangkuman }}
                                </td>

                                <td class="p-3.5 text-white font-medium">Rp {{ number_format($item->total_bayar, 0, ',', '.') }}</td>
                                <td class="p-3.5 text-white font-semibold">{{ optional($item->user)->name ?? 'Ucup' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-6 text-center text-[#d1d5dc]">Belum ada data transaksi pada periode ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-admin.layout-admin>