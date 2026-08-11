<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Karcis - SINEK-PADI</title>
    <style>
        /* Pengaturan mutlak untuk ukuran kertas thermal gulung */
        @page {
            size: 58mm 85mm; /* Lebar 58mm, panjang otomatis dibatasi maksimal 200mm agar tidak kepanjangan */
            margin: 2mm;
        }

        body {
            font-family: "Courier", "Courier New", monospace !important;            
            font-size: 11px;
            width: 54mm; /* Dibuat sedikit di bawah 58mm agar ada sisa margin aman */
            margin: 0 auto;
            padding: 2px;
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
            .no-print { 
                display: none !important; 
            }
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

    <div class="font-bold" style="margin-bottom: 3px;">Rincian Wisatawan:</div>
    
    <table style="width: 100%; border-collapse: collapse;">
        @foreach($transaksi->details as $det)
            <tr>
                <td style="padding: 2px 0;">- {{ $det->nama_kategori_wisatawan }}</td>
                <td style="text-align: right; padding: 2px 0;">{{ $det->jumlah_jiwa }} Jiwa</td>
            </tr>
        @endforeach
    </table>

    <div class="border-dashed"></div>

    <table style="width: 100%;">
        <tr class="font-bold" style="font-size: 12px;">
            <td>TOTAL BAYAR</td>
            <td style="text-align: right;">Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</td>
        </tr>
    </table>

    <div class="border-dashed"></div>
    <div class="text-center" style="margin-top: 10px;">
        <p style="margin: 2px 0;">Terima Kasih Atas Kunjungan Anda</p>
        <p style="font-size: 10px; margin: 2px 0;">Simpan karcis ini sebagai bukti sah.</p>
    </div>

{{-- Tombol hanya akan muncul jika bukan mode e-ticket (PDF) --}}
    @if(request('mode') !== 'e-ticket')
    <div class="text-center no-print" style="margin-top: 20px; margin-bottom: 20mm;">
        <button onclick="window.print()" style="padding: 6px 12px;">
            Cetak Ulang Struk
        </button>
    </div>
    @endif


</body>
</html>