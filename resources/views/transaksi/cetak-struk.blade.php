<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Karcis - SINEK-PADI</title>
    <style>
        /* Pengaturan mutlak untuk ukuran kertas thermal gulung */
        @page {
            size: 54mm 80mm; /* Lebar 58mm, panjang otomatis dibatasi maksimal 200mm agar tidak kepanjangan */
            margin: 0;
        }

        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 11px;
            width: 54mm; /* Dibuat sedikit di bawah 58mm agar ada sisa margin aman */
            margin: 0 auto;
            padding: 5px;
            color: #000;
            background: #fff;
            box-sizing: border-box;
        }

        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
        .flex-between { display: flex; justify-content: space-between; }
        .border-dashed { border-bottom: 1px dashed #000; margin: 6px 0; }
        
        /* Saat dicetak, sembunyikan tombol dan pangkas lebar penuh */
        @media print {
            body { 
                width: 54mm; 
                margin: 0;
                padding: 2mm;
            }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body onload="window.print()"> <!-- Otomatis membuka dialog print saat halaman terbuka -->

    <div class="text-center">
        <h3 class="font-bold" style="margin: 0; font-size: 16px;">SINEK-PADI</h3>
        <p style="margin: 2px 0;">Karcis Masuk Wisata</p>
    </div>

    <div class="border-dashed"></div>

    <div style="margin: 4px 0;">
        <span>No. Tiket :</span><br>
        <span class="font-bold" style="font-size: 13px;">{{ $transaksi->no_karcis }}</span>
    </div>
    <p style="margin: 4px 0;">Waktu     : {{ \Carbon\Carbon::parse($transaksi->waktu)->format('d/m/Y H:i') }}</p>
    <p style="margin: 4px 0;">Kendaraan : {{ $transaksi->nama_kendaraan ?? '-' }}</p>

    <div class="border-dashed"></div>

    <p class="font-bold" style="margin: 4px 0;">Rincian Wisatawan:</p>
    
    @foreach($transaksi->details as $det)
        <div class="flex-between" style="margin: 2px 0;">
            <span>- {{ $det->nama_kategori_wisatawan }}</span>
            <span>{{ $det->jumlah_jiwa }} Jiwa</span>
        </div>
    @endforeach

    <div class="border-dashed"></div>

    <div class="flex-between font-bold" style="margin: 6px 0;">
        <span>TOTAL BAYAR</span>
        <span>Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</span>
    </div>

    <div class="border-dashed"></div>
    <div class="text-center" style="margin-top: 10px;">
        <p style="margin: 2px 0;">Terima Kasih Atas Kunjungan Anda</p>
        <p style="font-size: 10px; margin: 2px 0;">Simpan karcis ini sebagai bukti sah.</p>
    </div>

    <!-- Tombol manual dengan inline style display:none khusus untuk PDF, atau memanfaatkan class no-print -->
    <div class="text-center no-print" style="margin-top: 20px;">
        <button onclick="window.print()" style="padding: 6px 12px; font-size: 12px; cursor: pointer; background: #000; color: #fff; border: none; border-radius: 4px;">
            Cetak Ulang Struk
        </button>
    </div>

</body>
</html>