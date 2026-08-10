<x-admin.layout-admin title="Edit Akun">
    {{-- 1. Tambahkan activeForm: null pada x-data --}}
    <div x-data="{ 
            openSaveModal: false,
            activeForm: null
        }" class="flex flex-col h-full space-y-6 max-w-3xl">
        
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.manajemen-akun') }}" class="px-4 py-2 bg-[#C4C4FA] hover:bg-[#b0b0f7] text-[#0B0909] text-xs font-semibold rounded-lg transition flex items-center space-x-1 shadow-sm">
                <span>&larr; Kembali</span>
            </a>
            <h1 class="text-2xl font-bold text-[#EDEDED]">Edit Akun SINEK-PADI</h1>
        </div>

        <form x-ref="saveForm" action="{{ route('admin.manajemen-akun.update', $user->id_users ?? $user->id) }}" method="POST" class="bg-[#141c1a] border border-[#243733] p-8 rounded-xl space-y-5 shadow-lg">
            @csrf
            @method('PUT')

            {{-- Input Nama Lengkap --}}
            <div>
                <label class="block text-xs font-medium text-[#EDEDED] mb-2">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}" required class="bg-[#0B0909] border @error('name') border-red-500 @else border-[#243733] @enderror text-[#EDEDED] text-xs rounded-lg focus:ring-[#3aafa9] focus:border-[#3aafa9] block w-full p-3 outline-none">
                @error('name')
                    <span class="text-xs text-red-400 mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            {{-- Input Username --}}
            <div>
                <label class="block text-xs font-medium text-[#EDEDED] mb-2">Username</label>
                <input type="text" name="username" value="{{ old('username', $user->username ?? '') }}" required class="bg-[#0B0909] border @error('username') border-red-500 @else border-[#243733] @enderror text-[#EDEDED] text-xs rounded-lg focus:ring-[#3aafa9] focus:border-[#3aafa9] block w-full p-3 outline-none">
                @error('username')
                    <span class="text-xs text-red-400 mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            {{-- Password Baru --}}
            <div x-data="{ showPassword: false }">
                <label class="block text-xs font-medium text-[#EDEDED] mb-2">
                    Password Baru 
                    <span class="text-gray-500 font-normal">(Kosongkan jika tidak ingin mengubah password)</span>
                </label>
                <div class="relative">
                    <input :type="showPassword ? 'text' : 'password'" name="password" class="bg-[#0B0909] border @error('password') border-red-500 @else border-[#243733] @enderror text-[#EDEDED] text-xs rounded-lg focus:ring-[#3aafa9] focus:border-[#3aafa9] block w-full p-3 pr-10 outline-none" placeholder="********">
                    
                    <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-[#EDEDED] cursor-pointer">
                        <svg x-show="!showPassword" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        <svg x-show="showPassword" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.03 10.05 0 012.944-4.575m3.75-2.025A9.956 9.956 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21M3 3l18 18"/></svg>
                    </button>
                </div>
                @error('password')
                    <span class="text-xs text-red-400 mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            {{-- Ulangi Password Baru --}}
            <div x-data="{ showConfirmPassword: false }">
                <label class="block text-xs font-medium text-[#EDEDED] mb-2">Ulangi Password Baru</label>
                <div class="relative">
                    <input :type="showConfirmPassword ? 'text' : 'password'" name="password_confirmation" class="bg-[#0B0909] border border-[#243733] text-[#EDEDED] text-xs rounded-lg focus:ring-[#3aafa9] focus:border-[#3aafa9] block w-full p-3 pr-10 outline-none" placeholder="********">
                    
                    <button type="button" @click="showConfirmPassword = !showConfirmPassword" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-[#EDEDED] cursor-pointer">
                        <svg x-show="!showConfirmPassword" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        <svg x-show="showConfirmPassword" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.03 10.05 0 012.944-4.575m3.75-2.025A9.956 9.956 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21M3 3l18 18"/></svg>
                    </button>
                </div>
            </div>

            {{-- Pilih Role --}}
            <div>
                <label class="block text-xs font-medium text-[#EDEDED] mb-2">Pilih Role</label>
                <div class="flex items-center space-x-6 text-xs text-[#d1d5dc]">
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="radio" name="id_roles" value="1" {{ (old('id_roles', $user->id_roles ?? '') == 1) ? 'checked' : '' }} class="accent-[#3aafa9]">
                        <span>Admin</span>
                    </label>
                    <label class="flex items-center space-x-2 cursor-pointer">
                        <input type="radio" name="id_roles" value="2" {{ (old('id_roles', $user->id_roles ?? '') == 2) ? 'checked' : '' }} class="accent-[#3aafa9]">
                        <span>Petugas</span>
                    </label>
                </div>
                @error('id_roles')
                    <span class="text-xs text-red-400 mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div class="pt-4">
                {{-- 2. Sesuaikan event click tombol seperti pada halaman Tambah Akun --}}
                <button @click="activeForm = $refs.saveForm; if (activeForm.checkValidity()) { openSaveModal = true; } else { activeForm.reportValidity(); }" type="button" class="bg-[#C4C4FA] text-[#0B0909] font-semibold text-xs px-6 py-2.5 rounded-lg hover:bg-[#b0b0f7] transition cursor-pointer">
                    Simpan Perubahan
                </button>
            </div>
        </form>

        <x-admin.save-modal title="Konfirmasi Simpan">
            Apakah kamu yakin ingin menyimpan perubahan data akun ini?
        </x-admin.save-modal>
        
    </div>
</x-admin.layout-admin>