<x-admin.layout-admin title="Tambah Akun">
    {{-- Inisialisasi state Alpine.js untuk modal dan penglihat password --}}
    <div x-data="{ 
            openSaveModal: false, 
            showPassword: false, 
            showConfirmPassword: false 
         }" 
         class="flex flex-col h-full space-y-6 max-w-3xl">
        
        {{-- Header dengan Tombol Kembali dan Judul --}}
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.manajemen-akun') }}" class="px-3 py-2 bg-[#C4C4FA] hover:bg-[#b0b0f7] text-[#0B0909] text-xs font-semibold rounded-lg transition flex items-center space-x-1">
                <span>&larr; Kembali</span>
            </a>
            <h1 class="text-2xl font-bold text-[#EDEDED]">Tambah Akun SINEK-PADI</h1>
        </div>

        {{-- Form Utama dengan x-ref="saveForm" --}}
        <form x-ref="saveForm" action="{{ route('admin.manajemen-akun.store') }}" method="POST" class="bg-[#141c1a] border border-[#243733] p-8 rounded-xl space-y-5 shadow-lg">
            @csrf

            {{-- Input Nama Lengkap --}}
            <div>
                <label class="block text-xs font-medium text-[#EDEDED] mb-2">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="bg-[#0B0909] border {{ $errors->has('name') ? 'border-red-500' : 'border-[#243733]' }} text-[#EDEDED] text-xs rounded-lg focus:ring-[#3aafa9] focus:border-[#3aafa9] block w-full p-3 outline-none transition" placeholder="Masukkan nama lengkap...">
                @error('name')
                    <span class="text-red-400 text-[11px] mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            {{-- Input Username --}}
            <div>
                <label class="block text-xs font-medium text-[#EDEDED] mb-2">Username</label>
                <input type="text" name="username" value="{{ old('username') }}" required class="bg-[#0B0909] border {{ $errors->has('username') ? 'border-red-500' : 'border-[#243733]' }} text-[#EDEDED] text-xs rounded-lg focus:ring-[#3aafa9] focus:border-[#3aafa9] block w-full p-3 outline-none transition" placeholder="Masukkan username...">
                @error('username')
                    <span class="text-red-400 text-[11px] mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            {{-- Input Password dengan Tombol Show/Hide --}}
            <div>
                <label class="block text-xs font-medium text-[#EDEDED] mb-2">Password</label>
                <div class="relative flex items-center">
                    <input :type="showPassword ? 'text' : 'password'" 
                           name="password" 
                           required 
                           class="bg-[#0B0909] border {{ $errors->has('password') ? 'border-red-500' : 'border-[#243733]' }} text-[#EDEDED] text-xs rounded-lg focus:ring-[#3aafa9] focus:border-[#3aafa9] block w-full p-3 pr-10 outline-none transition" 
                           placeholder="********">
                    
                    <button type="button" 
                            @click="showPassword = !showPassword" 
                            class="absolute right-3 text-[#d1d5dc] hover:text-[#3aafa9] transition focus:outline-none cursor-pointer">
                        {{-- Icon Mata Terbuka --}}
                        <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4" style="display: none;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                        {{-- Icon Mata Tertutup --}}
                        <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                        </svg>
                    </button>
                </div>
                @error('password')
                    <span class="text-red-400 text-[11px] mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            {{-- Input Konfirmasi Password dengan Tombol Show/Hide --}}
            <div>
                <label class="block text-xs font-medium text-[#EDEDED] mb-2">Ulangi Password</label>
                <div class="relative flex items-center">
                    <input :type="showConfirmPassword ? 'text' : 'password'" 
                           name="password_confirmation" 
                           required 
                           class="bg-[#0B0909] border border-[#243733] text-[#EDEDED] text-xs rounded-lg focus:ring-[#3aafa9] focus:border-[#3aafa9] block w-full p-3 pr-10 outline-none transition" 
                           placeholder="********">
                    
                    <button type="button" 
                            @click="showConfirmPassword = !showConfirmPassword" 
                            class="absolute right-3 text-[#d1d5dc] hover:text-[#3aafa9] transition focus:outline-none cursor-pointer">
                        {{-- Icon Mata Terbuka --}}
                        <svg x-show="showConfirmPassword" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4" style="display: none;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                        {{-- Icon Mata Tertutup --}}
                        <svg x-show="!showConfirmPassword" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Pilihan Role --}}
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
                @error('id_roles')
                    <span class="text-red-400 text-[11px] mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <div class="pt-4">
                {{-- Tombol Simpan dengan validasi HTML5 sebelum memunculkan modal konfirmasi --}}
                <button @click="if ($refs.saveForm.checkValidity()) { openSaveModal = true; } else { $refs.saveForm.reportValidity(); }" type="button" class="bg-[#C4C4FA] text-[#0B0909] font-semibold text-xs px-6 py-2.5 rounded-lg hover:bg-[#b0b0f7] transition cursor-pointer">
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