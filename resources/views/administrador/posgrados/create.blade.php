<!-- resources/views/administrador/posgrados/create.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="mt-6 sm:mt-24 text-xl font-semibold text-gray-800 leading-tight">
            Crear Posgrado
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto px-4">
            <div class="bg-white rounded-2xl border shadow-sm p-6">
                <form action="{{ route('admin.posgrados.store') }}" method="POST" novalidate>
                    @csrf

                    @include('administrador.posgrados.form', [
                        'posgrado'      => null,
                        'centros'       => $centros,
                        'niveles'       => $niveles,
                        'orientaciones' => $orientaciones,
                        'modalidades'   => $modalidades,
                    ])

                    {{-- 🔸 Sin botones extra aquí: el form incluye los únicos botones (Regresar / Guardar) --}}
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
