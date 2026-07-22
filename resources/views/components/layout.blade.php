<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Sinek Padi - Form Petugas' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        input[type="number"] { -moz-appearance: textfield; }
    </style>
</head>

<body class="bg-[#0B0909] text-[#EDEDED] font-sans antialiased">

    <x-header-petugas></x-header-petugas>

    <main class="max-w-7xl mx-auto px-4 py-5 space-y-6">
        {{ $slot }}
    </main>

</body>
</html>