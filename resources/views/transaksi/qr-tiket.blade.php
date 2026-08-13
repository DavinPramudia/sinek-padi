<div class="text-center p-6 bg-[#141c1a] rounded-xl text-white">
    <h2 class="text-lg font-bold mb-2">Scan E-Ticket Anda</h2>
    <p class="text-xs text-gray-400 mb-4">Arahkan kamera HP Anda ke QR Code di bawah ini untuk melihat tiket.</p>
    
    {{-- Menampilkan QR Code instan menggunakan package --}}
    <div class="bg-white p-4 inline-block rounded-lg">
        {!! QrCode::size(200)->generate(route('transaksi.cetak', $transaksi->id_transaksi)) !!}
    </div>
    
    <p class="text-xs text-gray-400 mt-4 font-mono">No Karcis: {{ $transaksi->no_karcis }}</p>
</div>