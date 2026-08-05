<div x-show="openSaveModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm" style="display: none;" x-cloak>
    <div class="bg-[#141c1a] border border-[#243733] p-6 rounded-xl shadow-xl max-w-sm w-full text-center space-y-4">
        <h3 class="text-lg font-semibold text-[#EDEDED]">{{ $title ?? 'Konfirmasi Simpan' }}</h3>
        <p class="text-xs text-[#d1d5dc]">
            {{ $slot ?? 'Apakah kamu yakin ingin menyimpan data ini?' }}
        </p>
        
        <div class="flex justify-center space-x-3 pt-2">
            {{-- Tombol Batal (Menutup Modal) --}}
            <button @click="openSaveModal = false" type="button" class="px-4 py-2 bg-[#243733] hover:bg-[#2E4540] text-[#d1d5dc] text-xs rounded-lg transition cursor-pointer">
                Batal
            </button>
            
            {{-- Ubah dari $refs.saveForm.submit() menjadi activeForm.submit() --}}
            <button @click="activeForm.submit()" type="button" class="px-4 py-2 bg-[#C4C4FA] hover:bg-[#b0b0f7] text-[#0B0909] font-semibold text-xs rounded-lg transition cursor-pointer">
                Ya, Simpan
            </button>
        </div>
    </div>
</div>