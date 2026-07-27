<div x-show="openPrintModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm" style="display: none;" x-cloak>
    <div class="bg-gray-800 border border-gray-700 p-6 rounded-xl shadow-xl max-w-md w-full text-center space-y-4" x-data="{ metodePilihan: 'e-ticket', tahap: 'pilih' }">
        
        <h3 class="text-lg font-semibold text-white">Konfirmasi & Cetak Tiket</h3>
        
        {{-- TAHAP 1: PILIH METODE --}}
        <div x-show="tahap === 'pilih'" class="space-y-4 py-2">
            <p class="text-sm text-gray-300">Silakan pilih metode output tiket untuk pengunjung:</p>
            
            <div class="grid grid-cols-2 gap-3">
                <button @click="metodePilihan = 'e-ticket'" type="button" 
                        :class="metodePilihan === 'e-ticket' ? 'bg-[#3aafa9] font-bold ring-2 ring-white' : 'bg-gray-700 hover:bg-gray-600'" 
                        class="p-4 text-white text-xs rounded-xl transition cursor-pointer flex flex-col items-center justify-center space-y-2">
                    <span class="text-lg">📱</span>
                    <span>E-Ticket Online</span>
                </button>

                <button @click="metodePilihan = 'print'" type="button" 
                        :class="metodePilihan === 'print' ? 'bg-[#3aafa9] font-bold ring-2 ring-white' : 'bg-gray-700 hover:bg-gray-600'" 
                        class="p-4 text-white text-xs rounded-xl transition cursor-pointer flex flex-col items-center justify-center space-y-2">
                    <span class="text-lg">🖨️</span>
                    <span>Print Ticket Fisik</span>
                </button>
            </div>
        </div>

        {{-- TAHAP 2: LOADING (Menyimpan ke DB) --}}
        <div x-show="tahap === 'proses'" class="space-y-3 py-4">
            <div class="animate-spin rounded-full h-10 w-10 border-b-2 border-[#3aafa9] mx-auto"></div>
            <p class="text-sm text-gray-300">
                Menyimpan data ke sistem & menyiapkan <strong class="text-[#3aafa9]" x-text="metodePilihan === 'e-ticket' ? 'E-Ticket' : 'Tiket Fisik'"></strong>...
            </p>
        </div>

        {{-- TAHAP 3: SUKSES (Pengganti Popup Localhost) --}}
        <div x-show="tahap === 'sukses'" class="space-y-3 py-4">
            <div class="text-green-400 text-5xl mb-2 animate-pulse">✔️</div>
            <h4 class="text-md font-bold text-white">Transaksi Berhasil!</h4>
            <p class="text-sm text-gray-300">
                Data telah tersimpan. <br>
                Membuka <strong class="text-[#3aafa9]" x-text="metodePilihan === 'e-ticket' ? 'E-Ticket Digital' : 'Jendela Print'"></strong>...
            </p>
        </div>

        {{-- TOMBOL AKSI TAHAP 1 --}}
        <div x-show="tahap === 'pilih'" class="flex justify-between space-x-3 pt-4 border-t border-gray-700">
            <button @click="openPrintModal = false" type="button" class="px-4 py-2 bg-red-600/80 hover:bg-red-600 text-white text-sm rounded-lg transition cursor-pointer">
                Batal
            </button>
            
            <button @click="
                    tahap = 'proses'; 
                    
                    // Simulasi respon dari database selama 1.5 detik
                    setTimeout(() => { 
                        tahap = 'sukses'; 
                        
                        // Di sini nanti ditaruh trigger untuk window.print() atau redirect
                    }, 1500);
                " 
                type="button" 
                class="px-5 py-2 bg-[#3aafa9] hover:bg-[#2b8a86] text-white text-sm font-bold rounded-lg transition cursor-pointer">
                Simpan & Proses ➔
            </button>
        </div>

        {{-- TOMBOL AKSI TAHAP 3 (SUKSES) --}}
        <div x-show="tahap === 'sukses'" class="flex justify-center pt-4 border-t border-gray-700">
            <button @click="openPrintModal = false; tahap = 'pilih'; window.location.reload();" type="button" class="w-full px-5 py-2 bg-green-600 hover:bg-green-500 text-white text-sm font-bold rounded-lg transition cursor-pointer">
                Tutup & Layani Berikutnya
            </button>
        </div>

    </div>
</div>