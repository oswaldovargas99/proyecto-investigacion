<!-- resources/views/administrador/solicitudes/index.blade.php -->
{{-- Estructura y diseño adaptados al estilo del módulo "Informe2".
     ⚠️ Lógica intacta: mismas variables ($q, $solicitudes) y rutas (admin.solicitudes.*)  --}}
<x-app-layout>
    {{-- Header (slot) minimalista para mantener consistencia con el layout --}}
    <x-slot name="header">
        <h2 class="mt-6 sm:mt-20 text-xl sm:text-2xl font-semibold text-gray-800">
            {{-- Intencionalmente sin título redundante; el bloque hero debajo lo muestra --}}
        </h2>
    </x-slot>

    {{-- Contenedor principal --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6 sm:mt-10">

        {{-- HERO / Encabezado del módulo (estilo Informe2) --}}
        <section class="rounded-2xl border border-gray-200 bg-white/70 backdrop-blur p-5 sm:p-6 mb-5">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div class="flex items-start gap-3">
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 ring-1 ring-inset ring-indigo-200">
                        {{-- Ícono de “solicitudes” --}}
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path d="M12 3 3 7l9 4 9-4-9-4zM5 11v2l7 3 7-3v-2l-7 3-7-3z"/>
                            <path d="M12 13a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm-6 6v-1a6 6 0 0 1 12 0v1H6z"/>
                        </svg>
                    </span>
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-bold leading-tight text-gray-900">
                            Solicitudes Registradas
                        </h1>
                        <p class="mt-1 text-sm text-gray-600">
                            Consulta, filtra y exporta las solicitudes capturadas por los coordinadores de posgrado.
                        </p>
                    </div>
                </div>

                {{-- Métricas/Chips estilo Informe2 (solo UI; sin lógica adicional) --}}
                <div class="flex flex-wrap items-center gap-2">
                    <span class="inline-flex items-center gap-1 rounded-full bg-gray-50 px-3 py-1.5 text-xs font-medium text-gray-700 ring-1 ring-inset ring-gray-200">
                        Total: <strong class="text-gray-900">{{ $solicitudes->total() }}</strong>
                    </span>
                    <span class="inline-flex items-center gap-1 rounded-full bg-indigo-50 px-3 py-1.5 text-xs font-medium text-indigo-700 ring-1 ring-inset ring-indigo-200">
                        Mostrando:
                        <strong>{{ $solicitudes->firstItem() ?? 0 }}–{{ $solicitudes->lastItem() ?? 0 }}</strong>
                    </span>
                    @if(!empty($q))
                        <span class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-3 py-1.5 text-xs font-medium text-amber-700 ring-1 ring-inset ring-amber-200">
                            Filtro: “{{ $q }}”
                        </span>
                    @endif
                </div>
            </div>
        </section>

        {{-- ALERTS (auto-dismiss 5s) --}}
        @if(session('success') || session('warning') || session('danger'))
            @php
                $type = session('success') ? 'green' : (session('warning') ? 'yellow' : 'red');
                $msg  = session('success') ?? session('warning') ?? session('danger');
            @endphp
            <div x-data="{ show: true }"
                 x-init="setTimeout(() => show = false, 5000)"
                 x-show="show"
                 x-transition.opacity.duration.400ms
                 role="alert"
                 class="mb-4 flex items-center gap-2 rounded-xl border px-4 py-3
                        bg-{{ $type }}-50 text-{{ $type }}-800 border-{{ $type }}-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2a10 10 0 1 0 .001 20.001A10 10 0 0 0 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
                <span class="text-sm">{{ $msg }}</span>
            </div>
        @endif

        {{-- TOOLBAR estilo Informe2: búsqueda + filtros + resumen --}}
        <section class="mb-4 rounded-2xl border border-gray-200 bg-white p-4 sm:p-5">
            <form method="GET" action="{{ route('admin.solicitudes.index') }}"
                  class="grid grid-cols-1 sm:grid-cols-12 gap-3 sm:gap-4">
                {{-- Buscador --}}
                <div class="sm:col-span-6">
                    <div class="relative">
                        <input
                            type="text"
                            name="q"
                            value="{{ $q }}"
                            placeholder="Buscar por CU, coordinador, código, nivel, posgrado, clave SNP…"
                            class="w-full rounded-lg border-gray-300 pl-9 pr-10 py-2.5 text-sm
                                   focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500"
                        />
                        <span class="pointer-events-none absolute inset-y-0 left-2.5 flex items-center text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="m20.94 19.54-4.28-4.28A7.94 7.94 0 1 0 16 17.66l4.28 4.28 1.66-1.66ZM4 10a6 6 0 1 1 12 0A6 6 0 0 1 4 10Z"/></svg>
                        </span>
                        @if($q)
                            <a href="{{ route('admin.solicitudes.index') }}"
                               class="absolute inset-y-0 right-2.5 flex items-center text-gray-400 hover:text-gray-600"
                               title="Limpiar">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="m13.41 12 4.3-4.29-1.42-1.42L12 10.59 7.71 6.29 6.29 7.71 10.59 12l-4.3 4.29 1.42 1.42L12 13.41l4.29 4.3 1.42-1.42z"/></svg>
                            </a>
                        @endif
                    </div>
                </div>

                {{-- Filtro Estado (opcional; si no existe, se ignora) --}}
                <div class="sm:col-span-3">
                    <select name="estado"
                            class="w-full rounded-lg border-gray-300 py-2.5 text-sm
                                   focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500">
                        <option value="">Estado (todos)</option>
                        <option value="pendiente" {{ request('estado')==='pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="revisado"  {{ request('estado')==='revisado'  ? 'selected' : '' }}>Revisado</option>
                        <option value="validado"  {{ request('estado')==='validado'  ? 'selected' : '' }}>Validado</option>
                    </select>
                </div>

                {{-- Botón Buscar --}}
                <div class="sm:col-span-3">
                    <button type="submit"
                            class="w-full inline-flex items-center justify-center gap-2 rounded-lg bg-indigo-600 px-3 py-2.5 text-sm font-semibold text-white hover:bg-indigo-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 -ms-0.5" viewBox="0 0 24 24" fill="currentColor"><path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79L20 21.5 21.5 20l-6-6zM9.5 14C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
                        Buscar
                    </button>
                </div>
            </form>
        </section>

        {{-- LISTADO: tarjetas móviles + tabla escritorio (patrón Informe2) --}}
        <section class="space-y-4">

            {{-- TARJETAS (Mobile-first) --}}
            <div class="grid grid-cols-1 gap-3 md:hidden">
                @forelse ($solicitudes as $s)
                    <article class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm hover:shadow transition">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <h3 class="text-base font-semibold text-gray-900">
                                    {{ $s->nombre_posgrado }}
                                </h3>
                                <p class="mt-0.5 text-sm text-gray-600">
                                    <span class="font-medium">{{ $s->centro_universitario }}</span>
                                    <span class="mx-1 text-gray-300">•</span>
                                    Nivel: {{ $s->nivel_estudios }}
                                </p>
                                <p class="mt-1 text-sm text-gray-600">
                                    Coord.: <span class="font-medium text-gray-800">{{ $s->nombre_coordinador }}</span>
                                </p>
                                <div class="mt-2 flex flex-wrap items-center gap-1.5">
                                    <span class="inline-flex items-center rounded-md px-2 py-0.5 text-[11px] font-medium bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-200">
                                        Código: {{ $s->codigo }}
                                    </span>
                                    <span class="inline-flex items-center rounded-md px-2 py-0.5 text-[11px] font-medium bg-slate-50 text-slate-700 ring-1 ring-inset ring-slate-200">
                                        SNP: {{ $s->clave_snp }}
                                    </span>
                                    @isset($s->estado)
                                        <span class="inline-flex items-center rounded-md px-2 py-0.5 text-[11px] font-medium bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-200">
                                            {{ ucfirst($s->estado) }}
                                        </span>
                                    @endisset
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-xs text-gray-500">Total asignado</div>
                                <div class="text-base font-semibold text-gray-900">
                                    ${{ number_format($s->total_asignado, 2) }}
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 flex items-center justify-end gap-2">
                            <a href="{{ route('admin.solicitudes.show', $s->id) }}"
                               class="inline-flex items-center gap-1.5 rounded-md border border-gray-200 bg-white px-2.5 py-1.5 text-xs text-gray-700 hover:bg-gray-50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 6C7 6 2.73 9.11 1 14c1.73 4.89 6 8 11 8s9.27-3.11 11-8c-1.73-4.89-6-8-11-8zm0 13a5 5 0 1 1 .001-10.001A5 5 0 0 1 12 19zm0-8a3 3 0 1 0 .001 6.001A3 3 0 0 0 12 11z"/></svg>
                                Ver
                            </a>
                            <a href="{{ route('admin.solicitudes.pdf', $s->id) }}" target="_blank"
                               class="inline-flex items-center gap-1.5 rounded-md bg-emerald-600 px-2.5 py-1.5 text-xs font-medium text-white hover:bg-emerald-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M19 2H8c-1.1 0-2 .9-2 2v4h2V4h11v16H8v-4H6v4c0 1.1.9 2 2 2h11c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z"/><path d="M10 17h2V7h-2v10zm-4-5h2V7H6v5zm8-2v7h2v-7h-2z"/></svg>
                                PDF
                            </a>
                        </div>
                    </article>
                @empty
                    <div class="rounded-xl border border-dashed border-gray-300 bg-white p-8 text-center text-sm text-gray-500">
                        No hay solicitudes que coincidan con tu búsqueda.
                    </div>
                @endforelse
            </div>

            {{-- TABLA (Desktop) --}}
            <div class="hidden md:block overflow-x-auto rounded-2xl border border-gray-200 bg-white">
                <table class="min-w-full text-sm">
                    <thead class="sticky top-0 z-10 bg-gray-50/80 backdrop-blur">
                        <tr class="text-left text-gray-700">
                            <th class="px-4 py-3 font-semibold">#</th>
                            <th class="px-4 py-3 font-semibold">Centro Universitario</th>
                            <th class="px-4 py-3 font-semibold">Coordinador(a)</th>
                            <th class="px-4 py-3 font-semibold">Código</th>
                            <th class="px-4 py-3 font-semibold">Nivel</th>
                            <th class="px-4 py-3 font-semibold">Posgrado</th>
                            <th class="px-4 py-3 font-semibold">Clave SNP</th>
                            <th class="px-4 py-3 font-semibold">Estado</th>
                            <th class="px-4 py-3 text-right font-semibold">Total asignado</th>
                            <th class="px-4 py-3 text-right font-semibold">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($solicitudes as $s)
                            <tr class="hover:bg-gray-50/80">
                                <td class="px-4 py-3">
                                    {{ $loop->iteration + (($solicitudes->firstItem() ?? 1) - 1) }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ $s->centro_universitario }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="font-medium text-gray-900">{{ $s->nombre_coordinador }}</div>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center rounded-md px-2 py-0.5 text-xs font-medium
                                                bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-200">
                                        {{ $s->codigo }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    {{ $s->nivel_estudios }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ $s->nombre_posgrado }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ $s->clave_snp }}
                                </td>
                                <td class="px-4 py-3">
                                    {{-- Badge de estado (opcional) --}}
                                    @isset($s->estado)
                                        <span class="inline-flex items-center rounded-md px-2 py-0.5 text-xs font-medium
                                                    {{ $s->estado==='validado' ? 'bg-emerald-50 text-emerald-700 ring-emerald-200' :
                                                       ($s->estado==='revisado' ? 'bg-indigo-50 text-indigo-700 ring-indigo-200' :
                                                                                 'bg-amber-50 text-amber-700 ring-amber-200') }}
                                                    ring-1 ring-inset">
                                            {{ ucfirst($s->estado) }}
                                        </span>
                                    @else
                                        <span class="text-xs text-gray-500">—</span>
                                    @endisset
                                </td>
                                <td class="px-4 py-3 text-right font-medium text-gray-900">
                                    ${{ number_format($s->total_asignado, 2) }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <a href="{{ route('admin.solicitudes.show', $s->id) }}"
                                           title="Ver"
                                           class="inline-flex items-center gap-1 rounded-md border border-gray-200 bg-white px-2 py-1.5 text-xs text-gray-700 hover:bg-gray-50">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 6C7 6 2.73 9.11 1 14c1.73 4.89 6 8 11 8s9.27-3.11 11-8c-1.73-4.89-6-8-11-8zm0 13a5 5 0 1 1 .001-10.001A5 5 0 0 1 12 19zm0-8a3 3 0 1 0 .001 6.001A3 3 0 0 0 12 11z"/></svg>
                                            Ver
                                        </a>
                                        <a href="{{ route('admin.solicitudes.pdf', $s->id) }}" target="_blank"
                                           title="PDF"
                                           class="inline-flex items-center gap-1 rounded-md bg-emerald-600 px-2 py-1.5 text-xs font-medium text-white hover:bg-emerald-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M19 2H8c-1.1 0-2 .9-2 2v4h2V4h11v16H8v-4H6v4c0 1.1.9 2 2 2h11c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z"/><path d="M10 17h2V7h-2v10zm-4-5h2V7H6v5zm8-2v7h2v-7h-2z"/></svg>
                                            PDF
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="px-4 py-10 text-center text-sm text-gray-500">
                                    <div class="mx-auto mb-2 h-10 w-10 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M19 3H4.99C3.88 3 3 3.89 3 5l-.01 14c0 1.1.89 2 2 2H19c1.1 0 1.99-.9 1.99-2L21 5c0-1.11-.89-2-2-2zm0 14h-4.3c-.39 0-.75.23-.92.59l-.57 1.15H10.8l-.58-1.16c-.17-.35-.53-.58-.92-.58H5V5h14v12z"/></svg>
                                    </div>
                                    No hay solicitudes que coincidan con tu búsqueda.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        {{-- Paginación + resumen (pie) --}}
        <div class="mt-5 flex flex-col items-center justify-between gap-3 sm:flex-row">
            <div class="text-sm text-gray-600">
                Mostrando
                <span class="font-semibold">{{ $solicitudes->firstItem() ?? 0 }}</span>
                a
                <span class="font-semibold">{{ $solicitudes->lastItem() ?? 0 }}</span>
                de
                <span class="font-semibold">{{ $solicitudes->total() }}</span>
                registros
            </div>
            <div>
                {{ $solicitudes->onEachSide(1)->links('vendor.pagination.pretty') }}
            </div>
        </div>

    </div>
</x-app-layout>
