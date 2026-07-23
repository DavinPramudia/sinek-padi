<x-layout title="Sinek Padi - Form Petugas">

    {{-- KODE BUAT TEST ALPINE.JS (Taruh sini sementara buat ngecek) --}}
    <div x-data="{ pesan: 'Alpine.js Berhasil Jalan!' }" class="mb-6 bg-[#2E4540] p-4 rounded-xl border border-[#3b5952]">
        <h1 x-text="pesan" class="text-sm font-bold text-amber-400 mb-2"></h1>
        <button @click="pesan = 'Tombol Berhasil Diklik!'" type="button" class="bg-[#408175] hover:bg-[#3aafa9] text-white text-xs px-3 py-1.5 rounded-lg font-bold transition">
            Klik Buat Test
        </button>
    </div>
    {{-- BATAS KODE TEST --}}

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-stretch"> 
        
        <x-card-kategori />

        <x-card-ringkasan />

    </div> 

    <x-card-riwayat />

</x-layout>