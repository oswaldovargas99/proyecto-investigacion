<!-- resources/views/administrador/usuarios/index.blade.php -->
{{-- BLOQUE SIN TITULO --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-lg sm:text-xl font-semibold text-gray-800">

        </h2>
    </x-slot>

    {{-- Título y botón debajo del header --}}
    <div class="max-w-7xl mx-auto px-4 mt-20 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                <!-- Usuario -->
                <path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm-6 8v-1c0-3.31 3.13-6 6-6s6 2.69 6 6v1H6z"/>
                <!-- Engrane -->
                <path d="M19.14 12.94l1.43-.82-1-1.73-1.64.28a5 5 0 0 0-1.02-.6l-.25-1.66h-2l-.25 1.66c-.36.16-.7.36-1.02.6l-1.64-.28-1 1.73 1.43.82c-.02.31-.02.63 0 .94l-1.43.82 1 1.73 1.64-.28c.32.24.66.44 1.02.6l.25 1.66h2l.25-1.66c.36-.16.7-.36 1.02-.6l1.64.28 1-1.73-1.43-.82c.02-.31.02-.63 0-.94zM16 15a2 2 0 1 1 .001-4.001A2 2 0 0 1 16 15z"/>
            </svg>
            Gestión de Usuarios
        </h2>

        <a href="{{ route('admin.usuarios.create') }}"
           class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-3 py-2 text-sm font-semibold text-white hover:bg-blue-700 shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 -ms-0.5" viewBox="0 0 24 24" fill="currentColor">
                <path d="M11 11V6h2v5h5v2h-5v5h-2v-5H6v-2h5z"/>
            </svg>
            Nuevo Usuario
        </a>
    </div>

    <div class="py-6">
        <div class="mx-auto max-w-7xl px-4">

            {{-- Alerts (auto-dismiss 5s) --}}
            @if(session('success') || session('warning') || session('danger') || session('error') || session('status'))
                @php
                    $msg  = session('success') ?? session('warning') ?? session('danger') ?? session('error') ?? session('status');
                    $type = session('success') ? 'green'
                           : (session('warning') ? 'yellow'
                           : (session('status') ? 'blue' : 'red'));
                @endphp
                
                <div x-data="{ show: true }"
                     x-init="setTimeout(() => show = false, 5000)"
                     x-show="show"
                     x-transition.opacity.duration.400ms
                     role="alert"
                     class="mb-4 flex items-center gap-2 rounded-lg border px-4 py-3
                            bg-{{ $type }}-50 text-{{ $type }}-800 border-{{ $type }}-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2a10 10 0 1 0 .001 20.001A10 10 0 0 0 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
                    <span class="text-sm">{{ $msg }}</span>
                </div>
            @endif

            {{-- Toolbar: búsqueda + resumen --}}
            <div class="mb-4 rounded-xl border bg-white p-4">
                <form method="GET" action="{{ route('admin.usuarios.index') }}" class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex w-full items-center gap-2 sm:max-w-md">
                        <div class="relative w-full">
                            <input
                                type="text"
                                name="q"
                                value="{{ request('q') }}"
                                placeholder="Buscar por nombre, email o rol…"
                                class="w-full rounded-lg border-gray-300 pl-9 pr-9 py-2 text-sm
                                       focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500" />
                            <span class="pointer-events-none absolute inset-y-0 left-2 flex items-center text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="m20.94 19.54-4.28-4.28A7.94 7.94 0 1 0 16 17.66l4.28 4.28 1.66-1.66ZM4 10a6 6 0 1 1 12 0A6 6 0 0 1 4 10Z"/></svg>
                            </span>
                            @if(request('q'))
                                <a href="{{ route('admin.usuarios.index') }}"
                                   class="absolute inset-y-0 right-2 flex items-center text-gray-400 hover:text-gray-600"
                                   title="Limpiar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="m13.41 12 4.3-4.29-1.42-1.42L12 10.59 7.71 6.29 6.29 7.71 10.59 12l-4.3 4.29 1.42 1.42L12 13.41l4.29 4.3 1.42-1.42z"/></svg>
                                </a>
                            @endif
                        </div>

                        <button type="submit"
                                class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-3 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 -ms-0.5" viewBox="0 0 24 24" fill="currentColor"><path d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5 6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79L20 21.5 21.5 20l-6-6zM9.5 14C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/></svg>
                            Buscar
                        </button>
                    </div>

                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        @if(request('q'))
                            <span class="inline-flex items-center gap-1 rounded-full bg-gray-100 px-2.5 py-1 text-xs">
                                <span class="font-medium text-gray-700">Filtro:</span>
                                <span class="text-gray-600">"{{ request('q') }}"</span>
                            </span>
                        @endif
                        <span class="hidden sm:inline">Mostrando</span>
                        <span class="font-semibold">{{ $users->firstItem() ?? 0 }}–{{ $users->lastItem() ?? 0 }}</span>
                        <span class="hidden sm:inline">de</span>
                        <span class="font-semibold">{{ $users->total() }}</span>
                        <span class="hidden sm:inline">resultados</span>
                    </div>
                </form>
            </div>

            {{-- Tabla --}}
            @php
                $roles = [1 => 'Usuario', 2 => 'Coordinador', 3 => 'Administrador'];
            @endphp

            <div class="overflow-x-auto rounded-xl border bg-white">
                <table class="min-w-full text-sm">
                    <thead class="sticky top-0 z-10 bg-gray-50/80 backdrop-blur">
                        <tr class="text-left text-gray-700">
                            <th class="px-4 py-3 font-semibold">#</th>
                            <th class="px-4 py-3 font-semibold">Nombre</th>
                            <th class="px-4 py-3 font-semibold">Email</th>
                            <th class="px-4 py-3 font-semibold">Rol</th>
                            <th class="px-4 py-3 font-semibold">Estado</th>
                            <th class="px-4 py-3 text-center font-semibold">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($users as $usuario)
                            <tr class="hover:bg-gray-50/80">
                                <td class="px-4 py-3">
                                    {{ $users->firstItem() ? $loop->iteration + ($users->firstItem() - 1) : $loop->iteration }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="font-medium text-gray-900">{{ $usuario->name }}</div>
                                    <div class="text-xs text-gray-500">ID: {{ $usuario->id }}</div>
                                </td>
                                <td class="px-4 py-3">
                                    <a href="mailto:{{ $usuario->email }}"
                                       class="text-indigo-600 hover:text-indigo-800 underline decoration-dotted underline-offset-2">
                                        {{ $usuario->email }}
                                    </a>
                                </td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-200">
                                        {{ $roles[$usuario->role] ?? $usuario->role }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    @if($usuario->is_active)
                                        <span class="inline-flex items-center rounded-full bg-green-50 px-2.5 py-0.5 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-200">
                                            Activo
                                        </span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-red-50 px-2.5 py-0.5 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-200">
                                            Inactivo
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <a href="{{ route('admin.usuarios.show', $usuario) }}"
                                           title="Ver"
                                           class="inline-flex items-center gap-1 rounded-md border border-gray-200 bg-white px-2 py-1 text-xs text-gray-700 hover:bg-gray-50">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 6C7 6 2.73 9.11 1 14c1.73 4.89 6 8 11 8s9.27-3.11 11-8c-1.73-4.89-6-8-11-8zm0 13a5 5 0 1 1 .001-10.001A5 5 0 0 1 12 19zm0-8a3 3 0 1 0 .001 6.001A3 3 0 0 0 12 11z"/></svg>
                                            Ver
                                        </a>

                                        <a href="{{ route('admin.usuarios.edit', $usuario) }}"
                                           title="Editar"
                                           class="inline-flex items-center gap-1 rounded-md bg-blue-600 px-2 py-1 text-xs font-medium text-white hover:bg-blue-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="m3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a1.004 1.004 0 0 0 0-1.42l-2.34-2.34a1.004 1.004 0 0 0-1.42 0l-1.83 1.83 3.75 3.75 1.84-1.82z"/></svg>
                                            Editar
                                        </a>

                                        <div x-data="{ open:false }" class="inline-block">
                                            <button type="button"
                                                    @click="open=true"
                                                    title="Eliminar"
                                                    class="inline-flex items-center gap-1 rounded-md bg-red-600 px-2 py-1 text-xs font-medium text-white hover:bg-red-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor"><path d="M6 7h12v2H6zm2 3h2v8H8zm6 0h2v8h-2z"/><path d="M15.5 4 14 3H10L8.5 4H5v2h14V4z"/></svg>
                                                Eliminar
                                            </button>

                                            <div x-show="open" x-cloak class="fixed inset-0 z-50 flex items-center justify-center">
                                                <div class="absolute inset-0 bg-black/40" @click="open=false"></div>
                                                <div class="relative w-full max-w-sm rounded-xl bg-white p-5 shadow-lg">
                                                    <div class="mb-3 flex items-center gap-2">
                                                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-red-100 text-red-600">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M11 7h2v8h-2zm0 10h2v2h-2z"/><path d="M12 2a10 10 0 1 0 .001 20.001A10 10 0 0 0 12 2z"/></svg>
                                                        </div>
                                                        <h3 class="text-sm font-semibold text-gray-800">Confirmar eliminación</h3>
                                                    </div>
                                                    <p class="mb-4 text-sm text-gray-600">
                                                        ¿Deseas eliminar al usuario <span class="font-medium">{{ $usuario->name }}</span>?
                                                    </p>
                                                    <div class="flex justify-end gap-2">
                                                        <button type="button"
                                                                @click="open=false"
                                                                class="inline-flex items-center rounded-md border border-gray-200 bg-white px-3 py-1.5 text-sm text-gray-700 hover:bg-gray-50">
                                                            Cancelar
                                                        </button>
                                                        <form action="{{ route('admin.usuarios.destroy', $usuario) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                    class="inline-flex items-center rounded-md bg-red-600 px-3 py-1.5 text-sm font-semibold text-white hover:bg-red-700">
                                                                Eliminar
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-10 text-center text-sm text-gray-500">
                                    <div class="mx-auto mb-2 h-10 w-10 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M19 3H4.99C3.88 3 3 3.89 3 5l-.01 14c0 1.1.89 2 2 2H19c1.1 0 1.99-.9 1.99-2L21 5c0-1.11-.89-2-2-2zm0 14h-4.3c-.39 0-.75.23-.92.59l-.57 1.15H10.8l-.58-1.16c-.17-.35-.53-.58-.92-.58H5V5h14v12z"/></svg>
                                    </div>
                                    No hay usuarios registrados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Paginación + resumen --}}
            <div class="mt-4 flex flex-col items-center justify-between gap-2 sm:flex-row">
                <div class="text-sm text-gray-600">
                    Mostrando
                    <span class="font-semibold">{{ $users->firstItem() ?? 0 }}</span>
                    a
                    <span class="font-semibold">{{ $users->lastItem() ?? 0 }}</span>
                    de
                    <span class="font-semibold">{{ $users->total() }}</span>
                    registros
                </div>
                <div>
                    {{ $users->onEachSide(1)->links('vendor.pagination.pretty') }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
