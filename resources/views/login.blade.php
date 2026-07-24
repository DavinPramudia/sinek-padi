<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">      
    <title>Login Petugas - Sinek Padi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-[#0B0909] text-[#ededed] font-sans antialiased h-full flex items-center justify-center p-4">

    <div class="w-full max-w-5xl grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
        
        {{-- SISI KIRI: Branding / Info --}} 
        <div class="space-y-6 p-6">
            {{-- Logo di Kiri --}}
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-[#2E4540] border border-[#3b5952] rounded-xl flex items-center justify-center overflow-hidden p-1">
                    <img src="{{ asset('assets/images/logo-pemkot.png') }}" alt="Logo Instansi" class="w-full h-full object-contain">
                </div>
                <span class="text-xs uppercase tracking-wider text-[#d1d5dc] font-semibold">Pemerintah Kota Pangkal Pinang</span>
            </div>

            <div class="space-y-3">
                <h1 class="text-4xl md:text-4xl font-extrabold text-white leading-tight">
                    Sistem Informasi Loket Retribusi & Pendataan Wisatawan
                </h1>
                <p class="text-base text-[#d1d5dc] leading-relaxed">
                    Kawasan Pariwisata Pantai Pasir Padi. Silakan masuk menggunakan akun resmi petugas untuk mulai mengelola transaksi harian.
                </p>
            </div>
        </div>

        {{-- SISI KANAN: Card Form Login --}}
        <div class="w-full">
            <div class="bg-[#2E4540] rounded-3xl p-8 shadow-xl border border-[#3b5952] space-y-6">
                
                {{-- Logo Sinek Padi (Tanpa Kotak) --}}
                <div class="text-center space-y-2">
                    <div class="flex justify-center mb-2">
                        <img src="{{ asset('assets/images/logo-sinek-padi.png') }}" alt="Logo Sinek Padi" class="h-28 object-contain">
                    </div>
                    <p class="text-sm text-[#d1d5dc]">Silakan masuk menggunakan akun resmi Anda</p>
                </div>

                {{-- Form Login --}}
                {{-- <form action="{{ route('login.process') }}" method="POST" class="space-y-4">
                    @csrf --}}

                    {{-- Input Username --}}
                    <div class="space-y-1">
                        <label class="block text-sm font-semibold text-[#d1d5dc]">Username / Email</label>
                        <div class="relative flex items-center">
                            
                            <span class="absolute left-3 text-[#d1d5dc] pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                </svg>
                            </span>

                            <input type="text" name="email" required 
                                class="w-full bg-[#1C2B28] border border-[#3b5952] rounded-xl pl-10 pr-4 py-3 text-sm text-[#ededed] focus:outline-none focus:border-[#3aafa9] transition">
                        </div>
                    </div>

                    {{-- Input Password --}}
                    <div x-data="{ showPassword: false }" class="space-y-1">
                        <label class="block text-sm font-semibold text-[#d1d5dc]">Password</label>
                        <div class="relative flex items-center">
                            
                            <span class="absolute left-3 text-[#d1d5dc] pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1 1 21.75 8.25Z" />
                                </svg>
                            </span>

                            <input :type="showPassword ? 'text' : 'password'" 
                                name="password" 
                                required 
                                class="w-full bg-[#1C2B28] border border-[#3b5952] rounded-xl pl-10 pr-11 py-3 text-sm text-[#ededed] focus:outline-none focus:border-[#3aafa9] transition">
                            
                            <button type="button" 
                                    @click="showPassword = !showPassword" 
                                    class="absolute right-3 text-[#d1d5dc] hover:text-[#3aafa9] transition focus:outline-none p-1">
                                
                                <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>

                                <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Tombol Masuk --}}
                    <button type="submit" class="w-full bg-[#408175] hover:bg-[#3aafa9] text-white font-bold py-3.5 rounded-xl shadow-lg transition duration-150 flex items-center justify-center space-x-2 active:scale-95 cursor-pointer mt-2">
                        <span>Masuk ke Sistem</span>
                    </button>
                </form>

                {{-- Footer Info --}}
                <div class="text-center pt-2 border-t border-[#3b5952]">
                    <span class="text-xs text-[#d1d5dc]">© 2026 Sinek Padi. All Right Reserved</span>
                </div>

            </div>
        </div>

    </div>

</body>
</html>