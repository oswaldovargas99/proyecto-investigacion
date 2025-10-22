<!-- resources/views/administrador/centros/edit.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="mt-6 sm:mt-24 text-xl font-semibold text-gray-800 leading-tight">
            Editar Centro Universitario
        </h2>
    </x-slot>

    <div class="py-6 px-4 max-w-4xl mx-auto">
        <div class="bg-white shadow rounded p-6">
            <form action="{{ route('admin.centros.update', $centro) }}" method="POST">
            @csrf @method('PUT')
            @include('administrador.centros.form')
            </form>
        </div>
    </div>
</x-app-layout>