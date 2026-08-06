@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-center gap-2">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="px-4 py-2 text-sm font-medium text-gray-400 dark:text-gray-600 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl cursor-not-allowed">
                قبلی
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl hover:bg-blue-50 dark:hover:bg-gray-700 hover:border-blue-400 dark:hover:border-blue-500 transition-all">
                قبلی
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="px-4 py-2 text-sm font-medium text-gray-400 dark:text-gray-600">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="px-4 py-2 text-sm font-bold text-white bg-blue-600 dark:bg-blue-500 border border-blue-600 dark:border-blue-500 rounded-xl shadow-lg">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl hover:bg-blue-50 dark:hover:bg-gray-700 hover:border-blue-400 dark:hover:border-blue-500 transition-all">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl hover:bg-blue-50 dark:hover:bg-gray-700 hover:border-blue-400 dark:hover:border-blue-500 transition-all">
                بعدی
            </a>
        @else
            <span class="px-4 py-2 text-sm font-medium text-gray-400 dark:text-gray-600 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl cursor-not-allowed">
                بعدی
            </span>
        @endif
    </nav>
@endif
