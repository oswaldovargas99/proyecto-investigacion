<!-- resources/views/administrador/centros/show.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="mt-6 sm:mt-24 text-lg sm:text-xl font-semibold text-gray-800">
            Detalle del Centro Universitario
        </h2>
    </x-slot>

    @php
        $tipo    = $centro->tipo_centro_universitario ?? '';
        $vigente = (bool) ($centro->vigente ?? false);

        // Iniciales: usa siglas; si no hay, toma dos primeras letras del nombre
        $initials = $centro->siglas
            ? strtoupper(mb_substr($centro->siglas, 0, 2))
            : collect(preg_split('/\s+/', trim($centro->centro_universitario ?? 'CU')))
                ->take(2)->map(fn($p)=>mb_substr($p,0,1))->implode('');

        // Colores por tipo
        $map = [
            'Centro Universitario Metropolitano' => ['bg'=>'bg-indigo-50','text'=>'text-indigo-700','ring'=>'ring-indigo-200'],
            'Centro Universitario Regional'      => ['bg'=>'bg-emerald-50','text'=>'text-emerald-700','ring'=>'ring-emerald-200'],
        ];
        $c = $map[$tipo] ?? ['bg'=>'bg-gray-100','text'=>'text-gray-700','ring'=>'ring-gray-200'];
    @endphp

    <div class="py-6">
        <div class="mx-auto max-w-6xl px-4 space-y-6">

            {{-- Tarjeta de encabezado (debajo del header) --}}
            <div class="flex items-center justify-between rounded-2xl border bg-white px-5 py-4 shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-indigo-100 text-indigo-700">
                        <span class="text-sm font-semibold">{{ $centro->siglas }}</span>
                    </div>
                    <div>
                        <h3 class="text-base sm:text-lg font-semibold text-gray-900">
                            {{ $centro->centro_universitario }}
                        </h3>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.centros.edit', $centro) }}"
                       class="inline-flex items-center gap-2 rounded-lg bg-yellow-500 px-3 py-2 text-sm font-semibold text-white hover:bg-yellow-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 -ms-0.5" viewBox="0 0 24 24" fill="currentColor"><path d="m3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a1.004 1.004 0 0 0 0-1.42l-2.34-2.34a1.004 1.004 0 0 0-1.42 0l-1.83 1.83 3.75 3.75 1.84-1.82z"/></svg>
                        <span>Editar</span>
                    </a>
                    <a href="{{ route('admin.centros.index') }}"
                       class="inline-flex items-center gap-2 rounded-lg bg-gray-800 px-3 py-2 text-sm font-semibold text-white hover:bg-gray-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 -ms-0.5" viewBox="0 0 24 24" fill="currentColor"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2Z"/></svg>
                        <span>Regresar</span>
                    </a>
                </div>
            </div>

            {{-- Bloques principales --}}
            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                {{-- General --}}
                <section class="rounded-2xl border bg-white p-5 shadow-sm">
                    <header class="mb-4 flex items-center gap-3">
                        <div class="h-9 w-9 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center">

                        <!-- Icono tipo Universidad (edificio con columnas) -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 text-indigo-600">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M4 21h16M6 10V21M10 10V21M14 10V21M18 10V21M12 3l9 7H3l9-7z" />
                            </svg>

                        </div>
                        <h3 class="text-base font-semibold text-gray-800">General</h3>
                    </header>

                    <div>
                        <p class="text-xs uppercase tracking-wide text-gray-500">Rector(a)</p>
                        <p class="mt-1 text-sm font-medium text-gray-900">{{ $centro->nombre_rector ?: '—' }}</p>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-xs uppercase tracking-wide text-gray-500">Siglas</span>
                            <span class="inline-flex items-center rounded-md px-2 py-0.5 text-xs font-semibold
                                         bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-200">
                                {{ $centro->siglas }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-xs uppercase tracking-wide text-gray-500">Tipo de Centro</span>
                            <span class="inline-flex items-center rounded-md px-2 py-0.5 text-xs font-semibold
                                         bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-200">
                                {{ $tipo ?: '—' }}
                            </span>
                        </div>

                        <div>
                            <p class="text-xs uppercase tracking-wide text-gray-500">Teléfonos</p>
                            <p class="mt-1 text-sm text-gray-800">{{ $centro->telefonos ?: '—' }}</p>
                        </div>

                        <div>
                            <p class="text-xs uppercase tracking-wide text-gray-500">Sitio web</p>
                            <p class="mt-1 text-sm">
                                @if($centro->sitio_web)
                                    <a href="{{ $centro->sitio_web }}" target="_blank" rel="noopener"
                                       class="text-indigo-600 hover:text-indigo-800 underline decoration-dotted underline-offset-2">
                                        {{ $centro->sitio_web }}
                                    </a>
                                @else
                                    <span class="text-gray-500">—</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </section>

                {{-- Ubicación --}}
                <section class="rounded-2xl border bg-white p-5 shadow-sm">
                    <header class="mb-4 flex items-center gap-3">
                        <div class="h-9 w-9 rounded-full bg-sky-100 text-sky-700 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2a7 7 0 0 0-7 7c0 5.25 7 13 7 13s7-7.75 7-13a7 7 0 0 0-7-7zm0 9.5A2.5 2.5 0 1 1 12 6a2.5 2.5 0 0 1 0 5z"/></svg>
                        </div>
                        <h3 class="text-base font-semibold text-gray-800">Ubicación</h3>
                    </header>

                    <div class="grid grid-cols-1 gap-4">
                        <div class="rounded-xl border bg-gray-50 px-4 py-3">
                            <p class="text-[11px] font-semibold tracking-wider text-gray-500">DIRECCIÓN</p>
                            <p class="mt-1 text-sm text-gray-800">{{ $centro->direccion ?: '—' }}</p>
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                            <div class="rounded-xl border bg-gray-50 px-4 py-3">
                                <p class="text-[11px] font-semibold tracking-wider text-gray-500">COLONIA</p>
                                <p class="mt-1 text-sm text-gray-800">{{ $centro->colonia ?: '—' }}</p>
                            </div>
                            <div class="rounded-xl border bg-gray-50 px-4 py-3">
                                <p class="text-[11px] font-semibold tracking-wider text-gray-500">CÓDIGO POSTAL</p>
                                <p class="mt-1 text-sm text-gray-800">{{ $centro->codigo_postal ?: '—' }}</p>
                            </div>
                            <div class="rounded-xl border bg-gray-50 px-4 py-3">
                                <p class="text-[11px] font-semibold tracking-wider text-gray-500">MUNICIPIO</p>
                                <p class="mt-1 text-sm text-gray-800">{{ $centro->municipio ?: '—' }}</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div class="rounded-xl border bg-gray-50 px-4 py-3">
                                <p class="text-[11px] font-semibold tracking-wider text-gray-500">ESTADO</p>
                                <p class="mt-1 text-sm text-gray-800">{{ $centro->estado ?: '—' }}</p>
                            </div>
                            <div class="rounded-xl border bg-gray-50 px-4 py-3">
                                <p class="text-[11px] font-semibold tracking-wider text-gray-500">PAÍS</p>
                                <p class="mt-1 text-sm text-gray-800">{{ $centro->pais ?: '—' }}</p>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            {{-- Metadatos (sin botón inferior) --}}
            <section class="rounded-2xl border bg-white p-5 shadow-sm">
                <header class="mb-4 flex items-center gap-3">
                    <div class="h-9 w-9 rounded-full bg-amber-100 text-amber-700 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2a10 10 0 1 0 .001 20.001A10 10 0 0 0 12 2zm1 11h5v-2h-4V7h-2v6z"/></svg>
                    </div>
                    <h3 class="text-base font-semibold text-gray-800">Metadatos</h3>
                </header>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                    <div class="rounded-xl border bg-gray-50 px-4 py-3">
                        <p class="text-[11px] font-semibold tracking-wider text-gray-500">CREADO EL</p>
                        <p class="mt-1 text-sm text-gray-800">{{ optional($centro->created_at)->format('d/m/Y H:i') ?? '—' }}</p>
                    </div>
                    <div class="rounded-xl border bg-gray-50 px-4 py-3">
                        <p class="text-[11px] font-semibold tracking-wider text-gray-500">ACTUALIZADO EL</p>
                        <p class="mt-1 text-sm text-gray-800">{{ optional($centro->updated_at)->format('d/m/Y H:i') ?? '—' }}</p>
                    </div>

                    <div class="rounded-xl border bg-gray-50 px-4 py-3">
                        <p class="text-[11px] font-semibold tracking-wider text-gray-500">STATUS</p>

                            @if($vigente)
                                <span class="inline-flex items-center rounded-full bg-green-50 px-2.5 py-0.5 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-200">
                                    Activo
                                </span>
                            @else
                                <span class="inline-flex items-center rounded-full bg-red-50 px-2.5 py-0.5 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-200">
                                    Inactivo
                                </span>
                            @endif
                    </div>
                </div>
            </section>

        </div>
    </div>
</x-app-layout>
