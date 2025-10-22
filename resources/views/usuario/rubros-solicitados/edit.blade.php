{{-- resources/views/usuario/rubros-solicitados/edit.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="mt-6 sm:mt-24 text-xl font-semibold text-gray-800 leading-tight">
            Edición de Rubros
        </h2>
    </x-slot>

    @php
        // Mantener la estructura original y añadir compatibilidad con las nuevas rutas seccionales
        $isEdit            = true;
        $action            = route('usuario.rubros-solicitados.update', $registroId ?? auth()->id()); // el partial lo ignora (usa rutas seccionales)
        $rubrosMontosPrev  = $rubrosMontosPrev ?? [];
        $otrosRubrosPrev   = $otrosRubrosPrev  ?? [];

        // Parámetro para rutas seccionales (id del usuario autenticado)
        $registroId        = $registroId ?? auth()->id();

        // Monto asignado con valor por defecto si no viene desde el controlador
        $montoAsignado     = isset($montoAsignado) ? (float) $montoAsignado : 150000.00;

        // Totales persistidos para bloqueo del botón en el front
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

