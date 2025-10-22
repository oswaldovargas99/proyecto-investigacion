<!-- resources/views/administrador/posgrados/show.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="mt-6 sm:mt-24 text-xl font-semibold text-gray-800 leading-tight">
            Detalle del Posgrado
        </h2>
    </x-slot>

    @php
        $nombre      = $posgrado->nombre_posgrado ?? 'Posgrado';
        $claveSnp    = $posgrado->clave_snp ?? '—';
        $centroName  = optional($posgrado->centroUniversitario)->centro_universitario;
        $nivel       = $posgrado->nivel_academico_nombre ?? $posgrado->nivel_academico ?? '';
        $modalidad   = $posgrado->modalidad_nombre ?? $posgrado->modalidad ?? '';
        $orientacion = $posgrado->orientacion_posgrado ?? '';

        // Iniciales para el avatar (primeras letras de las dos primeras palabras)
        $parts = preg_split('/\s+/', trim($nombre));
        $initials = strtoupper(mb_substr($parts[0] ?? 'P', 0, 1) . mb_substr($parts[1] ?? 'G', 0, 1));

        // Colores por modalidad/nivel (suaves, consistentes con módulos previos)
        $modalidadColor = [
            'Escolarizada' => ['bg'=>'bg-sky-50','text'=>'text-sky-700','ring'=>'ring-sky-200'],
            'Mixta'        => ['bg'=>'bg-amber-50','text'=>'text-amber-700','ring'=>'ring-amber-200'],
            'No escolarizada' => ['bg'=>'bg-violet-50','text'=>'text-violet-700','ring'=>'ring-violet-200'],
        ][$modalidad] ?? ['bg'=>'bg-gray-100','text'=>'text-gray-700','ring'=>'ring-gray-200'];

        $nivelColor = [
            'Especialidad' => ['bg'=>'bg-emerald-50','text'=>'text-emerald-700','ring'=>'ring-emerald-200'],
            'Maestría'     => ['bg'=>'bg-indigo-50','text'=>'text-indigo-700','ring'=>'ring-indigo-200'],
            'Doctorado'    => ['bg'=>'bg-fuchsia-50','text'=>'text-fuchsia-700','ring'=>'ring-fuchsia-200'],
        ][$nivel] ?? ['bg'=>'bg-gray-100','text'=>'text-gray-700','ring'=>'ring-gray-200'];
    @endphp

    <div class="py-6">
        <div class="mx-auto max-w-6xl px-4 space-y-6">

            {{-- Tarjeta de encabezado --}}
            <div class="flex items-center justify-between rounded-2xl border bg-white px-5 py-4 shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-indigo-100 text-indigo-700">
                        <span class="text-sm font-semibold">{{ $initials }}</span>
                    </div>
                    <div>
                        <h3 class="text-base sm:text-lg font-semibold text-gray-900">{{ $nombre }}</h3>
                        <div class="mt-1 flex flex-wrap items-center gap-2">
                            <span class="inline-flex items-center rounded-md px-2 py-0.5 text-xs font-semibold bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-200">
                                Clave SNP: {{ $claveSnp }}
                            </span>
                            @if($nivel)
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium ring-1 ring-inset {{ $nivelColor['bg'] }} {{ $nivelColor['text'] }} {{ $nivelColor['ring'] }}">
                                    {{ $nivel }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.posgrados.edit', $posgrado) }}"
                       class="inline-flex items-center gap-2 rounded-lg bg-yellow-500 px-3 py-2 text-sm font-semibold text-white hover:bg-yellow-600">
                        <!-- pencil -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 -ms-0.5" viewBox="0 0 24 24" fill="currentColor"><path d="m3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a1.004 1.004 0 0 0 0-1.42l-2.34-2.34a1.004 1.004 0 0 0-1.42 0l-1.83 1.83 3.75 3.75 1.84-1.82z"/></svg>
                        <span>Editar</span>
                    </a>
                    <a href="{{ route('admin.posgrados.index') }}"
                       class="inline-flex items-center gap-2 rounded-lg bg-gray-800 px-3 py-2 text-sm font-semibold text-white hover:bg-gray-900">
                        <!-- back -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 -ms-0.5" viewBox="0 0 24 24" fill="currentColor"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2Z"/></svg>
                        <span>Regresar</span>
                    </a>
                </div>
            </div>

            {{-- Cuerpo en tarjetas --}}
            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                {{-- Identidad --}}
                <section class="rounded-2xl border bg-white p-5 shadow-sm">
                    <header class="mb-4 flex items-center gap-3">
                        <div class="h-9 w-9 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center">
                            <!-- book -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2H8C6.9 2 6 2.9 6 4v15a3 3 0 0 1 3-3h10V4a2 2 0 0 0-1-1.73zM9 18c-1.1 0-2 .9-2 2s.9 2 2 2h10v-4H9z"/></svg>
                        </div>
                        <h3 class="text-base font-semibold text-gray-800">Identidad</h3>
                    </header>

                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Clave SNP</span>
                            <span class="inline-flex items-center rounded-md px-2 py-0.5 text-xs font-semibold bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-200">
                                {{ $claveSnp }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Modalidad</span>
                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium ring-1 ring-inset {{ $modalidadColor['bg'] }} {{ $modalidadColor['text'] }} {{ $modalidadColor['ring'] }}">
                                {{ $modalidad ?: '—' }}
                            </span>
                        </div>

                        <div>
                            <p class="text-xs uppercase tracking-wide text-gray-500">Orientación</p>
                            <p class="mt-1 text-sm font-medium text-gray-900">{{ $orientacion ?: '—' }}</p>
                        </div>
                    </div>
                </section>

                {{-- Académico / Adscripción --}}
                <section class="rounded-2xl border bg-white p-5 shadow-sm">
                    <header class="mb-4 flex items-center gap-3">
                        <div class="h-9 w-9 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center">
                            <!-- mortarboard -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M12 3 1 9l11 6 9-4.91V17h2V9L12 3zm0 10.2L4.24 9 12 5.8 19.76 9 12 13.2zM7 12v4c0 2 3 3 5 3s5-1 5-3v-4l-5 2.8L7 12z"/></svg>
                        </div>
                        <h3 class="text-base font-semibold text-gray-800">Académico</h3>
                    </header>

                    <div class="grid grid-cols-1 gap-4">
                        <div class="rounded-xl border bg-gray-50 px-4 py-3">
                            <p class="text-[11px] font-semibold tracking-wider text-gray-500">CENTRO UNIVERSITARIO</p>
                            <p class="mt-1 text-sm text-gray-800">{{ $centroName ?: '—' }}</p>
                        </div>

                        <div class="rounded-xl border bg-gray-50 px-4 py-3">
                            <p class="text-[11px] font-semibold tracking-wider text-gray-500">NIVEL ACADÉMICO</p>
                            <p class="mt-1">
                                @if($nivel)
                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium ring-1 ring-inset {{ $nivelColor['bg'] }} {{ $nivelColor['text'] }} {{ $nivelColor['ring'] }}">
                                        {{ $nivel }}
                                    </span>
                                @else
                                    <span class="text-sm text-gray-800">—</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </section>
            </div>

            {{-- Metadatos --}}
            <section class="rounded-2xl border bg-white p-5 shadow-sm">
                <header class="mb-4 flex items-center gap-3">
                    <div class="h-9 w-9 rounded-full bg-amber-100 text-amber-700 flex items-center justify-center">
                        <!-- clock -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2a10 10 0 1 0 .001 20.001A10 10 0 0 0 12 2zm1 11h5v-2h-4V7h-2v6z"/></svg>
                    </div>
                    <h3 class="text-base font-semibold text-gray-800">Metadatos</h3>
                </header>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                    <div class="rounded-xl border bg-gray-50 px-4 py-3">
                        <p class="text-[11px] font-semibold tracking-wider text-gray-500">CREADO EL</p>
                        <p class="mt-1 text-sm font-medium text-gray-900">{{ optional($posgrado->created_at)->format('d/m/Y H:i') ?? '—' }}</p>
                    </div>
                    <div class="rounded-xl border bg-gray-50 px-4 py-3">
                        <p class="text-[11px] font-semibold tracking-wider text-gray-500">ACTUALIZADO EL</p>
                        <p class="mt-1 text-sm font-medium text-gray-900">{{ optional($posgrado->updated_at)->format('d/m/Y H:i') ?? '—' }}</p>
                    </div>
                    <div class="rounded-xl border bg-gray-50 px-4 py-3">
                        <p class="text-[11px] font-semibold tracking-wider text-gray-500">ID</p>
                        <p class="mt-1 text-sm font-medium text-gray-900">#{{ $posgrado->id }}</p>
                    </div>
                </div>
            </section>

        </div>
    </div>
</x-app-layout>
