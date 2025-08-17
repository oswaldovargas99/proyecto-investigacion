<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Panel del Coordinador</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto p-6">
        <p class="text-gray-600">Centro Universitario: (configurar)</p>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
            <a href="{{ route('coordinador.dashboard') }}" class="block rounded-2xl border p-5 hover:shadow">
                <h3 class="font-semibold text-lg">Proyectos por revisar</h3>
                <p class="text-sm text-gray-600">Listar, filtrar y validar.</p>
            </a>
            <a href="#" class="block rounded-2xl border p-5 hover:shadow">
                <h3 class="font-semibold text-lg">Observaciones</h3>
                <p class="text-sm text-gray-600">Emite comentarios.</p>
            </a>
            <a href="#" class="block rounded-2xl border p-5 hover:shadow">
                <h3 class="font-semibold text-lg">Oficios preliminares</h3>
                <p class="text-sm text-gray-600">Generación PDF.</p>
            </a>
        </div>
    </div>
</x-app-layout>

