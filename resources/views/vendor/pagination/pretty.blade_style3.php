{{-- resources/views/vendor/pagination/pretty.blade.php --}}
@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination" class="w-full">

        {{-- Compacto en móviles: Anterior / Siguiente --}}
        <div class="flex items-center justify-between gap-3 sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="inline-flex items-center rounded-lg px-4 py-2 text-sm
                             bg-gray-100 text-gray-400 border border-gray-200 select-none">
                    ← Anterior
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                   class="inline-flex items-center rounded-lg px-4 py-2 text-sm
                          bg-white text-gray-700 border border-gray-200 hover:bg-gray-50
                          focus:outline-none focus:ring-2 focus:ring-blue-500">
                    ← Anterior
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                   class="inline-flex items-center rounded-lg px-4 py-2 text-sm
                          bg-white text-gray-700 border border-gray-200 hover:bg-gray-50
                          focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Siguiente →
                </a>
            @else
                <span class="inline-flex items-center rounded-lg px-4 py-2 text-sm
                             bg-gray-100 text-gray-400 border border-gray-200 select-none">
                    Siguiente →
                </span>
            @endif
        </div>

        {{-- Completo en ≥ sm --}}
        <div class="hidden sm:flex sm:items-center sm:justify-end">
            <ul class="flex items-center overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-sm">
                {{-- Primera --}}
                @php $firstUrl = $paginator->url(1); @endphp
                <li class="border-r border-gray-200">
                    @if ($paginator->onFirstPage())
                        <span class="inline-flex h-10 w-10 items-center justify-center text-gray-300 select-none">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M18 6v12h-2V6h2zM8 6l-6 6 6 6 1.41-1.41L4.83 12l4.58-4.59L8 6z"/></svg>
                        </span>
                    @else
                        <a href="{{ $firstUrl }}" class="inline-flex h-10 w-10 items-center justify-center
                                   text-gray-600 hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500"
                           aria-label="Primera">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M18 6v12h-2V6h2zM8 6l-6 6 6 6 1.41-1.41L4.83 12l4.58-4.59L8 6z"/></svg>
                        </a>
                    @endif
                </li>

                {{-- Anterior --}}
                <li class="border-r border-gray-200">
                    @if ($paginator->onFirstPage())
                        <span class="inline-flex h-10 w-10 items-center justify-center text-gray-300 select-none">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M15.41 7.41 14 6l-6 6 6 6 1.41-1.41L10.83 12z"/></svg>
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                           class="inline-flex h-10 w-10 items-center justify-center text-gray-600
                                  hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500"
                           aria-label="@lang('pagination.previous')">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M15.41 7.41 14 6l-6 6 6 6 1.41-1.41L10.83 12z"/></svg>
                        </a>
                    @endif
                </li>

                {{-- Números / elipsis --}}
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <li class="border-r border-gray-200">
                            <span class="inline-flex h-10 min-w-10 items-center justify-center px-3 text-gray-400 select-none">…</span>
                        </li>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            <li class="{{ $page != $paginator->currentPage() ? 'border-r border-gray-200' : '' }}">
                                @if ($page == $paginator->currentPage())
                                    <span aria-current="page"
                                          class="inline-flex h-10 min-w-10 items-center justify-center px-3 text-sm font-semibold
                                                 text-white bg-blue-600">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}"
                                       class="inline-flex h-10 min-w-10 items-center justify-center px-3 text-sm
                                              text-gray-700 hover:text-gray-900 hover:bg-gray-50
                                              focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        {{ $page }}
                                    </a>
                                @endif
                            </li>
                        @endforeach
                    @endif
                @endforeach

                {{-- Siguiente --}}
                <li class="border-l border-gray-200">
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                           class="inline-flex h-10 w-10 items-center justify-center text-gray-600
                                  hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500"
                           aria-label="@lang('pagination.next')">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="m10 6 1.41 1.41L8.83 10H20v2H8.83l2.58 2.59L10 16l-6-6z"/></svg>
                        </a>
                    @else
                        <span class="inline-flex h-10 w-10 items-center justify-center text-gray-300 select-none">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="m10 6 1.41 1.41L8.83 10H20v2H8.83l2.58 2.59L10 16l-6-6z"/></svg>
                        </span>
                    @endif
                </li>

                {{-- Última --}}
                @php $lastUrl = $paginator->url($paginator->lastPage()); @endphp
                <li>
                    @if ($paginator->currentPage() == $paginator->lastPage())
                        <span class="inline-flex h-10 w-10 items-center justify-center text-gray-300 select-none">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M6 6v12h2V6H6zm10 0 6 6-6 6-1.41-1.41L19.17 12l-4.58-4.59L16 6z"/></svg>
                        </span>
                    @else
                        <a href="{{ $lastUrl }}"
                           class="inline-flex h-10 w-10 items-center justify-center text-gray-600
                                  hover:text-gray-900 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500"
                           aria-label="Última">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M6 6v12h2V6H6zm10 0 6 6-6 6-1.41-1.41L19.17 12l-4.58-4.59L16 6z"/></svg>
                        </a>
                    @endif
                </li>
            </ul>
        </div>
    </nav>
@endif
