<!-- resources/views/administrador/rubros/show.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="mt-6 sm:mt-24 text-xl font-semibold text-gray-800 leading-tight">
            Detalle del Rubro
        </h2>
    </x-slot>

    @php
        // Iniciales con el código de rubro (sin usar Str)
        $codigo     = trim($rubro->rubro ?? '');
        $compacto   = preg_replace('/\s+/', '', (string)$codigo);
        $iniciales  = $compacto ? mb_strtoupper(mb_substr($compacto, 0, 2), 'UTF-8') : 'R';

        // Fechas
        $creado    = $rubro->created_at ? $rubro->created_at->format('d/m/Y H:i') : null;
        $actualizado = $rubro->updated_at ? $rubro->updated_at->format('d/m/Y H:i') : null;

        // Categoría (usa la relación cargada en el controlador)
        $categoriaNombre = optional($rubro->categoria)->categoria;
    @endphp

    <div class="py-8 px-4 max-w-5xl mx-auto space-y-6">

        <!-- Header Card -->
        <div class="bg-white rounded-2xl shadow-sm border p-6">
            <div class="flex items-center gap-4">
                <div class="h-14 w-14 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-semibold text-lg">
                    {{ $iniciales }}
                </div>
                <div class="min-w-0">
                    <h3 class="text-lg font-semibold text-gray-800 truncate">
                        Rubro {{ $rubro->rubro }}
                    </h3>
                    <p class="text-sm text-gray-500 truncate">
                        Concepto: <span class="font-medium text-gray-700">{{ $rubro->concepto }}</span>
                    </p>
                </div>

                <div class="ms-auto flex items-center gap-2">
                    @if(isset($rubro->id))
                        <a href="{{ route('admin.rubros.edit', $rubro->id) }}"
                           class="inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-yellow-500 text-white text-sm hover:bg-yellow-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M5 21h14v-2H5v2Zm13.71-14.29-1.42-1.42a1 1 0 0 0-1.41 0L6 13.17V16h2.83l9.88-9.88a1 1 0 0 0 0-1.41Z"/>
                            </svg>
                            Editar
                        </a>
                    @endif

                    <a href="{{ route('admin.rubros.index') }}"
                       class="inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-gray-700 text-white text-sm hover:bg-gray-800">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2Z"/>
                        </svg>
                        Regresar
                    </a>
                </div>
            </div>
        </div>

        <!-- Content Cards -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Información básica -->
            <section class="bg-white rounded-2xl shadow-sm border p-6">
                <header class="mb-4 flex items-center gap-2">
                    <div class="h-8 w-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5Zm0 2c-5 0-9 2.5-9 5.5V22h18v-2.5C21 16.5 17 14 12 14Z"/>
                        </svg>
                    </div>
                    <h4 class="font-semibold text-gray-800">Información</h4>
                </header>

                <dl class="space-y-3">
                    <div class="flex justify-between gap-4">
                        <dt class="text-sm text-gray-500">Rubro</dt>
                        <dd class="text-sm">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-100">
                                {{ $rubro->rubro }}
                            </span>
                        </dd>
                    </div>

                    <div class="flex justify-between gap-4">
                        <dt class="text-sm text-gray-500">Concepto</dt>
                        <dd class="text-sm text-gray-800 text-right">{{ $rubro->concepto }}</dd>
                    </div>
                </dl>
            </section>

            <!-- Clasificación -->
            <section class="bg-white rounded-2xl shadow-sm border p-6">
                <header class="mb-4 flex items-center gap-2">
                    <div class="h-8 w-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor">
                            <path d="m12 3 9 5-9 5-9-5 9-5Zm0 7.18L18 7l-6-3.18L6 7l6 3.18Z"/>
                        </svg>
                    </div>
                    <h4 class="font-semibold text-gray-800">Clasificación</h4>
                </header>

                <dl class="space-y-3">
                    <div class="flex justify-between gap-4">
                        <dt class="text-sm text-gray-500">Categoría</dt>
                        <dd class="text-sm">
                            @if($categoriaNombre)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-gray-100 text-gray-700 border border-gray-200">
                                    {{ $categoriaNombre }}
                                </span>
                            @else
                                <span class="text-gray-400">—</span>
                            @endif
                        </dd>
                    </div>
                </dl>
            </section>

            <!-- Metadatos -->
            <section class="bg-white rounded-2xl shadow-sm border p-6">
                <header class="mb-4 flex items-center gap-2">
                    <div class="h-8 w-8 rounded-full bg-sky-100 text-sky-600 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 13 2 6.76V18h20V6.76L12 13Zm0-2L2 4h20L12 11Z"/>
                        </svg>
                    </div>
                    <h4 class="font-semibold text-gray-800">Metadatos</h4>
                </header>

                <div class="grid grid-cols-1 gap-3">
                    <div class="p-4 rounded-xl bg-gray-50 border">
                        <p class="text-xs uppercase tracking-wide text-gray-500">ID</p>
                        <p class="mt-1 text-sm text-gray-800">{{ $rubro->id }}</p>
                    </div>
                    <div class="p-4 rounded-xl bg-gray-50 border">
                        <p class="text-xs uppercase tracking-wide text-gray-500">Creado</p>
                        <p class="mt-1 text-sm text-gray-800">{{ $creado ?? '—' }}</p>
                    </div>
                    <div class="p-4 rounded-xl bg-gray-50 border">
                        <p class="text-xs uppercase tracking-wide text-gray-500">Actualizado</p>
                        <p class="mt-1 text-sm text-gray-800">{{ $actualizado ?? '—' }}</p>
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
