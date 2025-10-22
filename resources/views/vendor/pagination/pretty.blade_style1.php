@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination" class="inline-flex items-center gap-2">
        {{-- Texto “Mostrando …” opcional (oculto en xs) --}}
        <span class="hidden sm:inline text-sm text-gray-500">
            Mostrando
            <span class="font-semibold">{{ $paginator->firstItem() ?? 0 }}</span>
            a
            <span class="font-semibold">{{ $paginator->lastItem() ?? 0 }}</span>
            de
            <span class="font-semibold">{{ $paginator->total() }}</span>
            registros
        </span>

        <ul class="flex items-center gap-1 bg-white border border-gray-200 rounded-2xl p-1 shadow-sm">
            {{-- Prev --}}
            @if ($paginator->onFirstPage())
                <li>
                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl text-gray-300"
                          aria-disabled="true" aria-label="@lang('pagination.previous')">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M15.41 7.41 14 6l-6 6 6 6 1.41-1.41L10.83 12z"/></svg>
                    </span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                       class="inline-flex h-9 w-9 items-center justify-center rounded-xl text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                       aria-label="@lang('pagination.previous')">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M15.41 7.41 14 6l-6 6 6 6 1.41-1.41L10.83 12z"/></svg>
                    </a>
                </li>
            @endif

            {{-- Números --}}
            @foreach ($elements as $element)
                {{-- … --}}
                @if (is_string($element))
                    <li>
                        <span class="inline-flex h-9 min-w-9 items-center justify-center px-2 rounded-xl text-gray-400 select-none">…</span>
                    </li>
                @endif

                {{-- Links de páginas --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li>
                                <span aria-current="page"
                                      class="inline-flex h-9 min-w-9 items-center justify-center px-3 rounded-xl text-white bg-indigo-600 shadow-sm font-semibold">
                                    {{ $page }}
                                </span>
                            </li>
                        @else
                            <li>
                                <a href="{{ $url }}"
                                   class="inline-flex h-9 min-w-9 items-center justify-center px-3 rounded-xl text-gray-700 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                    {{ $page }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                       class="inline-flex h-9 w-9 items-center justify-center rounded-xl text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                       aria-label="@lang('pagination.next')">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="m10 6 1.41 1.41L8.83 10H20v2H8.83l2.58 2.59L10 16l-6-6z"/></svg>
                    </a>
                </li>
            @else
                <li>
                    <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl text-gray-300"
                          aria-disabled="true" aria-label="@lang('pagination.next')">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="m10 6 1.41 1.41L8.83 10H20v2H8.83l2.58 2.59L10 16l-6-6z"/></svg>
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif
