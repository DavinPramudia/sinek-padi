<x-admin.layout-admin title="Tambah Akun">
    <div x-data="{ openSaveModal: false }" class="flex flex-col h-full space-y-6 max-w-3xl">
        
        {{-- Header dengan Tombol Kembali (Warna sama dengan Simpan) dan Judul --}}
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.manajemen-akun') }}" class="px-3 py-2 bg-[#C4C4FA] hover:bg-[#b0b0f7] text-[#0B0909] text-xs font-semibold rounded-lg transition flex items-center space-x-1">
                <span>&larr; Kembali</span>
            </a>
            <h1 class="text-2xl font-bold text-[#EDEDED]">Tambah Akun SINEK-PADI</h1>
        </div>

        {{-- Form Utama dengan x-ref="saveForm" --}}
        <form x-ref="saveForm" action="{{ route('admin.manajemen-akun.store') }}" method="POST" class="bg-[#141c1a] border border-[#243733] p-8 rounded-xl space-y-5 shadow-lg">
            @csrf

            <div>
                <label class="block text-xs font-medium text-[#EDEDED] mb-2">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="bg-[#0B0909] border border-[#243733] text-[#EDEDED] text-xs rounded-lg focus:ring-[#3aafa9] focus:border-[#3aafa9] block w-full p-3 outline-none" placeholder="Masukkan nama lengkap...">
            </div>

            <div>
                <label class="block text-xs font-medium text-[#EDEDED] mb-2">Username</label>
                <input type="text" name="username" value="{{ old('username') }}" required class="bg-[#0B0909] border border-[#243733] text-[#EDEDED] text-xs rounded-lg focus:ring-[#3aafa9] focus:border-[#3aafa9] block w-full p-3 outline-none" placeholder="Masukkan username...">
            </div>

            <div>
                <label class="block text-xs font-medium text-[#EDEDED] mb-2">Password</label>
                <input type="password" name="password" required class="bg-[#0B0909] border border-[#243733] text-[#EDEDED] text-xs rounded-lg focus:ring-[#3aafa9] focus:border-[#3aafa9] block w-full p-3 outline-none" placeholder="********">
            </div>

            <div>
                <label class="block text-xs font-medium text-[#EDEDED] mb-2">Ulangi Password</label>
                <input type="password" name="password_confirmation" required class="bg-[#0B0909] border border-[#243733] text-[#EDEDED] text-xs rounded-lg focus:ring-[#3aafa9] focus:border-[#3aafa9] block w-full p-3 outline-none" placeholder="********">
            </div>

            <div>
                <label class="block text-xs font-medium text-[#EDEDED] mb-2">Pilih Role</label>
                <div class="flex items-center space-x-6 text-xs text-[#d1d5dc]">
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="radio" name="id_roles" value="1" {{ old('id_roles') == 1 ? 'checked' : '' }} class="accent-[#3aafa9]">
                        <span>Admin</span>
                    </label>
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="radio" name="id_roles" value="2" {{ old('id_roles') == 2 ? 'checked' : '' }} class="accent-[#3aafa9]">
                        <span>Petugas</span>
                    </label>
                </div>
            </div>

            <div class="pt-4">
                {{-- Tombol untuk memicu modal --}}
                <button @click="openSaveModal = true" type="button" class="bg-[#C4C4FA] text-[#0B0909] font-semibold text-xs px-6 py-2.5 rounded-lg hover:bg-[#b0b0f7] transition cursor-pointer">
                    Simpan
                </button>
            </div>
        </form>

        {{-- Panggil Komponen Modal Simpan --}}
        <x-admin.save-modal>
            Apakah kamu yakin ingin menyimpan akun baru ini?
        </x-admin.save-modal>

    </div>
</x-admin.layout-admin>