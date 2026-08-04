<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard Admin - Sinek Padi' }}</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#0B0909] text-[#EDEDED] flex h-screen overflow-hidden">

    <!-- Memanggil Komponen Sidebar -->
    <x-admin.sidebar-admin></x-admin.sidebar-admin>

    <!-- Konten Kanan (Header & Main Slot) -->
    <div class="flex-1 flex flex-col h-full overflow-hidden">
        
        <!-- Memanggil Komponen Header -->
        <x-admin.header-admin :title="$title ?? 'Dashboard'"></x-admin.header-admin>

        <!-- Konten Utama Halaman -->
        <main class="flex-1 p-8 overflow-y-auto">
            {{ $slot }}
        </main>

    </div>

    <!-- STACK UNTUK MENANGKAP SCRIPT DARI HALAMAN ANAK -->
    @stack('scripts')

    <!-- TAMBAHKAN PEMANGGILAN SCRIPT FILTER DI SINI -->
    <script src="{{ asset('resources/js/filter-laporan.js') }}"></script>

</body>
</html>