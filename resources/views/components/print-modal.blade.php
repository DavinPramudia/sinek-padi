<div x-show="openPrintModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm" style="display: none;">
    
    <div class="bg-[#1C2B28] border border-[#3b5952] p-6 rounded-xl shadow-xl max-w-md w-full text-center space-y-4">
        
        <h3 class="text-lg font-semibold text-white">Konfirmasi & Cetak Tiket</h3>
        
        {{-- TAHAP 1: PILIH METODE --}}
        <div x-show="tahap === 'pilih'" class="space-y-4 py-2">
            <p class="text-sm text-gray-300">Pilih metode output tiket:</p>
            
            <div class="grid grid-cols-2 gap-3">
                <button @click="metodePilihan = 'e-ticket'" type="button" 
                        :class="metodePilihan === 'e-ticket' ? 'bg-[#3aafa9] text-black font-bold' : 'bg-[#243733] text-white'" 
                        class="p-4 border border-[#3b5952] rounded-xl flex flex-col items-center justify-center space-y-2">
                    <span>📱 E-Ticket</span>
                </button>

                <button @click="metodePilihan = 'print'" type="button" 
                        :class="metodePilihan === 'print' ? 'bg-[#3aafa9] text-black font-bold' : 'bg-[#243733] text-white'" 
                        class="p-4 border border-[#3b5952] rounded-xl flex flex-col items-center justify-center space-y-2">
                    <span>🖨️ Print Fisik</span>
                </button>
            </div>

            <div class="flex justify-between space-x-3 pt-4 border-t border-[#3b5952]">
                <button @click="openPrintModal = false" type="button" class="px-4 py-2 bg-red-600 text-white rounded-lg">Batal</button>
                <button @click="simpanDanCetak()" type="button" class="px-5 py-2 bg-[#3aafa9] text-black font-bold rounded-lg">Simpan & Proses</button>
            </div>
        </div>

        {{-- TAHAP 2: PROSES / LOADING --}}
        <div x-show="tahap === 'proses'" class="space-y-3 py-6">
            <div class="animate-spin rounded-full h-10 w-10 border-b-2 border-[#3aafa9] mx-auto"></div>
            <p class="text-sm text-gray-300">Menyimpan data ke sistem...</p>
        </div>

        {{-- TAHAP 3: SUKSES --}}
        <div x-show="tahap === 'sukses'" class="space-y-3 py-4">
            <div class="text-green-400 text-4xl mb-2">✔️</div>
            <h4 class="text-md font-bold text-white">Transaksi Berhasil!</h4>
            <p class="text-sm text-gray-300">Data sudah tersimpan.</p>
            
            <button @click="resetForm()" type="button" class="w-full mt-4 py-3 bg-[#408175] text-white font-bold rounded-xl">
                Tutup & Layani Berikutnya
            </button>
        </div>

    </div>
</div>