<!-- resources/views/administrador/usuarios/form.blade.php -->
<div class="bg-white shadow-sm rounded-2xl border p-6 space-y-8">
    
    {{-- Sección: Datos del Usuario --}}
    <section class="rounded-xl border bg-gray-50/50 p-5">

        <header class="mb-4 flex items-center gap-3">
            <div class="h-9 w-9 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5Zm0 2c-5 0-9 2.5-9 5.5V22h18v-2.5C21 16.5 17 14 12 14Z"/></svg>
            </div>
            <h3 class="text-base font-semibold text-gray-800">
                {{ isset($usuario) ? 'Editar Usuario' : 'Nuevo Usuario' }}
            </h3>
        </header>

        <header class="mb-4 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5Zm0 2c-5 0-9 2.5-9 5.5V22h18v-2.5C21 16.5 17 14 12 14Z"/>
            </svg>
            <h2 class="text-2xl font-bold text-gray-800">
                {{ isset($usuario) ? 'Editar Usuario' : 'Nuevo Usuario' }}
            </h2>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

            {{-- Nombre --}}
            <div class="md:col-span-1">
                <label for="name" class="block text-sm font-medium text-gray-700">
                    Nombre completo <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    value="{{ old('name', $usuario->name ?? '') }}"
                    required
                    placeholder="Nombre y apellidos"
                    class="mt-1 w-full rounded-lg border-gray-300 px-3 py-2
                           focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500">
                <p class="text-xs text-gray-500 mt-1">Tal como aparecerá en el sistema.</p>
                @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Email --}}
            <div class="md:col-span-1">
                <label for="email" class="block text-sm font-medium text-gray-700">
                    Correo electrónico <span class="text-red-500">*</span>
                </label>
                <input
                    type="email"
                    name="email"
                    id="email"
                    value="{{ old('email', $usuario->email ?? '') }}"
                    required
                    placeholder="usuario@dominio.com"
                    class="mt-1 w-full rounded-lg border-gray-300 px-3 py-2
                           focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500">
                <p class="text-xs text-gray-500 mt-1">Se utilizará para iniciar sesión y notificaciones.</p>
                @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Rol --}}
            <div class="md:col-span-1">
                <label for="role" class="block text-sm font-medium text-gray-700">
                    Rol <span class="text-red-500">*</span>
                </label>
                <select
                    name="role"
                    id="role"
                    required
                    class="mt-1 w-full rounded-lg border-gray-300 px-3 py-2 bg-white
                           focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500">
                    @php $roles = [1 => 'Usuario', 2 => 'Coordinador', 3 => 'Administrador']; @endphp
                    <option value="">-- Selecciona --</option>
                    @foreach($roles as $key => $label)
                        <option value="{{ $key }}"
                            {{ (string)old('role', $usuario->role ?? '') === (string)$key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                <p class="text-xs text-gray-500 mt-1">Controla permisos y acceso a módulos.</p>
                @error('role') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Estado --}}
            <div class="md:col-span-1">
                <label class="block text-sm font-medium text-gray-700">Estado</label>
                <div class="mt-2 flex items-center gap-3">
                    <input
                        type="hidden" name="is_active" value="0">
                    <label class="inline-flex items-center cursor-pointer select-none">
                        <input type="checkbox" name="is_active" value="1"
                               {{ old('is_active', $usuario->is_active ?? 1) ? 'checked' : '' }}
                               class="peer sr-only">
                        <span class="peer-checked:bg-green-600 peer-checked:after:translate-x-5
                                     after:content-[''] after:block after:h-5 after:w-5 after:rounded-full after:bg-white after:transition
                                     relative inline-block h-6 w-11 rounded-full bg-gray-300 transition"></span>
                        <span class="ms-3 text-sm text-gray-700">Activo</span>
                    </label>
                </div>
                @error('is_active') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Contraseña (crear) --}}
            @if(!isset($usuario))
                <div class="md:col-span-1">
                    <label for="password" class="block text-sm font-medium text-gray-700">
                        Contraseña <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="password"
                        name="password"
                        id="password"
                        required
                        minlength="8"
                        placeholder="Mínimo 8 caracteres"
                        class="mt-1 w-full rounded-lg border-gray-300 px-3 py-2
                               focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500">
                    <p class="text-xs text-gray-500 mt-1">Usa una combinación segura de letras, números y símbolos.</p>
                    @error('password') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="md:col-span-1">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                        Confirmar contraseña <span class="text-red-500">*</span>
                    </label>
                    <input
                        type="password"
                        name="password_confirmation"
                        id="password_confirmation"
                        required
                        minlength="8"
                        class="mt-1 w-full rounded-lg border-gray-300 px-3 py-2
                               focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500">
                    @error('password_confirmation') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
            @endif

        </div>
    </section>

    {{-- Sección: Cambiar contraseña (solo edición) --}}
    @isset($usuario)
        <section x-data="{ open:false }" class="rounded-xl border bg-gray-50/50 p-5">
            <header class="mb-3 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="h-9 w-9 rounded-full bg-amber-100 text-amber-700 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M12 17a2 2 0 1 0-2-2 2 2 0 0 0 2 2zm6-7h-1V7a5 5 0 0 0-10 0v3H6a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8a2 2 0 0 0-2-2Zm-8-3a3 3 0 0 1 6 0v3H10Zm8 13H6v-8h12Z"/></svg>
                    </div>
                    <h3 class="text-base font-semibold text-gray-800">Cambiar contraseña</h3>
                </div>
                <button type="button"
                        @click="open = !open"
                        class="rounded-lg border border-amber-200 bg-white px-3 py-1.5 text-sm text-amber-700 hover:bg-amber-50">
                    <span x-show="!open">Mostrar</span>
                    <span x-show="open">Ocultar</span>
                </button>
            </header>

            <div x-show="open" x-collapse>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">
                            Nueva contraseña
                        </label>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            minlength="8"
                            placeholder="Deja vacío para no cambiar"
                            class="mt-1 w-full rounded-lg border-gray-300 px-3 py-2
                                   focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500">
                        @error('password') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                            Confirmar nueva contraseña
                        </label>
                        <input
                            type="password"
                            name="password_confirmation"
                            id="password_confirmation"
                            minlength="8"
                            class="mt-1 w-full rounded-lg border-gray-300 px-3 py-2
                                   focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500">
                        @error('password_confirmation') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
                <p class="mt-2 text-xs text-gray-500">Si no deseas cambiar la contraseña, deja ambos campos vacíos.</p>
            </div>
        </section>
    @endisset

    {{-- Botones --}}
    <div class="flex flex-col sm:flex-row gap-3 sm:justify-between sm:items-center">
        <a href="{{ route('admin.usuarios.index') }}"
           class="inline-flex items-center justify-center gap-2 bg-gray-700 text-white px-5 py-2.5 rounded-lg hover:bg-gray-800">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 -ms-1" viewBox="0 0 24 24" fill="currentColor"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2Z"/></svg>
            <span>← Regresar</span>
        </a>

        <button type="submit"
            class="inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-lg text-white
                   {{ isset($usuario) ? 'bg-yellow-500 hover:bg-yellow-600' : 'bg-green-600 hover:bg-green-700' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 -ms-1" viewBox="0 0 24 24" fill="currentColor"><path d="M17 3H5a2 2 0 0 0-2 2v14l4-4h10a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2Z"/></svg>
            <span>{{ isset($usuario) ? 'Actualizar' : 'Guardar' }}</span>
        </button>
    </div>
</div>
