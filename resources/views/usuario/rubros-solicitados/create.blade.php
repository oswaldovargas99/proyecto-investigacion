{{-- resources/views/usuario/rubros-solicitados/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="mt-6 sm:mt-24 text-xl font-semibold text-gray-800 leading-tight">
            Registro de Rubros
        </h2>
    </x-slot>

    @php
        // Mantener estructura original y preparar variables que espera el partial "form"
        $isEdit            = false;
        $action            = route('usuario.rubros-solicitados.store'); // el partial lo puede ignorar (se guardan por sección)
        $rubrosMontosPrev  = $rubrosMontosPrev ?? [];
        $otrosRubrosPrev   = $otrosRubrosPrev  ?? [];

        // Parámetro para las rutas seccionales (usar el id del usuario autenticado)
        $registroId        = $registroId ?? auth()->id();

        // Techo por defecto si no viene desde el controlador
        $montoAsignado     = isset($montoAsignado) ? (float) $montoAsignado : 150000.00;

        // Totales ya guardados para bloqueo en el front (si no vienen desde el controlador)
        $totalRubrosBD     = $totalRubrosBD ?? (\App\Models\RubroSolicitado::where('user_id', auth()->id())->sum('monto') ?: 0);
        $totalOtrosBD      = $totalOtrosBD  ?? (\App\Models\OtroRubro::where('user_id', auth()->id())->sum('monto') ?: 0);
    @endphp

    @include('usuario.rubros-solicitados.form', compact(
        'isEdit',
        'action',
        'montoAsignado',
        'categorias',
        'rubros',
        'rubrosMontosPrev',
        'otrosRubrosPrev',
        'registroId',
        'totalRubrosBD',
        'totalOtrosBD'
    ))
</x-app-layout>
