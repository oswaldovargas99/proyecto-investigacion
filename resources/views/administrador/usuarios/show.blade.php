<!-- resources/views/administrador/usuarios/show.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="mt-6 sm:mt-24 text-xl font-semibold text-gray-800 leading-tight">
            Detalle del Usuario
        </h2>
    </x-slot>

    @php
        $roles    = [1 => 'Usuario', 2 => 'Coordinador', 3 => 'Administrador'];
        $isActive = (bool) ($usuario->is_active ?? false);

        // Iniciales para el avatar
        $parts = preg_split('/\s+/', trim($usuario->name ?? ''));
        $first = strtoupper(mb_substr($parts[0] ?? '', 0, 1));
        $last  = strtoupper(mb_substr(end($parts) ?: '', 0, 1));
        $initials = ($first ?: 'U') . ($last ?: '');
    @endphp

    <div class="py-6">
        <div class="mx-auto max-w-6xl px-4 space-y-6">

            {{-- === Tarjeta de encabezado (debajo del header) === --}}
            <div class="flex items-center justify-between rounded-2xl border bg-white px-5 py-4 shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-indigo-100 text-indigo-700">
                        <span class="text-sm font-semibold">{{ $initials }}</span>
                    </div>
                    <div>
                        <h3 class="text-base sm:text-lg font-semibold text-gray-900">{{ $usuario->name }}</h3>
                        <p class="text-xs text-gray-500">
                            Código:
                            <span class="font-semibold text-indigo-600">{{ $usuario->id }}</span>
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.usuarios.edit', $usuario) }}"
                       class="inline-flex items-center gap-2 rounded-lg bg-yellow-500 px-3 py-2 text-sm font-semibold text-white hover:bg-yellow-600">
                        <!-- pencil -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 -ms-0.5" viewBox="0 0 24 24" fill="currentColor"><path d="m3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a1.004 1.004 0 0 0 0-1.42l-2.34-2.34a1.004 1.004 0 0 0-1.42 0l-1.83 1.83 3.75 3.75 1.84-1.82z"/></svg>
                        <span>Editar</span>
                    </a>
                    <a href="{{ route('admin.usuarios.index') }}"
                       class="inline-flex items-center gap-2 rounded-lg bg-gray-800 px-3 py-2 text-sm font-semibold text-white hover:bg-gray-900">
                        <!-- back -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 -ms-0.5" viewBox="0 0 24 24" fill="currentColor"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2Z"/></svg>
                        <span>Regresar</span>
                    </a>
                </div>
            </div>

            {{-- === Contenido tipo “cards” === --}}
            <div class="space-y-6">

                {{-- Perfil + Cuenta --}}
                <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                    {{-- Perfil --}}
                    <section class="rounded-2xl border bg-white p-5 shadow-sm">
                        <header class="mb-4 flex items-center gap-3">
                            <div class="h-9 w-9 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center">
                                <!-- user icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5Zm0 2c-5 0-9 2.5-9 5.5V22h18v-2.5C21 16.5 17 14 12 14Z"/></svg>
                            </div>
                            <h3 class="text-base font-semibold text-gray-800">Perfil</h3>
                        </header>

                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Rol</span>
                                <span class="inline-flex items-center rounded-full bg-blue-50 px-2.5 py-0.5 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-200">
                                    {{ $roles[$usuario->role] ?? $usuario->role }}
                                </span>
                            </div>

                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Estado</span>
                                @if($isActive)
                                    <span class="inline-flex items-center rounded-full bg-green-50 px-2.5 py-0.5 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-200">
                                        Activo
                                    </span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-red-50 px-2.5 py-0.5 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-200">
                                        Inactivo
                                    </span>
                                @endif
                            </div>
                        </div>
                    </section>

                    {{-- Cuenta --}}
                    <section class="rounded-2xl border bg-white p-5 shadow-sm">
                        <header class="mb-4 flex items-center gap-3">
                            <div class="h-9 w-9 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center">
                                <!-- inbox icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M19 3H4.99C3.88 3 3 3.89 3 5l-.01 14c0 1.1.89 2 2 2H19c1.1 0 1.99-.9 1.99-2L21 5c0-1.11-.89-2-2-2zm0 14h-4.3c-.39 0-.75.23-.92.59l-.57 1.15H10.8l-.58-1.16c-.17-.35-.53-.58-.92-.58H5V5h14v12z"/></svg>
                            </div>
                            <h3 class="text-base font-semibold text-gray-800">Cuenta</h3>
                        </header>

                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div class="rounded-xl border bg-gray-50 px-4 py-3">
                                <p class="text-[11px] font-semibold tracking-wider text-gray-500">CORREO ELECTRÓNICO</p>
                                <p class="mt-1 text-sm text-gray-800">
                                    <a href="mailto:{{ $usuario->email }}" class="text-indigo-600 hover:text-indigo-800 underline decoration-dotted underline-offset-2">
                                        {{ $usuario->email }}
                                    </a>
                                </p>
                            </div>

                            <div class="rounded-xl border bg-gray-50 px-4 py-3">
                                <p class="text-[11px] font-semibold tracking-wider text-gray-500">VERIFICACIÓN</p>
                                @if($usuario->email_verified_at)
                                    <span class="mt-1 inline-flex items-center rounded-full bg-green-50 px-2.5 py-0.5 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-200">
                                        Verificado el {{ $usuario->email_verified_at->format('d/m/Y H:i') }}
                                    </span>
                                @else
                                    <span class="mt-1 inline-flex items-center rounded-full bg-red-50 px-2.5 py-0.5 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-200">
                                        No verificado
                                    </span>
                                @endif
                            </div>

                            <div class="md:col-span-2 rounded-xl border bg-gray-50 px-4 py-3">
                                <p class="text-[11px] font-semibold tracking-wider text-gray-500">NOTA</p>
                                <p class="mt-1 text-sm text-gray-700">
                                    La contraseña no puede mostrarse por seguridad.
                                </p>
                            </div>
                        </div>
                    </section>
                </div>

                {{-- Metadatos --}}
                <section class="rounded-2xl border bg-white p-5 shadow-sm">
                    <header class="mb-4 flex items-center gap-3">
                        <div class="h-9 w-9 rounded-full bg-sky-100 text-sky-700 flex items-center justify-center">
                            <!-- clock icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2a10 10 0 1 0 .001 20.001A10 10 0 0 0 12 2zm1 11h5v-2h-4V7h-2v6z"/></svg>
                        </div>
                        <h3 class="text-base font-semibold text-gray-800">Metadatos</h3>
                    </header>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                        <div class="rounded-xl border bg-gray-50 px-4 py-3">
                            <p class="text-[11px] font-semibold tracking-wider text-gray-500">CREADO EL</p>
                            <p class="mt-1 text-sm text-gray-800">
                                {{ optional($usuario->created_at)->format('d/m/Y H:i') ?? '—' }}
                            </p>
                        </div>

                        <div class="rounded-xl border bg-gray-50 px-4 py-3">
                            <p class="text-[11px] font-semibold tracking-wider text-gray-500">ACTUALIZADO EL</p>
                            <p class="mt-1 text-sm text-gray-800">
                                {{ optional($usuario->updated_at)->format('d/m/Y H:i') ?? '—' }}
                            </p>
                        </div>

                        <div class="rounded-xl border bg-gray-50 px-4 py-3">
                            <p class="text-[11px] font-semibold tracking-wider text-gray-500">ID DE USUARIO</p>
                            <p class="mt-1 text-sm text-gray-800">#{{ $usuario->id }}</p>
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </div>
</x-app-layout>
