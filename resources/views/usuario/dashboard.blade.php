<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Panel del Usuario</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto p-6">
        <p class="text-gray-600">Bienvenido, {{ auth()->user()->name }}.</p>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
            <a href="{{ route('usuario.dashboard') }}" class="block rounded-2xl border p-5 hover:shadow">
                <h3 class="font-semibold text-lg">Mis Proyectos</h3>
                <p class="text-sm text-gray-600">Crear y dar seguimiento.</p>
            </a>
            <a href="#" class="block rounded-2xl border p-5 hover:shadow">
                <h3 class="font-semibold text-lg">Documentos Adjuntos</h3>
                <p class="text-sm text-gray-600">Sube y gestiona PDFs.</p>
            </a>
            <a href="#" class="block rounded-2xl border p-5 hover:shadow">
                <h3 class="font-semibold text-lg">Reportes</h3>
                <p class="text-sm text-gray-600">PDF/Excel.</p>
            </a>
        </div>
    </div>
</x-app-layout>
