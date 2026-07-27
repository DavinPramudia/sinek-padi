{{-- MODAL PERINGATAN (ALERT) --}}
<div x-show="openAlertModal" x-cloak class="fixed inset-0 z-[60] flex items-center justify-center bg-black/50 backdrop-blur-sm">
    <div class="bg-gray-800 border border-gray-700 p-6 rounded-xl shadow-xl max-w-sm w-full text-center space-y-4">
        
        {{-- Ikon Peringatan --}}
        <div class="text-yellow-500 text-5xl mb-2">⚠️</div>
        
        <h3 class="text-lg font-semibold text-white">Peringatan</h3>
        
        {{-- Pesan Peringatan (Otomatis berubah sesuai error-nya) --}}
        <p class="text-sm text-gray-300" x-text="alertMessage"></p>
        
        {{-- Tombol Tutup --}}
        <div class="flex justify-center pt-2">
            <button @click="openAlertModal = false" type="button" class="px-6 py-2 bg-gray-700 hover:bg-gray-600 text-white text-sm rounded-lg transition cursor-pointer">
                Mengerti
            </button>
        </div>
        
    </div>
</div>