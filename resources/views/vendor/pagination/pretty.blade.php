{{-- resources/views/vendor/pagination/pretty.blade.php --}}
@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination" class="w-full">
        {{-- Compacto para móviles --}}
        <div class="flex items-center justify-between sm:hidden mt-4">
            {{-- Botón anterior --}}
            @if ($paginator->onFirstPage())
                <span class="px-4 py-2 rounded-full bg-gray-100 text-gray-400 text-sm font-medium select-none">
                    ← Anterior
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                   class="px-4 py-2 rounded-full bg-white text-gray-700 text-sm font-medium border border-gray-200 shadow-sm hover:bg-blue-50 hover:text-blue-600 transition-all duration-150">
                    ← Anterior
                </a>
            @endif

            {{-- Botón siguiente --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                   class="px-4 py-2 rounded-full bg-white text-gray-700 text-sm font-medium border border-gray-200 shadow-sm hover:bg-blue-50 hover:text-blue-600 transition-all duration-150">
                    Siguiente →
                </a>
            @else
                <span class="px-4 py-2 rounded-full bg-gray-100 text-gray-400 text-sm font-medium select-none">
                    Siguiente →
                </span>
            @endif
        </div>

        {{-- Completo en pantallas grandes --}}
        <div class="hidden sm:flex sm:items-center sm:justify-center mt-4">
            <ul class="flex items-center gap-2 bg-white border border-gray-200 rounded-full shadow-sm px-2 py-1">
                {{-- Botón anterior --}}
                @if ($paginator->onFirstPage())
                    <li>
                        <span class="inline-flex items-center justify-center h-9 w-9 text-gray-400 select-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M15.41 16.59 10.83 12l4.58-4.59L14 6l-6 6 6 6z"/></svg>
                        </span>
                    </li>
                @else
                    <li>
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                           class="inline-flex items-center justify-center h-9 w-9 rounded-full text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition-all duration-150 focus:ring-2 focus:ring-blue-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M15.41 16.59 10.83 12l4.58-4.59L14 6l-6 6 6 6z"/></svg>
                        </a>
                    </li>
                @endif

                {{-- Números --}}
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <li>
                            <span class="inline-flex items-center justify-center h-9 w-9 text-gray-400 select-none">…</span>
                        </li>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li>
                                    <span aria-current="page"
                                          class="inline-flex items-center justify-center h-9 w-9 rounded-full bg-blue-600 text-white font-semibold shadow-md transform scale-105 transition-all duration-150">
                                        {{ $page }}
                                    </span>
                                </li>
                            @else
                                <li>
                                    <a href="{{ $url }}"
                                       class="inline-flex items-center justify-center h-9 w-9 rounded-full text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition-all duration-150 focus:ring-2 focus:ring-blue-400">
                                        {{ $page }}
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Botón siguiente --}}
                @if ($paginator->hasMorePages())
                    <li>
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                           class="inline-flex items-center justify-center h-9 w-9 rounded-full text-gray-600 hover:text-blue-600 hover:bg-blue-50 transition-all duration-150 focus:ring-2 focus:ring-blue-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="m10 6 6 6-6 6-1.41-1.41L13.17 12l-4.58-4.59L10 6z"/></svg>
                        </a>
                    </li>
                @else
                    <li>
                        <span class="inline-flex items-center justify-center h-9 w-9 text-gray-400 select-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="m10 6 6 6-6 6-1.41-1.41L13.17 12l-4.58-4.59L10 6z"/></svg>
                        </span>
                    </li>
                @endif
            </ul>
        </div>
    </nav>
@endif
