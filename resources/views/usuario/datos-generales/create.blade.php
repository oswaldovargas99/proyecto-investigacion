{{-- resources/views/usuario/datos-generales/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="mt-6 sm:mt-24 text-xl font-semibold text-gray-800 leading-tight">
            Crear Datos Generales
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto bg-white p-6 rounded shadow">
            @if ($errors->any())
                <div class="mb-4 p-4 rounded bg-red-100 text-red-800 border border-red-300">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @php
                // Asegura que $prefill exista como stdClass para evitar "undefined"
                if (!isset($prefill) || !is_object($prefill)) {
                    $prefill = (object)[];
                }
            @endphp

            <form action="{{ route('usuario.datos-generales.store') }}" method="POST">
                @csrf

                {{-- Pasa $row = null y $prefill al form parcial --}}
                @include('usuario.datos-generales.form', [
                    'row' => null,
                    'prefill' => $prefill,
                ])

                <div class="mt-6">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
