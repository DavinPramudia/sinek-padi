@props(['riwayatTransaksi'])

<div class="bg-[#2E4540] rounded-3xl p-5 shadow-lg border border-[#3b5952] space-y-4">
    
    {{-- Header Tabel Riwayat --}} 
    <div class="flex justify-between items-center pb-3 border-b border-[#3b5952]">
        <h2 class="text-lg font-semibold text-[#EDEDED]">
            Riwayat Transaksi Terakhir
        </h2>
        <span class="text-[11px] text-[#d1d5dc]">Menampilkan transaksi terbaru hari ini</span>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-[#3b5952] text-[11px] text-[#d1d5dc] uppercase tracking-wider">
                    <th class="pb-3 pl-2">No Karcis</th>
                    <th class="pb-3">Waktu</th>
                    <th class="pb-3">Kendaraan</th>
                    <th class="pb-3 text-center">(L / N / M)</th>
                    <th class="pb-3">Biaya</th>
                    <th class="pb-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-xs divide-y divide-[#3b5952]/40">
                
                {{-- Cek apakah ada data transaksi --}}
                @forelse ($riwayatTransaksi as $transaksi)
                    <tr class="hover:bg-[#1c2b28]/60 transition duration-150">
                        <td class="py-3.5 pl-2 font-mono text-[#EDEDED] font-semibold">{{ $transaksi->no_karcis }}</td>
                        <td class="py-3.5 text-[#d1d5dc]">{{ \Carbon\Carbon::parse($transaksi->waktu)->format('d/m/Y, H:i') }} WIB</td>
                        <td class="py-3.5">
                            <span class="bg-[#243733] text-[#d1d5dc] px-2.5 py-1 rounded-md text-[11px] border border-[#3b5952]">
                                {{ $transaksi->nama_kendaraan }}
                            </span>
                        </td>
                        <td class="py-3.5 text-center">
                            <span class="bg-[#1c2b28] text-[#3aafa9] font-mono px-2.5 py-1 rounded border border-[#3b5952] text-[11px]">
                                {{ $transaksi->sensus_l }} / {{ $transaksi->sensus_n }} / {{ $transaksi->sensus_m }}
                            </span>
                        </td>
                        <td class="py-3.5 font-bold text-[#3aafa9] text-sm">Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</td>
                        <td class="py-3.5 text-center">
                            {{-- Tombol print ulang langsung membuka route cetak berdasarkan ID --}}
                            <a href="{{ route('transaksi.cetak', $transaksi->id_transaksi) }}" target="_blank" 
                               class="inline-flex border border-[#3aafa9] text-[#3aafa9] hover:bg-[#3aafa9] hover:text-[#0B0909] text-[10px] font-bold py-1.5 px-3 rounded-xl transition duration-150 items-center justify-center space-x-1.5 active:scale-95 cursor-pointer">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 000-4H9a2 2 0 000 4zm8-12V5a2 2 0 00-2-2H7a2 2 0 00-2 2v4h14z"></path>
                                </svg>
                                <span>Print Ulang</span>
                            </a>
                        </td>
                    </tr>
                @empty
                    {{-- Jika belum ada transaksi sama sekali --}}
                    <tr>
                        <td colspan="6" class="py-5 text-center text-[#d1d5dc]">Belum ada transaksi hari ini.</td>
                    </tr>
                @endforelse

            </tbody>
        </table>
    </div>
</div>