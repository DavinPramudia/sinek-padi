@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
        <div class="flex justify-between flex-1 sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="relative inline-flex items-center px-4 py-2 text-xs font-medium text-gray-500 bg-[#141c1a] border border-[#243733] cursor-default rounded-lg">
                    &laquo; Previous
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-xs font-medium text-[#d1d5dc] bg-[#141c1a] border border-[#243733] rounded-lg hover:bg-[#243733] transition">
                    &laquo; Previous
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 ml-3 text-xs font-medium text-[#d1d5dc] bg-[#141c1a] border border-[#243733] rounded-lg hover:bg-[#243733] transition">
                    Next &raquo;
                </a>
            @else
                <span class="relative inline-flex items-center px-4 py-2 ml-3 text-xs font-medium text-gray-500 bg-[#141c1a] border border-[#243733] cursor-default rounded-lg">
                    Next &raquo;
                </span>
            @endif
        </div>

        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-xs text-[#d1d5dc]">
                    Menampilkan
                    <span class="font-semibold text-white">{{ $paginator->firstItem() }}</span>
                    sampai
                    <span class="font-semibold text-white">{{ $paginator->lastItem() }}</span>
                    dari
                    <span class="font-semibold text-white">{{ $paginator->total() }}</span>
                    data
                </p>
            </div>

            <div>
                <span class="relative z-0 inline-flex shadow-sm rounded-lg space-x-1">
                    {{-- Tombol Previous --}}
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}" class="relative inline-flex items-center px-2 py-2 text-xs font-medium text-gray-600 bg-[#141c1a] border border-[#243733] cursor-default rounded-l-lg">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center px-2 py-2 text-xs font-medium text-[#d1d5dc] bg-[#141c1a] border border-[#243733] rounded-l-lg hover:bg-[#243733] transition" aria-label="{{ __('pagination.previous') }}">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        </a>
                    @endif

                    {{-- Elemen Nomor Halaman (Otomatis memotong jadi titik-titik ... jika sudah banyak/3 digit) --}}
                    @foreach ($elements as $element)
                        @if (is_string($element))
                            <span aria-disabled="true"><span class="relative inline-flex items-center px-4 py-2 text-xs font-medium text-gray-500 bg-[#141c1a] border border-[#243733]">{{ $element }}</span></span>
                        @endif

                       @if (is_array($element))
                            @foreach ($element as $page => $url)
                                {{-- Hanya tampilkan jika halaman aktif, atau 1 halaman sebelum & sesudahnya --}}
                                @if ($page == $paginator->currentPage() || $page == $paginator->currentPage() - 1 || $page == $paginator->currentPage() + 1)
                                    @if ($page == $paginator->currentPage())
                                        <span aria-current="page">
                                            <span class="relative inline-flex items-center px-3.5 py-2 text-xs font-semibold text-[#0B0909] bg-[#3aafa9] border border-[#3aafa9]">{{ $page }}</span>
                                        </span>
                                    @else
                                        <a href="{{ $url }}" class="relative inline-flex items-center px-3.5 py-2 text-xs font-medium text-[#d1d5dc] bg-[#141c1a] border border-[#243733] hover:bg-[#243733] transition">{{ $page }}</a>
                                    @endif
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Tombol Next --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="relative inline-flex items-center px-2 py-2 text-xs font-medium text-[#d1d5dc] bg-[#141c1a] border border-[#243733] rounded-r-lg hover:bg-[#243733] transition" aria-label="{{ __('pagination.next') }}">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                        </a>
                    @else
                        <span aria-disabled="true" aria-label="{{ __('pagination.next') }}" class="relative inline-flex items-center px-2 py-2 text-xs font-medium text-gray-600 bg-[#141c1a] border border-[#243733] cursor-default rounded-r-lg">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif