<!-- resources/views/administrador/solicitudes/show.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="mt-6 sm:mt-24 text-xl font-semibold text-gray-800 leading-tight">
            Detalle de la Solicitud
        </h2>
    </x-slot>

    @php
        // Iniciales a partir del nombre del coordinador
        $nombre    = trim($solicitud->nombre_coordinador ?? '');
        $partes    = preg_split('/\s+/', $nombre, -1, PREG_SPLIT_NO_EMPTY);
        $iniciales = collect($partes)->take(2)->map(function($p){
            return mb_strtoupper(mb_substr($p, 0, 1), 'UTF-8');
        })->implode('');
        $iniciales = $iniciales ?: 'S';

        // Compatibilidad con nombres de columnas
        $fechaRaw = $solicitud->fecha_solicitud
                   ?? $solicitud->fecha
                   ?? $solicitud->created_at
                   ?? null;

        $fechaFmt = $fechaRaw ? \Carbon\Carbon::parse($fechaRaw)->format('d/m/Y') : null;

        $resultadosTxt = $solicitud->resultados_esperados
                      ?? $solicitud->resultados
                      ?? null;
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
                        {{ $solicitud->nombre_coordinador }}
                    </h3>
                    <p class="text-sm text-gray-500">
                        Código: <span class="font-medium text-gray-700">{{ $solicitud->codigo }}</span>
                    </p>
                </div>

                <div class="ms-auto flex items-center gap-2">
                    <a href="{{ route('admin.solicitudes.pdf', $solicitud->id) }}"
                       target="_blank"
                       class="inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-emerald-600 text-white text-sm hover:bg-emerald-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M19 2H8c-1.1 0-2 .9-2 2v4h2V4h11v16H8v-4H6v4c0 1.1.9 2 2 2h11c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z"/><path d="M10 17h2V7h-2v10zm-4-5h2V7H6v5zm8-2v7h2v-7h-2z"/></svg>
                        Ver PDF
                    </a>

                    <a href="{{ route('admin.solicitudes.index') }}"
                       class="inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-gray-700 text-white text-sm hover:bg-gray-800">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2Z"/></svg>
                        Regresar
                    </a>
                </div>
            </div>
        </div>

        <!-- Content Cards -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Datos Generales -->
            <section class="bg-white rounded-2xl shadow-sm border p-6">
                <header class="mb-4 flex items-center gap-2">
                    <div class="h-8 w-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5Zm0 2c-5 0-9 2.5-9 5.5V22h18v-2.5C21 16.5 17 14 12 14Z"/></svg>
                    </div>
                    <h4 class="font-semibold text-gray-800">Datos Generales</h4>
                </header>

                <dl class="space-y-3">
                    <div class="flex justify-between gap-4">
                        <dt class="text-sm text-gray-500">Centro Universitario</dt>
                        <dd class="text-sm text-gray-800">{{ $solicitud->centro_universitario }}</dd>
                    </div>

                    <div class="flex justify-between gap-4">
                        <dt class="text-sm text-gray-500">Nivel de estudios</dt>
                        <dd class="text-sm text-gray-800">{{ $solicitud->nivel_estudios }}</dd>
                    </div>

                    <div class="flex justify-between gap-4">
                        <dt class="text-sm text-gray-500">Posgrado</dt>
                        <dd class="text-sm text-gray-800">{{ $solicitud->nombre_posgrado }}</dd>
                    </div>

                    <div class="flex justify-between gap-4">
                        <dt class="text-sm text-gray-500">Clave SNP</dt>
                        <dd class="text-sm text-gray-800">{{ $solicitud->clave_snp }}</dd>
                    </div>
                </dl>
            </section>

            <!-- Información de la solicitud -->
            <section class="bg-white rounded-2xl shadow-sm border p-6 lg:col-span-2">
                <header class="mb-4 flex items-center gap-2">
                    <div class="h-8 w-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="m12 3 9 5-9 5-9-5 9-5Zm0 7.18L18 7l-6-3.18L6 7l6 3.18ZM21 10v4c0 2.21-4.03 4-9 4s-9-1.79-9-4v-4l9 5 9-5Z"/></svg>
                    </div>
                    <h4 class="font-semibold text-gray-800">Información de la Solicitud</h4>
                </header>

                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="p-4 rounded-xl bg-gray-50 border">
                        <dt class="text-xs uppercase tracking-wide text-gray-500">Fecha</dt>
                        <dd class="mt-1 text-sm text-gray-800">
                            {{ $fechaFmt ?? '—' }}
                        </dd>
                    </div>

                    <div class="p-4 rounded-xl bg-gray-50 border">
                        <dt class="text-xs uppercase tracking-wide text-gray-500">Modalidad</dt>
                        <dd class="mt-1 text-sm text-gray-800">
                            {{ $solicitud->modalidad ?? '—' }}
                        </dd>
                    </div>

                    <div class="p-4 rounded-xl bg-gray-50 border md:col-span-2">
                        <dt class="text-xs uppercase tracking-wide text-gray-500">Objetivo</dt>
                        <dd class="mt-1 text-sm text-gray-800">
                            {{ $solicitud->objetivo ?? '—' }}
                        </dd>
                    </div>

                    <div class="p-4 rounded-xl bg-gray-50 border md:col-span-2">
                        <dt class="text-xs uppercase tracking-wide text-gray-500">Justificación</dt>
                        <dd class="mt-1 text-sm text-gray-800">
                            {{ $solicitud->justificacion ?? '—' }}
                        </dd>
                    </div>

                    <div class="p-4 rounded-xl bg-gray-50 border md:col-span-2">
                        <dt class="text-xs uppercase tracking-wide text-gray-500">Resultados esperados</dt>
                        <dd class="mt-1 text-sm text-gray-800">
                            {{ $resultadosTxt ?? '—' }}
                        </dd>
                    </div>
                </dl>
            </section>

            <!-- Rubros -->
            <section class="bg-white rounded-2xl shadow-sm border p-6 lg:col-span-3">
                <header class="mb-4 flex items-center gap-2">
                    <div class="h-8 w-8 rounded-full bg-sky-100 text-sky-600 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M12 13 2 6.76V18h20V6.76L12 13Zm0-2L2 4h20L12 11Z"/></svg>
                    </div>
                    <h4 class="font-semibold text-gray-800">Rubros solicitados</h4>
                </header>

                <div class="overflow-x-auto rounded-xl border">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-50">
                            <tr class="text-left text-gray-700">
                                <th class="px-4 py-3 font-semibold">Rubro</th>
                                <th class="px-4 py-3 font-semibold">Descripción</th>
                                <th class="px-4 py-3 text-right font-semibold">Monto</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @php $total = 0; @endphp
                            @foreach($rubros as $r)
                                @php $total += $r->monto_solicitado; @endphp
                                <tr class="hover:bg-gray-50/80">
                                    <td class="px-4 py-3">{{ $r->rubro_nombre }}</td>
                                    <td class="px-4 py-3">{{ $r->descripcion }}</td>
                                    <td class="px-4 py-3 text-right">${{ number_format($r->monto_solicitado, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50 font-semibold">
                            <tr>
                                <td colspan="2" class="px-4 py-3 text-right">Total</td>
                                <td class="px-4 py-3 text-right text-green-700">${{ number_format($total, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </section>

        </div>
    </div>
</x-app-layout>
