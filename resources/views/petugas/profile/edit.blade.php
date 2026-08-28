<x-layout title="Profil Saya - Sinek Padi">
    <div class="max-w-xl mx-auto w-full space-y-6 pt-4 pb-10" x-data="{ openSaveModal: false, activeForm: null }">
        
        <!-- TOMBOL KEMBALI -->
        <div>
            <a href="{{ route('petugas.loket') }}" class="text-xs text-[#3aafa9] hover:underline flex items-center gap-1 font-medium">
                &larr; Kembali ke Halaman Loket
            </a>
        </div>

        <!-- HEADER -->
        <div>
            <h1 class="text-2xl font-bold text-[#EDEDED]">Profil & Keamanan Akun</h1>
            <p class="text-sm text-[#d1d5dc] mt-1">Kelola informasi nama dan perbarui password akun kamu di sini.</p>
        </div>

        <!-- NOTIFIKASI SUKSES -->
        @if(session('success'))
            <div class="bg-emerald-900/50 border border-emerald-500 text-emerald-200 px-4 py-3 rounded-xl text-xs">
                {{ session('success') }}
            </div>
        @endif

        <!-- FORM UPDATE PROFIL (NAMA & PASSWORD) -->
        <form x-ref="saveForm" action="{{ route('profile.update') }}" method="POST" class="bg-[#141c1a] border border-[#243733] p-6 rounded-xl shadow-lg space-y-5">
            @csrf
            @method('PUT')

            <h2 class="text-lg font-semibold text-white">Informasi Akun</h2>

            <div>
                <label class="block text-xs font-medium text-[#EDEDED] mb-2">Username (Tidak dapat diubah)</label>
                <input type="text" value="{{ $user->username }}" disabled
                       class="w-full bg-[#0B0909] border border-[#243733] text-gray-500 text-xs rounded-lg p-3 cursor-not-allowed">
            </div>

            <div>
                <label class="block text-xs font-medium text-[#EDEDED] mb-2">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required 
                       class="bg-[#0B0909] border @error('name') border-red-500 @else border-[#243733] @enderror text-[#EDEDED] text-xs rounded-lg focus:ring-[#3aafa9] focus:border-[#3aafa9] block w-full p-3 outline-none">
                @error('name') <span class="text-xs text-red-400 mt-1 block">{{ $message }}</span> @enderror
            </div>

            <hr class="border-[#243733]">

            <h2 class="text-lg font-semibold text-white">Ganti Password</h2>

            <div>
                <label class="block text-xs font-medium text-[#EDEDED] mb-2">Password Lama</label>
                <input type="password" name="current_password" placeholder="Masukkan password saat ini" 
                       class="bg-[#0B0909] border @error('current_password') border-red-500 @else border-[#243733] @enderror text-[#EDEDED] text-xs rounded-lg focus:ring-[#3aafa9] focus:border-[#3aafa9] block w-full p-3 outline-none">
                @error('current_password') <span class="text-xs text-red-400 mt-1 block">{{ $message }}</span> @enderror
            </div>

            {{-- PASSWORD BARU --}}
            <div x-data="{ showPassword: false }">
                <label class="block text-xs font-medium text-[#EDEDED] mb-2">Password Baru <span class="text-gray-500 font-normal">(Kosongkan jika tidak ingin mengubah)</span></label>
                <div class="relative">
                    <input :type="showPassword ? 'text' : 'password'" name="password" placeholder="Minimal 6 karakter" 
                           class="bg-[#0B0909] border @error('password') border-red-500 @else border-[#243733] @enderror text-[#EDEDED] text-xs rounded-lg focus:ring-[#3aafa9] focus:border-[#3aafa9] block w-full p-3 pr-10 outline-none">
                    
                    <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-[#EDEDED] cursor-pointer">
                        {{-- SVG Mata Terbuka --}}
                        <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                          <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                        {{-- SVG Mata Dicoret --}}
                        <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                        </svg>
                    </button>
                </div>
                @error('password') <span class="text-xs text-red-400 mt-1 block">{{ $message }}</span> @enderror
            </div>

            {{-- KONFIRMASI PASSWORD BARU --}}
            <div x-data="{ showConfirmPassword: false }">
                <label class="block text-xs font-medium text-[#EDEDED] mb-2">Ulangi Password Baru</label>
                <div class="relative">
                    <input :type="showConfirmPassword ? 'text' : 'password'" name="password_confirmation" placeholder="Ulangi password baru" 
                           class="bg-[#0B0909] border border-[#243733] text-[#EDEDED] text-xs rounded-lg focus:ring-[#3aafa9] focus:border-[#3aafa9] block w-full p-3 pr-10 outline-none">
                    
                    <button type="button" @click="showConfirmPassword = !showConfirmPassword" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-[#EDEDED] cursor-pointer">
                        {{-- SVG Mata Terbuka --}}
                        <svg x-show="!showConfirmPassword" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                          <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                        {{-- SVG Mata Dicoret --}}
                        <svg x-show="showConfirmPassword" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="flex justify-end pt-2">
                <button @click="activeForm = $refs.saveForm; if (activeForm.checkValidity()) { openSaveModal = true; } else { activeForm.reportValidity(); }" type="button" class="bg-[#3aafa9] hover:bg-[#329691] text-[#0B0909] font-semibold text-xs px-6 py-2.5 rounded-lg transition cursor-pointer">
                    Simpan Perubahan
                </button>
            </div>
        </form>

        <x-admin.save-modal title="Konfirmasi Simpan">
            Apakah kamu yakin ingin menyimpan perubahan profil ini?
        </x-admin.save-modal>

    </div>
</x-layout>