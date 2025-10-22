{{-- resources/views/vendor/pagination/pretty.blade.php --}}
@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination" class="w-full">
        {{-- Vista compacta en móviles: solo anterior / siguiente --}}
        <div class="flex items-center justify-between gap-3 sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="inline-flex items-center rounded-xl px-4 py-2 text-sm text-gray-400 bg-white border border-gray-200">
                    ← Anterior
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                   class="inline-flex items-center rounded-xl px-4 py-2 text-sm text-gray-700 bg-white border border-gray-200 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    ← Anterior
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                   class="inline-flex items-center rounded-xl px-4 py-2 text-sm text-gray-700 bg-white border border-gray-200 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    Siguiente →
                </a>
            @else
                <span class="inline-flex items-center rounded-xl px-4 py-2 text-sm text-gray-400 bg-white border border-gray-200">
                    Siguiente →
                </span>
            @endif
        </div>

        {{-- Vista completa desde sm en adelante --}}
        <div class="hidden sm:flex sm:items-center sm:justify-end sm:gap-3">
            <ul class="flex items-center gap-1 rounded-2xl border border-gray-200 bg-white p-1 shadow-sm">

                {{-- Primera página --}}
                @php $firstUrl = $paginator->url(1); @endphp
                @if ($paginator->onFirstPage())
                    <li>
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl text-gray-300"
                              aria-disabled="true" aria-label="Primera">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M18 6v12h-2V6h2zM8 6l-6 6 6 6 1.41-1.41L4.83 12l4.58-4.59L8 6z"/></svg>
                        </span>
                    </li>
                @else
                    <li>
                        <a href="{{ $firstUrl }}"
                           class="inline-flex h-9 w-9 items-center justify-center rounded-xl text-gray-600 hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                           aria-label="Primera">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M18 6v12h-2V6h2zM8 6l-6 6 6 6 1.41-1.41L4.83 12l4.58-4.59L8 6z"/></svg>
                        </a>
                    </li>
                @endif

                {{-- Anterior --}}
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
                           class="inline-flex h-9 w-9 items-center justify-center rounded-xl text-gray-600 hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                           aria-label="@lang('pagination.previous')">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M15.41 7.41 14 6l-6 6 6 6 1.41-1.41L10.83 12z"/></svg>
                        </a>
                    </li>
                @endif

                {{-- Números / elipsis --}}
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <li>
                            <span class="inline-flex h-9 min-w-9 items-center justify-center px-2 rounded-xl text-gray-400 select-none">…</span>
                        </li>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li>
                                    <span aria-current="page"
                                          class="inline-flex h-9 min-w-9 items-center justify-center px-3 rounded-xl text-sm font-semibold text-white
                                                 bg-gradient-to-r from-indigo-600 to-indigo-500 shadow-sm">
                                        {{ $page }}
                                    </span>
                                </li>
                            @else
                                <li>
                                    <a href="{{ $url }}"
                                       class="inline-flex h-9 min-w-9 items-center justify-center px-3 rounded-xl text-sm text-gray-700
                                              hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                        {{ $page }}
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Siguiente --}}
                @if ($paginator->hasMorePages())
                    <li>
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                           class="inline-flex h-9 w-9 items-center justify-center rounded-xl text-gray-600 hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500"
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

                {{-- Última página --}}
                @php $lastUrl = $paginator->url($paginator->lastPage()); @endphp
                @if ($paginator->currentPage() == $paginator->lastPage())
                    <li>
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-xl text-gray-300"
                              aria-disabled="true" aria-label="Última">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M6 6v12h2V6H6zm10 0 6 6-6 6-1.41-1.41L19.17 12l-4.58-4.59L16 6z"/></svg>
                        </span>
                    </li>
                @else
                    <li>
                        <a href="{{ $lastUrl }}"
                           class="inline-flex h-9 w-9 items-center justify-center rounded-xl text-gray-600 hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                           aria-label="Última">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M6 6v12h2V6H6zm10 0 6 6-6 6-1.41-1.41L19.17 12l-4.58-4.59L16 6z"/></svg>
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </nav>
@endif
