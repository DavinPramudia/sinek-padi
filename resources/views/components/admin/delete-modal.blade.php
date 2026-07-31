{{-- Modal Konfirmasi Hapus --}}
<div x-show="openDeleteModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm" style="display: none;" x-cloak>
    <div class="bg-[#141c1a] border border-[#243733] p-6 rounded-xl shadow-xl max-w-sm w-full text-center space-y-4">
        <h3 class="text-lg font-semibold text-[#EDEDED]">Konfirmasi Hapus</h3>
        <p class="text-xs text-[#d1d5dc]">Apakah kamu yakin ingin menghapus akun ini? Data yang dihapus tidak dapat dikembalikan.</p>
        
        <div class="flex justify-center space-x-3 pt-2">
            {{-- Tombol Batal --}}
            <button @click="openDeleteModal = false" type="button" class="px-4 py-2 bg-[#243733] hover:bg-[#2E4540] text-[#d1d5dc] text-xs rounded-lg transition cursor-pointer">
                Batal
            </button>
            
            {{-- Tombol Eksekusi Hapus --}}
            <form :action="deleteUrl" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-500 text-white text-xs rounded-lg transition cursor-pointer">
                    Ya, Hapus
                </button>
            </form>
        </div>
    </div>
</div>