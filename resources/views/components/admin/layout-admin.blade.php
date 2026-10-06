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
<body class="bg-[#0B0909] text-[#EDEDED] antialiased">

    <!-- 1. Sidebar di Kiri (Dibuat fixed agar tetap diam saat halaman di-scroll) -->
    <div class="fixed inset-y-0 left-0 z-40">
        <x-admin.sidebar-admin></x-admin.sidebar-admin>
    </div>

    <!-- 2. Konten Kanan (Diberi margin-left seluas lebar sidebar, misal ml-64) -->
    <div class="ml-64 flex flex-col min-h-screen">
        
        <!-- Header Admin (Otomatis sticky mengikuti scroll body seperti petugas) -->
        <x-admin.header-admin :title="$title ?? 'Dashboard'"></x-admin.header-admin>

        <!-- Konten Utama Halaman -->
        <main class="flex-1 p-8">
            {{ $slot }}
        </main>

    </div>

    <!-- STACK & SCRIPTS -->
    @stack('scripts')
    <script src="{{ asset('resources/js/filter-laporan.js') }}"></script>

</body>
</html>