<x-layout title="Sinek Padi - Form Petugas">

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-stretch"> 
        
        <x-card-kategori 
            :kategoriKendaraan="$KategoriKendaraan"
            :kategori-wisatawan="$KategoriWisatawan" 
        />

        <x-card-ringkasan 
            :total-pendapatan="$totalPendapatan"
            :total-tiket="$totalTiket"
            :total-motor="$totalMotor"
            :total-mobil="$totalMobil"
            :total-wisatawan="$totalWisatawan"
        />

    </div> 

    <x-card-riwayat :riwayat-transaksi="$riwayatTransaksi" />

</x-layout>