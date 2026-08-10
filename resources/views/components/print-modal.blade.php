{{-- resources/views/components/print-modal.blade.php --}}
<div x-show="openPrintModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm">
    <div class="bg-gray-800 border border-gray-700 p-6 rounded-xl shadow-xl max-w-sm w-full text-center space-y-4">
        
        <h3 class="text-lg font-semibold text-white">Konfirmasi & Cetak Tiket</h3>
        
        {{-- TAHAP 1: PILIH METODE --}}
        <div x-show="tahap === 'pilih'" class="space-y-4">
            <p class="text-sm text-gray-300">Pilih metode output tiket:</p>
            
            {{-- Kotak Pilihan --}}
            <div class="grid grid-cols-2 gap-3">
                <button @click="metodePilihan = 'e-ticket'" type="button" 
                        :class="metodePilihan === 'e-ticket' ? 'bg-blue-600 text-white font-bold ring-2 ring-white/30' : 'bg-gray-700 text-gray-300 hover:bg-gray-600'" 
                        class="p-4 border border-gray-600 rounded-xl flex flex-col items-center justify-center transition cursor-pointer">
                    <span>E-Ticket</span>
                </button>
                <button @click="metodePilihan = 'print'" type="button" 
                        :class="metodePilihan === 'print' ? 'bg-blue-600 text-white font-bold ring-2 ring-white/30' : 'bg-gray-700 text-gray-300 hover:bg-gray-600'" 
                        class="p-4 border border-gray-600 rounded-xl flex flex-col items-center justify-center transition cursor-pointer">
                    <span>Print Fisik</span>
                </button>
            </div>

            {{-- Wadah Tombol Bawah (Persis seperti modal logout) --}}
            <div class="flex justify-center space-x-3 pt-2">
                {{-- Tombol Batal --}}
                <button @click="openPrintModal = false" type="button" class="px-4 py-2 bg-gray-700 hover:bg-gray-600 text-white text-sm rounded-lg transition cursor-pointer">
                    Batal
                </button>
                
                {{-- Tombol Eksekusi (Simpan) --}}
                <button @click="simpanDanCetak()" type="button" class="px-4 py-2 bg-green-600 hover:bg-green-500 text-white text-sm rounded-lg transition cursor-pointer">
                    Simpan & Proses
                </button>
            </div>
        </div>

        {{-- TAHAP 2: PROSES / LOADING --}}
        <div x-show="tahap === 'proses'" class="space-y-3 py-6">
            <div class="animate-spin rounded-full h-10 w-10 border-b-2 border-white mx-auto"></div>
            <p class="text-sm text-gray-300">Menyimpan data ke sistem...</p>
        </div>

        {{-- TAHAP 3: SUKSES --}}
        <div x-show="tahap === 'sukses'" class="space-y-4 text-center pb-2">
            <div class="text-green-400 text-6xl mb-4">✔️</div>
            <h4 class="text-xl font-bold text-white mb-2">Transaksi Berhasil!</h4>
            <p class="text-sm text-gray-300 mb-6">Data telah tersimpan ke database.</p>
            
            {{-- JIKA PILIH PRINT FISIK --}}
            <div x-show="metodePilihan === 'print'">
                <button type="button" 
                        @click="window.open(urlCetak, '_blank'); resetForm();" 
                        class="block w-full px-4 py-3 bg-blue-600 hover:bg-blue-500 text-white font-bold text-sm rounded-lg transition cursor-pointer shadow-lg active:scale-95">
                    Cetak Karcis & Selesai
                </button>
            </div>

            {{-- JIKA PILIH E-TICKET --}}
            <div x-show="metodePilihan === 'e-ticket'">
                <button type="button" 
                        @click="window.open(urlCetak, '_blank'); resetForm();" 
                        class="block w-full px-4 py-3 bg-green-600 hover:bg-green-500 text-white font-bold text-sm rounded-lg transition cursor-pointer shadow-lg active:scale-95">
                    Download E-Ticket & Selesai
                </button>
            </div>
        </div>

    </div>
</div>