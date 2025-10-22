<!-- resources/views/administrador/usuarios/edit.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="mt-6 sm:mt-24 text-xl font-semibold text-gray-800 leading-tight">
            Editar Usuario
        </h2>
    </x-slot>

    <div class="py-6 px-4 max-w-4xl mx-auto">
        <div class="bg-white shadow rounded p-6">
            <form action="{{ route('admin.usuarios.update', $usuario) }}" method="POST">
            @csrf @method('PUT')
            @include('administrador.usuarios.form')
            </form>
        </div>
    </div>
</x-app-layout>