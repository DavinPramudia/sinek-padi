<x-admin.layout-admin title="Laporan Transaksi">
    <div class="flex flex-col h-full space-y-6">
        
        <!-- HEADER & FILTER -->
        <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center gap-4">
            <h1 class="text-2xl font-bold text-[#EDEDED]">Laporan Transaksi SINEK-PADI</h1>

            <form method="GET" action="{{ route('admin.laporan-transaksi') }}" class="flex flex-wrap items-center gap-2 bg-[#141c1a] border border-[#243733] p-2 rounded-xl">
                <!-- Mode Filter -->
                <select name="filter_type" class="bg-[#0B0909] text-[#EDEDED] text-xs rounded-lg px-3 py-1.5 border border-[#243733] focus:outline-none">
                    <option value="harian" {{ request('filter_type') == 'harian' ? 'selected' : '' }}>Harian</option>
                    <option value="bulanan" {{ request('filter_type') == 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                </select>

                <!-- Input Tanggal / Kalender -->
                <input type="date" name="tanggal" value="{{ request('tanggal', date('Y-m-d')) }}" class="bg-[#0B0909] text-[#EDEDED] text-xs rounded-lg px-3 py-1.5 border border-[#243733] focus:outline-none">

                <button type="submit" class="bg-[#3aafa9] text-white text-xs font-semibold px-3 py-1.5 rounded-lg transition hover:bg-[#2b8a85]">
                    Filter
                </button>
            </form>
        </div>

        <!-- SEARCH BAR & TOMBOL UNDUH -->
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <!-- Form Pencarian No Tiket -->
            <form method="GET" action="{{ route('admin.laporan-transaksi') }}" class="relative w-full sm:w-72">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-[#d1d5dc]">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" /></svg>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari No. Tiket..." class="w-full bg-[#141c1a] border border-[#243733] text-[#EDEDED] text-xs rounded-xl pl-9 pr-4 py-2 focus:outline-none">
            </form>

            <a href="#" class="bg-[#141c1a] border border-[#243733] text-[#EDEDED] hover:bg-[#243733] text-xs font-semibold px-4 py-2 rounded-xl transition flex items-center space-x-2">
                <span>Unduh Rekap</span>
            </a>
        </div>

        <!-- RINGKASAN STATISTIK ATAS -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-[#141c1a] border border-[#243733] p-5 rounded-xl flex flex-col justify-center">
                <p class="text-sm text-[#d1d5dc] font-medium">Total Transaksi Hari Ini</p>
                <h3 class="text-2xl font-bold text-white mt-1">{{ $totalTransaksi }} Unit</h3>
            </div>
            <div class="bg-[#141c1a] border border-[#243733] p-5 rounded-xl flex flex-col justify-center">
                <p class="text-sm text-[#d1d5dc] font-medium">Total Pendapatan Hari Ini</p>
                <h3 class="text-2xl font-bold text-white mt-1">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
            </div>
        </div>

        <!-- TABEL LAPORAN TRANSAKSI -->
        <div class="bg-[#141c1a] border border-[#243733] rounded-xl overflow-hidden flex-1 flex flex-col">
            <div class="overflow-x-auto flex-1">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-[#243733] text-[#EDEDED] uppercase tracking-wider">
                            <th class="p-3.5">No Tiket</th>
                            <th class="p-3.5">Waktu</th>
                            <th class="p-3.5">Kategori Kendaraan</th>
                            <th class="p-3.5">Sensus Wisatawan</th>
                            <th class="p-3.5">Total Bayar</th>
                            <th class="p-3.5">Petugas</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#243733] text-[#d1d5dc]">
                        @forelse($transaksi as $item)
                            <tr class="hover:bg-[#1c2b28] transition">
                                <td class="p-3.5 font-medium text-white">{{ $item->no_tiket }}</td>
                                <td class="p-3.5">{{ \Carbon\Carbon::parse($item->waktu)->format('H:i') }}</td>
                                <td class="p-3.5">{{ $item->kategori_kendaraan ?? 'Mobil/Motor' }}</td>
                                <td class="p-3.5">
                                    <!-- Ringkasan Sensus Wisatawan per Transaksi -->
                                    @php
                                        $sensusRangkuman = $item->detailWisatawan->map(function($det) {
                                            return $det->jumlah_wisatawan . ' ' . ($det->kategoriWisatawan->nama_kategori_wisatawan ?? 'Wisatawan');
                                        })->implode(', ');
                                    @endphp
                                    {{ $sensusRangkuman ?: '3 Lokal, 2 Domestik' }}
                                </td>
                                <td class="p-3.5 text-white font-medium">Rp {{ number_format($item->total_bayar, 0, ',', '.') }}</td>
                                <td class="p-3.5 text-white font-semibold">{{ $item->petugas->name ?? 'Ucup' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-6 text-center text-[#d1d5dc]">Belum ada data transaksi pada tanggal ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- PAGINATION -->
            <div class="p-4 border-t border-[#243733]">
                {{ $transaksi->links() }}
            </div>
        </div>

    </div>
</x-admin.layout-admin>