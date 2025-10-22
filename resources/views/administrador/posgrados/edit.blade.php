<!-- resources/views/administrador/posgrados/edit.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="mt-6 sm:mt-24 text-xl font-semibold text-gray-800 leading-tight">
            Editar Posgrado
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto px-4">
            <div class="bg-white rounded-2xl border shadow-sm p-6">
                <form action="{{ route('admin.posgrados.update', $posgrado) }}" method="POST" novalidate>
                    @csrf
                    @method('PUT')

                    @include('administrador.posgrados.form', [
                        'posgrado'      => $posgrado,
                        'centros'       => $centros,
                        'niveles'       => $niveles,
                        'orientaciones' => $orientaciones,
                        'modalidades'   => $modalidades,
                    ])

                    {{-- 🔸 Sin botones adicionales aquí: el partial `form` ya incluye los únicos botones (Regresar / Actualizar). --}}
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
