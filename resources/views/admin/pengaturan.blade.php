<x-admin.layout-admin title="Pengaturan Sistem">
    {{-- Inisialisasi Alpine.js untuk kontrol modal dan form aktif --}}
    <div class="flex flex-col h-full space-y-6 max-w-3xl" x-data="{ openSaveModal: false, activeForm: null }">
        
        <!-- HEADER -->
        <div>
            <h1 class="text-2xl font-bold text-[#EDEDED]">Pengaturan Sistem SINEK-PADI</h1>
            <p class="text-sm text-[#d1d5dc] mt-1">Kelola dan perbarui nominal tarif retribusi kendaraan pos masuk.</p>
        </div>

        <!-- NOTIFIKASI BERHASIL -->
        @if(session('success'))
            <div class="bg-[#141c1a] border border-[#3aafa9] text-[#3aafa9] px-4 py-3 rounded-xl text-xs font-semibold flex items-center space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- KARTU PENGATURAN TARIF -->
        <div class="bg-[#141c1a] border border-[#243733] rounded-xl p-6 space-y-6 shadow-lg">
            <div class="border-b border-[#243733] pb-3">
                <h2 class="text-lg font-semibold text-white">Daftar Tarif Retribusi Kendaraan</h2>
                <p class="text-xs text-[#d1d5dc] mt-0.5">Perubahan tarif ini akan langsung diterapkan pada transaksi baru berikutnya.</p>
            </div>

            <div class="space-y-4">
                @foreach($tarifs as $tarif)
                    <form action="{{ route('admin.pengaturan.update', $tarif->id_tarif) }}" method="POST" class="flex flex-col sm:flex-row items-start sm:items-center justify-between bg-[#0B0909] border border-[#243733] p-4 rounded-xl gap-4 hover:border-[#3aafa9]/40 transition">
                        @csrf
                        @method('PUT')

                        <div>
                            <span class="text-sm font-bold text-white tracking-wide">{{ $tarif->nama_kendaraan }}</span>
                            <p class="text-[11px] text-[#d1d5dc]">Tarif retribusi sekali masuk</p>
                        </div>

                        <div class="flex items-center gap-2 w-full sm:w-auto">
                            <div class="relative flex items-center flex-1 sm:flex-initial">
                                <span class="absolute left-3 text-xs text-[#d1d5dc] font-medium">Rp</span>
                                <input type="number" name="harga_tarif" value="{{ $tarif->harga_tarif }}" class="bg-[#141c1a] border border-[#243733] text-white text-xs rounded-xl pl-9 pr-3 py-2.5 focus:outline-none focus:border-[#3aafa9] w-36 font-semibold shadow-inner">
                            </div>
                            
                            {{-- PERBAIKAN DI SINI: Tambahkan kata "window." di depan activeForm --}}
                            <button type="button" @click="window.activeForm = $el.closest('form'); openSaveModal = true" class="bg-[#3aafa9] hover:bg-[#2b8a85] text-white text-xs font-semibold px-4 py-2.5 rounded-xl transition shadow-md active:scale-95 shrink-0 cursor-pointer">
                                Simpan
                            </button>
                        </div>
                    </form>
                @endforeach
            </div>
        </div>

        <!-- PANGGIL KOMPONEN MODAL TERPISAH -->
        <x-admin.save-modal>
            Apakah kamu yakin ingin menyimpan perubahan tarif ini?
        </x-admin.save-modal>

    </div>
</x-admin.layout-admin>