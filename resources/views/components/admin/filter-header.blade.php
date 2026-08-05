@props(['routeAction'])

<form method="GET" action="{{ $routeAction }}" class="flex flex-wrap items-center gap-2 bg-[#141c1a] border border-[#243733] p-2 rounded-xl">
    
    <!-- Pilihan Mode Filter -->
    <div class="flex items-center space-x-1 bg-[#0B0909] border border-[#243733] rounded-lg px-3 py-1.5">
        <span class="text-xs text-[#d1d5dc]">Mode:</span>
        <select name="filter_type" id="filterType" onchange="changeFilterInput()" class="bg-transparent text-[#EDEDED] text-xs font-semibold focus:outline-none cursor-pointer">
            {{-- Default diset ke 'harian' jika belum ada request --}}
            <option value="harian" {{ (request('filter_type', 'harian') == 'harian') ? 'selected' : '' }} class="bg-[#0B0909]">Harian</option>
            <option value="bulanan" {{ (request('filter_type') == 'bulanan') ? 'selected' : '' }} class="bg-[#0B0909]">Bulanan</option>
            <option value="tahunan" {{ (request('filter_type') == 'tahunan') ? 'selected' : '' }} class="bg-[#0B0909]">Tahunan</option>
            <option value="triwulanan" {{ (request('filter_type') == 'triwulanan') ? 'selected' : '' }} class="bg-[#0B0909]">Triwulanan</option>
        </select>
    </div>

    <!-- 1. Input Harian (Tampil secara default jika mode harian) -->
    <div id="wrapperHarian" class="filter-input-wrapper relative flex items-center {{ (request('filter_type', 'harian') == 'harian') ? '' : 'hidden' }}">
        <span onclick="document.getElementById('inputHarian').showPicker()" class="absolute left-2.5 text-[#d1d5dc] cursor-pointer flex items-center hover:text-white transition">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" /></svg>
        </span>
        <input type="date" id="inputHarian" name="tanggal" value="{{ request('tanggal', date('Y-m-d')) }}" class="bg-[#0B0909] border border-[#243733] text-[#EDEDED] text-xs rounded-lg pl-8 pr-2.5 py-1.5 focus:outline-none w-36">
    </div>

    <!-- 2. Input Bulanan -->
    <div id="wrapperBulanan" class="filter-input-wrapper relative flex items-center {{ (request('filter_type') == 'bulanan') ? '' : 'hidden' }}">
        <span onclick="document.getElementById('inputBulanan').showPicker()" class="absolute left-2.5 text-[#d1d5dc] cursor-pointer flex items-center hover:text-white transition">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" /></svg>
        </span>
        <input type="month" id="inputBulanan" name="bulan" value="{{ request('bulan', date('Y-m')) }}" class="bg-[#0B0909] border border-[#243733] text-[#EDEDED] text-xs rounded-lg pl-8 pr-2.5 py-1.5 focus:outline-none w-36">
    </div>

    <!-- 3. Input Tahunan -->
    <div id="wrapperTahunan" class="filter-input-wrapper relative flex items-center {{ (request('filter_type') == 'tahunan') ? '' : 'hidden' }}">
        <span class="absolute left-2.5 text-[#d1d5dc] pointer-events-none flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" /></svg>
        </span>
        <input type="text" name="tahun" maxlength="4" placeholder="YYYY" value="{{ request('tahun', date('Y')) }}" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="bg-[#0B0909] border border-[#243733] text-[#EDEDED] text-xs rounded-lg pl-8 pr-2.5 py-1.5 focus:outline-none w-36">
    </div>

    <!-- 4. Input Triwulanan -->
    <div id="wrapperTriwulanan" class="filter-input-wrapper relative flex items-center {{ (request('filter_type') == 'triwulanan') ? '' : 'hidden' }} gap-1">
        <div class="relative flex items-center">
            <select name="triwulan" class="bg-[#0B0909] border border-[#243733] text-[#EDEDED] text-xs rounded-lg px-2.5 py-1.5 focus:outline-none cursor-pointer">
                <option value="1" {{ request('triwulan') == '1' ? 'selected' : '' }}>Tribulan 1</option>
                <option value="2" {{ request('triwulan') == '2' ? 'selected' : '' }}>Tribulan 2</option>
                <option value="3" {{ request('triwulan') == '3' ? 'selected' : '' }}>Tribulan 3</option>
                <option value="4" {{ request('triwulan') == '4' ? 'selected' : '' }}>Tribulan 4</option>
            </select>
        </div>
        <div class="relative flex items-center">
            <select name="tahun_triwulan" class="bg-[#0B0909] border border-[#243733] text-[#EDEDED] text-xs rounded-lg px-2.5 py-1.5 focus:outline-none cursor-pointer">
                @for($y = date('Y'); $y >= 2024; $y--)
                    <option value="{{ $y }}" {{ request('tahun_triwulan', date('Y')) == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endfor
            </select>
        </div>
    </div>

    <!-- Tombol Submit -->
    <button type="submit" class="bg-[#3aafa9] hover:bg-[#2b8a85] text-white text-xs font-semibold px-3 py-1.5 rounded-lg transition">
        Filter
    </button>
</form>