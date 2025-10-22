<!-- resources/views/administrador/rubros-categorias/show.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="mt-6 sm:mt-24 text-xl font-semibold text-gray-800 leading-tight">
            Detalle de la Categoría de Rubro
        </h2>
    </x-slot>

    @php
        // Iniciales a partir del nombre de la categoría (sin usar Str)
        $nombre    = trim($categoria->categoria ?? '');
        $partes    = preg_split('/[\s\-]+/', $nombre, -1, PREG_SPLIT_NO_EMPTY);
        $iniciales = collect($partes)->take(2)->map(fn($p) => mb_strtoupper(mb_substr($p, 0, 1), 'UTF-8'))->implode('');
        $iniciales = $iniciales ?: 'C';

        // Fechas en formato latino
        $creadoFmt = $categoria->created_at ? \Carbon\Carbon::parse($categoria->created_at)->format('d/m/Y H:i') : null;
        $actualFmt = $categoria->updated_at ? \Carbon\Carbon::parse($categoria->updated_at)->format('d/m/Y H:i') : null;

        // Conteo de rubros asociados (si existe relación)
        $rubrosCount = method_exists($categoria, 'rubros') ? $categoria->rubros()->count() : null;
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
                        {{ $categoria->categoria }}
                    </h3>
                    <p class="text-sm text-gray-500">
                        ID: <span class="font-medium text-gray-700">{{ $categoria->id }}</span>
                    </p>
                </div>

                <div class="ms-auto flex items-center gap-2">
                    @if(isset($categoria->id))
                        <a href="{{ route('admin.rubros-categorias.edit', $categoria) }}"
                           class="inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-yellow-500 text-white text-sm hover:bg-yellow-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M5 21h14v-2H5v2Zm13.71-14.29-1.42-1.42a1 1 0 0 0-1.41 0L6 13.17V16h2.83l9.88-9.88a1 1 0 0 0 0-1.41Z"/></svg>
                            Editar
                        </a>
                    @endif

                    <a href="{{ route('admin.rubros-categorias.index') }}"
                       class="inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-gray-700 text-white text-sm hover:bg-gray-800">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2Z"/></svg>
                        Regresar
                    </a>
                </div>
            </div>
        </div>

        <!-- Content Cards -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Información -->
            <section class="bg-white rounded-2xl shadow-sm border p-6">
                <header class="mb-4 flex items-center gap-2">
                    <div class="h-8 w-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center">
                        <!-- icon list -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M3 5h18v2H3zM3 11h18v2H3zM3 17h12v2H3z"/></svg>
                    </div>
                    <h4 class="font-semibold text-gray-800">Información</h4>
                </header>

                <dl class="space-y-3">
                    <div class="flex justify-between gap-4">
                        <dt class="text-sm text-gray-500">Categoría</dt>
                        <dd class="text-sm text-gray-800 text-right">{{ $categoria->categoria }}</dd>
                    </div>
                    <div class="flex justify-between gap-4">
                        <dt class="text-sm text-gray-500">Descripción</dt>
                        <dd class="text-sm text-gray-800 text-right max-w-[16rem] md:max-w-[18rem] lg:max-w-[12rem]">
                            {{ $categoria->descripcion ?: '—' }}
                        </dd>
                    </div>
                </dl>
            </section>

            <!-- Detalle (col-span-2) -->
            <section class="bg-white rounded-2xl shadow-sm border p-6 lg:col-span-2">
                <header class="mb-4 flex items-center gap-2">
                    <div class="h-8 w-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center">
                        <!-- icon doc -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M14 2H6a2 2 0 0 0-2 2v16l4-4h8a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2Z"/></svg>
                    </div>
                    <h4 class="font-semibold text-gray-800">Detalle</h4>
                </header>

                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="p-4 rounded-xl bg-gray-50 border">
                        <dt class="text-xs uppercase tracking-wide text-gray-500">Creado</dt>
                        <dd class="mt-1 text-sm text-gray-800">{{ $creadoFmt ?? '—' }}</dd>
                    </div>

                    <div class="p-4 rounded-xl bg-gray-50 border">
                        <dt class="text-xs uppercase tracking-wide text-gray-500">Actualizado</dt>
                        <dd class="mt-1 text-sm text-gray-800">{{ $actualFmt ?? '—' }}</dd>
                    </div>

                    @if(!is_null($rubrosCount))
                        <div class="p-4 rounded-xl bg-gray-50 border md:col-span-2">
                            <dt class="text-xs uppercase tracking-wide text-gray-500">Rubros asociados</dt>
                            <dd class="mt-1">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-100">
                                    {{ $rubrosCount }}
                                </span>
                            </dd>
                        </div>
                    @endif
                </dl>
            </section>

            <!-- Observaciones / Nota -->
            <section class="bg-white rounded-2xl shadow-sm border p-6 lg:col-span-3">
                <header class="mb-4 flex items-center gap-2">
                    <div class="h-8 w-8 rounded-full bg-sky-100 text-sky-600 flex items-center justify-center">
                        <!-- icon note -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M12 13 2 6.76V18h20V6.76L12 13Zm0-2L2 4h20L12 11Z"/></svg>
                    </div>
                    <h4 class="font-semibold text-gray-800">Observaciones</h4>
                </header>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="p-4 rounded-xl bg-gray-50 border md:col-span-3">
                        <p class="text-sm text-gray-700">
                            Esta vista muestra la información de la categoría. Los rubros individuales se administran en su propio módulo.
                        </p>
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>

