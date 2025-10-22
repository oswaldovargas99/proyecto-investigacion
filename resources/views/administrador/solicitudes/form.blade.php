<!-- resources/views/administrador/solicitudes/form.blade.php -->

<div class="bg-white shadow-sm rounded-2xl border p-6 space-y-8">

    {{-- ========== Sección 1: Datos Generales ========== --}}
    <section class="rounded-xl border bg-gray-50/50 p-5">
        <header class="mb-4 flex items-center gap-3">
            <div class="h-9 w-9 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center">
                <!-- icon user -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5Zm0 2c-5 0-9 2.5-9 5.5V22h18v-2.5C21 16.5 17 14 12 14Z"/></svg>
            </div>
            <h3 class="text-base font-semibold text-gray-800">Datos Generales</h3>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <!-- Código -->
            <div>
                <label for="codigo" class="block text-sm font-medium text-gray-700">
                    Código <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    name="codigo"
                    id="codigo"
                    value="{{ old('codigo', $coordinador->codigo ?? '') }}"
                    required
                    placeholder="Ej. A12345"
                    class="mt-1 w-full rounded-lg border-gray-300 px-3 py-2
                           focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500"
                >
                <p class="text-xs text-gray-500 mt-1">Identificador único del/la coordinador(a).</p>
                @error('codigo') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Nombre -->
            <div>
                <label for="nombre_coordinador" class="block text-sm font-medium text-gray-700">
                    Nombre del/la Coordinador(a) <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    name="nombre_coordinador"
                    id="nombre_coordinador"
                    value="{{ old('nombre_coordinador', $coordinador->nombre_coordinador ?? '') }}"
                    required
                    placeholder="Nombre completo"
                    class="mt-1 w-full rounded-lg border-gray-300 px-3 py-2
                           focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500"
                >
                <p class="text-xs text-gray-500 mt-1">Tal como aparecerá en documentos oficiales.</p>
                @error('nombre_coordinador') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Centro Universitario -->
            <div>
                <label for="centro_universitario_id" class="block text-sm font-medium text-gray-700">
                    Centro Universitario <span class="text-red-500">*</span>
                </label>
                <select
                    name="centro_universitario_id"
                    id="centro_universitario_id"
                    required
                    class="mt-1 w-full rounded-lg border-gray-300 px-3 py-2 bg-white
                           focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500"
                >
                    <option value="">-- Selecciona --</option>
                    @foreach($centros as $centro)
                        <option value="{{ $centro->id }}"
                            {{ (string)old('centro_universitario_id', $coordinador->centro_universitario_id ?? '') === (string)$centro->id ? 'selected' : '' }}>
                            {{ $centro->centro_universitario }}
                        </option>
                    @endforeach
                </select>
                <p class="text-xs text-gray-500 mt-1">Seleccione el centro al que pertenece.</p>
                @error('centro_universitario_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Posgrado -->
            <div>
                <label for="posgrado_id" class="block text-sm font-medium text-gray-700">
                    Posgrado <span class="text-red-500">*</span>
                </label>
                <select
                    name="posgrado_id"
                    id="posgrado_id"
                    required
                    class="mt-1 w-full rounded-lg border-gray-300 px-3 py-2 bg-white
                           focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500"
                >
                    <option value="">-- Selecciona --</option>
                    @foreach($posgrados as $posgrado)
                        <option value="{{ $posgrado->id }}"
                            {{ (string)old('posgrado_id', $coordinador->posgrado_id ?? '') === (string)$posgrado->id ? 'selected' : '' }}>
                            {{ $posgrado->nombre_posgrado }}
                        </option>
                    @endforeach
                </select>
                <p class="text-xs text-gray-500 mt-1">Programa de posgrado relacionado.</p>
                @error('posgrado_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Género -->
            <div>
                <label for="genero_id" class="block text-sm font-medium text-gray-700">
                    Género <span class="text-red-500">*</span>
                </label>
                <select
                    name="genero_id"
                    id="genero_id"
                    required
                    class="mt-1 w-full rounded-lg border-gray-300 px-3 py-2 bg-white
                           focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500"
                >
                    <option value="">-- Selecciona --</option>
                    @foreach($generos as $g)
                        <option value="{{ $g->id }}"
                            {{ (string)old('genero_id', $coordinador->genero_id ?? '') === (string)$g->id ? 'selected' : '' }}>
                            {{ $g->genero }}
                        </option>
                    @endforeach
                </select>
                <p class="text-xs text-gray-500 mt-1">Elija del catálogo institucional.</p>
                @error('genero_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Nivel de estudios -->
            <div>
                <label for="nivel_estudios_id" class="block text-sm font-medium text-gray-700">
                    Nivel de estudios <span class="text-red-500">*</span>
                </label>
                <select
                    name="nivel_estudios_id"
                    id="nivel_estudios_id"
                    required
                    class="mt-1 w-full rounded-lg border-gray-300 px-3 py-2 bg-white
                           focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500"
                >
                    <option value="">-- Selecciona --</option>
                    @foreach($nivelesEstudios as $n)
                        <option value="{{ $n->id }}"
                            {{ (string)old('nivel_estudios_id', $coordinador->nivel_estudios_id ?? '') === (string)$n->id ? 'selected' : '' }}>
                            {{ $n->nivel_estudios }}
                        </option>
                    @endforeach
                </select>
                <p class="text-xs text-gray-500 mt-1">Último grado académico concluido.</p>
                @error('nivel_estudios_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Fecha de nacimiento -->
            <div>
                <label for="fecha_nacimiento" class="block text-sm font-medium text-gray-700">
                    Fecha de nacimiento <span class="text-red-500">*</span>
                </label>
                @php
                    $fnOld = old('fecha_nacimiento');
                    $fnVal = $fnOld !== null
                        ? $fnOld
                        : (isset($coordinador->fecha_nacimiento) && $coordinador->fecha_nacimiento
                            ? \Illuminate\Support\Carbon::parse($coordinador->fecha_nacimiento)->format('Y-m-d')
                            : '');
                @endphp
                <input
                    type="date"
                    name="fecha_nacimiento"
                    id="fecha_nacimiento"
                    value="{{ $fnVal }}"
                    required
                    class="mt-1 w-full rounded-lg border-gray-300 px-3 py-2
                           focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500"
                >
                <p class="text-xs text-gray-500 mt-1">Formato: AAAA-MM-DD.</p>
                @error('fecha_nacimiento') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
        </div>
    </section>

    {{-- ========== Sección 2: Contacto ========== --}}
    <section class="rounded-xl border bg-gray-50/50 p-5">
        <header class="mb-4 flex items-center gap-3">
            <div class="h-9 w-9 rounded-full bg-sky-100 text-sky-700 flex items-center justify-center">
                <!-- icon mail/phone -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M12 13 2 6.76V18h20V6.76L12 13Zm0-2L2 4h20L12 11Z"/></svg>
            </div>
            <h3 class="text-base font-semibold text-gray-800">Contacto</h3>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label for="correo_institucional" class="block text-sm font-medium text-gray-700">
                    Correo institucional <span class="text-red-500">*</span>
                </label>
                <input
                    type="email"
                    name="correo_institucional"
                    id="correo_institucional"
                    value="{{ old('correo_institucional', $coordinador->correo_institucional ?? '') }}"
                    placeholder="ejemplo@institucion.edu.mx"
                    required
                    class="mt-1 w-full rounded-lg border-gray-300 px-3 py-2
                           focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500"
                >
                <p class="text-xs text-gray-500 mt-1">Use su correo institucional activo.</p>
                @error('correo_institucional') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="correo_alternativo" class="block text-sm font-medium text-gray-700">
                    Correo alternativo
                </label>
                <input
                    type="email"
                    name="correo_alternativo"
                    id="correo_alternativo"
                    value="{{ old('correo_alternativo', $coordinador->correo_alternativo ?? '') }}"
                    placeholder="correo@alternativo.com"
                    class="mt-1 w-full rounded-lg border-gray-300 px-3 py-2
                           focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500"
                >
                <p class="text-xs text-gray-500 mt-1">Opcional, para notificaciones de respaldo.</p>
                @error('correo_alternativo') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="telefono" class="block text-sm font-medium text-gray-700">
                    Teléfono
                </label>
                <input
                    type="text"
                    name="telefono"
                    id="telefono"
                    value="{{ old('telefono', $coordinador->telefono ?? '') }}"
                    placeholder="Ej. 33 1234 5678"
                    class="mt-1 w-full rounded-lg border-gray-300 px-3 py-2
                           focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500"
                >
                <p class="text-xs text-gray-500 mt-1">Incluya lada si aplica.</p>
                @error('telefono') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="extension" class="block text-sm font-medium text-gray-700">
                    Extensión
                </label>
                <input
                    type="text"
                    name="extension"
                    id="extension"
                    value="{{ old('extension', $coordinador->extension ?? '') }}"
                    placeholder="Ej. 1234"
                    class="mt-1 w-full rounded-lg border-gray-300 px-3 py-2
                           focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500"
                >
                <p class="text-xs text-gray-500 mt-1">Solo números.</p>
                @error('extension') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="md:col-span-2">
                <label for="celular" class="block text-sm font-medium text-gray-700">
                    Celular
                </label>
                <input
                    type="text"
                    name="celular"
                    id="celular"
                    value="{{ old('celular', $coordinador->celular ?? '') }}"
                    placeholder="Ej. 33 1234 5678"
                    class="mt-1 w-full rounded-lg border-gray-300 px-3 py-2
                           focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500"
                >
                <p class="text-xs text-gray-500 mt-1">Teléfono móvil de contacto.</p>
                @error('celular') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
        </div>
    </section>

    {{-- ========== Botones ========== --}}
    <div class="flex flex-col sm:flex-row gap-3 sm:justify-between sm:items-center">
        <a href="{{ route('admin.coordinadores.index') }}"
           class="inline-flex items-center justify-center gap-2 bg-gray-700 text-white px-5 py-2.5 rounded-lg hover:bg-gray-800">
            <!-- back icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 -ms-1" viewBox="0 0 24 24" fill="currentColor"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2Z"/></svg>
            <span>Regresar</span>
        </a>

        <button type="submit"
            class="inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-lg text-white
                   {{ isset($coordinador) ? 'bg-yellow-500 hover:bg-yellow-600' : 'bg-green-600 hover:bg-green-700' }}">
            <!-- save icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 -ms-1" viewBox="0 0 24 24" fill="currentColor"><path d="M17 3H5a2 2 0 0 0-2 2v14l4-4h10a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2Z"/></svg>
            <span>{{ isset($coordinador) ? 'Actualizar' : 'Guardar' }}</span>
        </button>
    </div>
</div>
