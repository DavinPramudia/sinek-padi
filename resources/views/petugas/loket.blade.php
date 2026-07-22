<x-layout title="Sinek Padi - Form Petugas">

    {{-- GRID ATAS: PEMBAGI 2 KOLOM --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-stretch"> 
        
        {{-- 1. Form Input Kategori (Kiri) --}}
        <x-card-kategori />

        {{-- 2. Ringkasan Statistik (Kanan) --}}
        <x-card-ringkasan />

    </div> 

    {{-- 3. Tabel Riwayat (Bawah) --}}
    <x-card-riwayat />

</x-layout>