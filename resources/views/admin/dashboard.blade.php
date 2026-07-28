<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Sinek Padi</title>
    <!-- Tailwind CSS (CDN / sesuaikan dengan setup projectmu) -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#182421] text-[#EDEDED] min-h-screen flex flex-col">

    <!-- Header / Navbar Admin -->
    <header class="bg-[#243733] border-b border-[#3b5952] px-6 py-4 flex justify-between items-center shadow-md">
        <div class="flex items-center space-x-3">
            <div class="bg-[#3aafa9] text-[#0B0909] font-bold px-3 py-1.5 rounded-xl text-sm">
                ADMIN PANEL
            </div>
            <h1 class="text-lg font-semibold tracking-wide text-[#EDEDED]">Sinek Padi - Dashboard Utama</h1>
        </div>
        <div class="flex items-center space-x-4">
            <span class="text-xs text-[#d1d5dc]">Halo, <strong class="text-[#3aafa9]">Administrator</strong></span>
            <!-- Tombol Logout / Kembali -->
            <a href="/petugas/loket" class="text-xs bg-[#2E4540] hover:bg-[#3b5952] border border-[#3b5952] px-3 py-2 rounded-xl transition duration-150">
                Kembali ke Kasir
            </a>
        </div>
    </header>

    <!-- Konten Utama Dashboard -->
    <main class="flex-1 p-6 max-w-7xl mx-auto w-full space-y-6">

        <!-- Baris Kartu Statistik (Cards) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            
            <!-- Card 1: Total Pendapatan -->
            <div class="bg-[#2E4540] rounded-3xl p-5 shadow-lg border border-[#3b5952] space-y-2">
                <p class="text-xs text-[#d1d5dc] uppercase tracking-wider font-semibold">Total Pendapatan Hari Ini</p>
                <h3 class="text-2xl font-bold text-[#3aafa9]">Rp 1.450.000</h3>
                <span class="text-[11px] text-emerald-400 bg-emerald-950/50 px-2 py-0.5 rounded border border-emerald-800">
                    +12% dari kemarin
                </span>
            </div>

            <!-- Card 2: Total Pengunjung / Sensus -->
            <div class="bg-[#2E4540] rounded-3xl p-5 shadow-lg border border-[#3b5952] space-y-2">
                <p class="text-xs text-[#d1d5dc] uppercase tracking-wider font-semibold">Total Wisatawan Masuk</p>
                <h3 class="text-2xl font-bold text-[#EDEDED]">342 Jiwa</h3>
                <span class="text-[11px] text-[#3aafa9] bg-[#1c2b28] px-2 py-0.5 rounded border border-[#3b5952]">
                    Lokal: 200 | Nusantara: 120 | Asing: 22
                </span>
            </div>

            <!-- Card 3: Total Transaksi -->
            <div class="bg-[#2E4540] rounded-3xl p-5 shadow-lg border border-[#3b5952] space-y-2">
                <p class="text-xs text-[#d1d5dc] uppercase tracking-wider font-semibold">Total Kendaraan Tercatat</p>
                <h3 class="text-2xl font-bold text-[#EDEDED]">115 Kendaraan</h3>
                <span class="text-[11px] text-[#d1d5dc] bg-[#1c2b28] px-2 py-0.5 rounded border border-[#3b5952]">
                    Motor & Mobil
                </span>
            </div>

        </div>

        <!-- Bagian Tabel Rekapitulasi Cepat -->
        <div class="bg-[#2E4540] rounded-3xl p-5 shadow-lg border border-[#3b5952] space-y-4">
            <div class="flex justify-between items-center pb-3 border-b border-[#3b5952]">
                <h2 class="text-lg font-semibold text-[#EDEDED]">
                    Monitoring Transaksi Keseluruhan
                </h2>
                <span class="text-[11px] text-[#d1d5dc]">Data real-time sistem loket</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-[#3b5952] text-[11px] text-[#d1d5dc] uppercase tracking-wider">
                            <th class="pb-3 text-center">No Karcis</th>
                            <th class="pb-3 text-center">Waktu</th>
                            <th class="pb-3 text-center">Petugas</th>
                            <th class="pb-3 text-center">Kendaraan</th>
                            <th class="pb-3 text-center">Sensus (L / N / M)</th>
                            <th class="pb-3 text-center">Total Bayar</th>
                        </tr>
                    </thead>
                    <tbody class="text-xs divide-y divide-[#3b5952]/40">
                        <!-- Contoh Data Statis / Dummy untuk Tampilan Awal -->
                        <tr class="hover:bg-[#1c2b28]/60 transition duration-150">
                            <td class="py-3.5 text-center font-mono text-[#EDEDED] font-semibold">KARCIS-001</td>
                            <td class="py-3.5 text-center text-[#d1d5dc]">28/07/2026, 10:15 WIB</td>
                            <td class="py-3.5 text-center text-[#d1d5dc]">Petugas 1</td>
                            <td class="py-3.5 text-center">
                                <span class="bg-[#243733] text-[#d1d5dc] px-2.5 py-1 rounded-md text-[11px] border border-[#3b5952]">Mobil Pribadi</span>
                            </td>
                            <td class="py-3.5 text-center">
                                <span class="bg-[#1c2b28] text-[#3aafa9] font-mono px-2.5 py-1 rounded border border-[#3b5952] text-[11px]">2 / 1 / 0</span>
                            </td>
                            <td class="py-3.5 text-center font-bold text-[#3aafa9] text-sm">Rp 50.000</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </main>

</body>
</html>