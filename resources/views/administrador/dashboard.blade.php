<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Panel del Administrador</h2>
    </x-slot>

    <div class="max-w-7xl mx-auto p-6">
        <p class="text-gray-600">Gestión global del sistema.</p>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
            <a href="#" class="block rounded-2xl border p-5 hover:shadow">
                <h3 class="font-semibold text-lg">Usuarios y Roles</h3>
                <p class="text-sm text-gray-600">CRUD y permisos.</p>
            </a>
            <a href="#" class="block rounded-2xl border p-5 hover:shadow">
                <h3 class="font-semibold text-lg">Catálogos</h3>
                <p class="text-sm text-gray-600">Centros, fondos, ODS...</p>
            </a>
            <a href="#" class="block rounded-2xl border p-5 hover:shadow">
                <h3 class="font-semibold text-lg">Reportes</h3>
                <p class="text-sm text-gray-600">Excel/PDF, métricas.</p>
            </a>
        </div>
    </div>
</x-app-layout>
