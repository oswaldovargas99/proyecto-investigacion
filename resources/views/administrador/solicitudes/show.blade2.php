<!-- resources/views/administrador/solicitudes/show.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            {{ __('Detalle de Solicitud') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4">

            <div class="flex justify-between mb-4">
                <a href="{{ route('admin.solicitudes.index') }}"
                   class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-3 py-2 rounded-md text-xs font-semibold">
                    ← Regresar
                </a>

                <a href="{{ route('admin.solicitudes.pdf', $solicitud->id) }}"
                   target="_blank"
                   class="bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-2 rounded-md text-xs font-semibold">
                    Ver Solicitud Completa (PDF)
                </a>
            </div>

            @php
                // Compatibilidad con distintos nombres de columnas
                $fechaRaw = $solicitud->fecha_solicitud
                           ?? $solicitud->fecha
                           ?? $solicitud->created_at
                           ?? null;

                $resultadosTxt = $solicitud->resultados_esperados
                              ?? $solicitud->resultados
                              ?? null;
            @endphp

            <div class="bg-white rounded-lg shadow p-6 space-y-6">
                <div>
                    <h3 class="font-semibold text-gray-800 mb-2">Datos Generales</h3>
                    <p><strong>Centro Universitario:</strong> {{ $solicitud->centro_universitario }}</p>
                    <p><strong>Código:</strong> {{ $solicitud->codigo }}</p>
                    <p><strong>Coordinador:</strong> {{ $solicitud->nombre_coordinador }}</p>
                    <p><strong>Nivel:</strong> {{ $solicitud->nivel_estudios }}</p>
                    <p><strong>Clave SNP:</strong> {{ $solicitud->clave_snp }}</p>
                    <p><strong>Posgrado:</strong> {{ $solicitud->nombre_posgrado }}</p>
                </div>

                <div>
                    <h3 class="font-semibold text-gray-800 mb-2">Información de la Solicitud</h3>
                    <p>
                        <strong>Fecha:</strong>
                        @if($fechaRaw)
                            {{ \Carbon\Carbon::parse($fechaRaw)->format('d/m/Y') }}
                        @else
                            —
                        @endif
                    </p>
                    <p><strong>Modalidad:</strong> {{ $solicitud->modalidad ?? '—' }}</p>
                    <p><strong>Objetivo:</strong> {{ $solicitud->objetivo ?? '—' }}</p>
                    <p><strong>Justificación:</strong> {{ $solicitud->justificacion ?? '—' }}</p>
                    <p><strong>Resultados Esperados:</strong> {{ $resultadosTxt ?? '—' }}</p>
                </div>

                <div>
                    <h3 class="font-semibold text-gray-800 mb-2">Rubros Solicitados</h3>
                    <table class="min-w-full text-sm border border-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-4 py-2 text-left">Rubro</th>
                                <th class="px-4 py-2 text-left">Descripción</th>
                                <th class="px-4 py-2 text-right">Monto</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $total = 0; @endphp
                            @foreach($rubros as $r)
                                @php $total += $r->monto_solicitado; @endphp
                                <tr>
                                    <td class="px-4 py-2">{{ $r->rubro_nombre }}</td>
                                    <td class="px-4 py-2">{{ $r->descripcion }}</td>
                                    <td class="px-4 py-2 text-right">${{ number_format($r->monto_solicitado, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50 font-semibold">
                            <tr>
                                <td colspan="2" class="px-4 py-2 text-right">Total</td>
                                <td class="px-4 py-2 text-right text-green-700">${{ number_format($total, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
