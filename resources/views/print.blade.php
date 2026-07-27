<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Tiket - #{{ $transaksi->id }}</title>
    <style>
        /* Styling khusus cetak struk kamu di sini */
        body { font-family: monospace; font-size: 12px; padding: 10px; }
    </style>
</head>
<body>
    <div style="text-align: center;">
        <h3>TIKET MASUK WISATA</h3>
        <p>No. Transaksi: #{{ $transaksi->id }}</p>
        <p>Total Bayar: Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</p>
        <p>Total Pengunjung: {{ $transaksi->total_pengunjung }} Orang</p>
        <hr>
        <p>Terima Kasih!</p>
    </div>

    {{-- Script agar dialog print browser otomatis muncul saat halaman dibuka --}}
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>