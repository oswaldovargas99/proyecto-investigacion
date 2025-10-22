<!-- resources/views/usuario/informes/show.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="mt-6 sm:mt-24 text-xl font-semibold text-gray-800 leading-tight">
            Detalle del Informe
        </h2>
    </x-slot>

    @php
        // ====== Fecha
        $fechaFmt = !empty($informe->fecha)
            ? \Carbon\Carbon::parse($informe->fecha)->format('d/m/Y')
            : null;

        // ====== Monto
        $monto = is_numeric($informe->monto_destinado ?? null)
            ? '$' . number_format($informe->monto_destinado, 2, '.', ',')
            : '—';

        // ====== Etiquetas de catálogos (probamos varios posibles campos de nombre)
        $cat = optional($informe->categoriaMejora);
        $categoriaMejoraLbl =
            $cat->nombre
            ?? $cat->categoria
            ?? $cat->titulo
            ?? (is_numeric($informe->categoria_mejora_id ?? null) ? ('ID: '.$informe->categoria_mejora_id) : null);

        $crit = optional($informe->criterioSnp);
        $criterioSnpLbl =
            $crit->nombre
            ?? $crit->criterio
            ?? $crit->titulo
            ?? (is_numeric($informe->criterio_snp_id ?? null) ? ('ID: '.$informe->criterio_snp_id) : null);

        $tipo = optional($informe->tipoBeneficiario);
        $tipoBenefLbl =
            $tipo->nombre
            ?? $tipo->tipo
            ?? $tipo->titulo
            ?? (is_numeric($informe->tipo_beneficiario_id ?? null) ? ('ID: '.$informe->tipo_beneficiario_id) : null);

        // ====== Iniciales
        $iniciales = 'IN';
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
                        Informe
                    </h3>
                    <p class="text-sm text-gray-500">
                        Fecha: <span class="font-medium text-gray-700">{{ $fechaFmt ?? '—' }}</span>
                    </p>
                </div>

                <div class="ms-auto flex items-center gap-2">
                    @if(isset($informe->id))
                        <a href="{{ route('usuario.informes.edit', $informe->id) }}"
                           class="inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-yellow-500 text-white text-sm hover:bg-yellow-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M5 21h14v-2H5v2Zm13.71-14.29-1.42-1.42a1 1 0 0 0-1.41 0L6 13.17V16h2.83l9.88-9.88a1 1 0 0 0 0-1.41Z"/>
                            </svg>
                            Editar
                        </a>
                    @endif

                    <a href="{{ route('usuario.informes.index') }}"
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
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            <!-- Resumen -->
            <section class="bg-white rounded-2xl shadow-sm border p-6 lg:col-span-6">
                <header class="mb-4 flex items-center gap-2">
                    <div class="h-8 w-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M6 2h7l5 5v13a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2zm7 1v4h4l-4-4z"/>
                        </svg>
                    </div>
                    <h4 class="font-semibold text-gray-800">Resumen</h4>
                </header>

                <dl class="space-y-3">
                    <div class="grid grid-cols-12 gap-2">
                        <dt class="col-span-6 md:col-span-5 text-sm text-gray-500">Fecha</dt>
                        <dd class="col-span-6 md:col-span-7 text-sm text-gray-800">{{ $fechaFmt ?? '—' }}</dd>
                    </div>

                    <div class="grid grid-cols-12 gap-2">
                        <dt class="col-span-6 md:col-span-5 text-sm text-gray-500">Beneficiarios</dt>
                        <dd class="col-span-6 md:col-span-7 text-sm text-gray-800">{{ $informe->numero_beneficiario ?? '—' }}</dd>
                    </div>

                    <div class="grid grid-cols-12 gap-2">
                        <dt class="col-span-6 md:col-span-5 text-sm text-gray-500">Monto destinado</dt>
                        <dd class="col-span-6 md:col-span-7 text-sm font-medium text-gray-800">{{ $monto }}</dd>
                    </div>
                </dl>
            </section>

            <!-- Clasificación -->
            <section class="bg-white rounded-2xl shadow-sm border p-6 lg:col-span-6">
                <header class="mb-4 flex items-center gap-2">
                    <div class="h-8 w-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M3 5h18v2H3zM3 11h18v2H3zM3 17h18v2H3z"/>
                        </svg>
                    </div>
                    <h4 class="font-semibold text-gray-800">Clasificación</h4>
                </header>

                <dl class="space-y-3">
                    <div class="grid grid-cols-12 gap-2">
                        <dt class="col-span-6 md:col-span-5 text-sm text-gray-500">Categoría de mejora</dt>
                        <dd class="col-span-6 md:col-span-7 text-sm">
                            @if($categoriaMejoraLbl)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700">
                                    {{ $categoriaMejoraLbl }}
                                </span>
                            @else
                                <span class="text-gray-400">—</span>
                            @endif
                        </dd>
                    </div>

                    <div class="grid grid-cols-12 gap-2">
                        <dt class="col-span-6 md:col-span-5 text-sm text-gray-500">Criterio SNP</dt>
                        <dd class="col-span-6 md:col-span-7 text-sm">
                            @if($criterioSnpLbl)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-100">
                                    {{ $criterioSnpLbl }}
                                </span>
                            @else
                                <span class="text-gray-400">—</span>
                            @endif
                        </dd>
                    </div>

                    <div class="grid grid-cols-12 gap-2">
                        <dt class="col-span-6 md:col-span-5 text-sm text-gray-500">Tipo de beneficiario</dt>
                        <dd class="col-span-6 md:col-span-7 text-sm text-gray-800">
                            {{ $tipoBenefLbl ?? '—' }}
                        </dd>
                    </div>
                </dl>
            </section>

            <!-- Detalle -->
            <section class="bg-white rounded-2xl shadow-sm border p-6 lg:col-span-12">
                <header class="mb-4 flex items-center gap-2">
                    <div class="h-8 w-8 rounded-full bg-sky-100 text-sky-600 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 13 2 6.76V18h20V6.76L12 13Zm0-2L2 4h20L12 11Z"/>
                        </svg>
                    </div>
                    <h4 class="font-semibold text-gray-800">Detalle del informe</h4>
                </header>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="p-4 rounded-xl bg-gray-50 border">
                        <dt class="text-xs uppercase tracking-wide text-gray-500">Actividad realizada</dt>
                        <dd class="mt-1 text-sm text-gray-800">
                            {{ $informe->actividad_realizada ?? '—' }}
                        </dd>
                    </div>

                    <div class="p-4 rounded-xl bg-gray-50 border">
                        <dt class="text-xs uppercase tracking-wide text-gray-500">Concepto de gasto</dt>
                        <dd class="mt-1 text-sm text-gray-800">
                            {{ $informe->concepto_gasto ?? '—' }}
                        </dd>
                    </div>

                    <div class="p-4 rounded-xl bg-gray-50 border md:col-span-2">
                        <dt class="text-xs uppercase tracking-wide text-gray-500">Impacto académico</dt>
                        <dd class="mt-1 text-sm text-gray-800">
                            {{ $informe->impacto_academico ?? '—' }}
                        </dd>
                    </div>

                    <div class="p-4 rounded-xl bg-gray-50 border md:col-span-2">
                        <dt class="text-xs uppercase tracking-wide text-gray-500">Comentarios</dt>
                        <dd class="mt-1 text-sm text-gray-800">
                            {{ $informe->comentarios ?? '—' }}
                        </dd>
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
