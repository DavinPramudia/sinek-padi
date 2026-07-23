<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Sinek Padi - Form Petugas' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#0B0909] text-[#ededed] font-sans antialiased">
    <x-header-petugas></x-header-petugas>

    <main class="max-w-7xl mx-auto px-4 py-5 space-y-6">
        {{ $slot }}
    </main>

    @stack('scripts')
</body>
</html>