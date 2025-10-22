<div class="bg-white shadow-sm rounded-2xl border p-6 space-y-8">

    {{-- ========== Sección 1: Datos Generales ========== --}}
    <section class="rounded-xl border bg-gray-50/50 p-5">
        <header class="mb-4 flex items-center gap-3">
            <div class="h-9 w-9 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center">
                <!-- campus icon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M12 3 2 9l10 6 8-4.8V17h2V9L12 3zm-1 14H5v2h6v-2zm8 0h-6v2h6v-2z"/></svg>
            </div>
            <h3 class="text-base font-semibold text-gray-800">Datos Generales</h3>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            {{-- Rector --}}
            <div>
                <label for="nombre_rector" class="block text-sm font-medium text-gray-700">
                    Nombre del Rector(a) <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    name="nombre_rector"
                    id="nombre_rector"
                    value="{{ old('nombre_rector', $centro->nombre_rector ?? '') }}"
                    required
                    placeholder="Ej. Dra. María López"
                    class="mt-1 w-full rounded-lg border-gray-300 px-3 py-2
                           focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500">
                <p class="text-xs text-gray-500 mt-1">Responsable del Centro Universitario.</p>
                @error('nombre_rector') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Tipo --}}
            <div>
                <label for="tipo_centro_universitario" class="block text-sm font-medium text-gray-700">
                    Tipo de Centro <span class="text-red-500">*</span>
                </label>
                <select
                    name="tipo_centro_universitario"
                    id="tipo_centro_universitario"
                    required
                    class="mt-1 w-full rounded-lg border-gray-300 px-3 py-2 bg-white
                           focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500">
                    <option value="">-- Selecciona --</option>
                    <option value="Centro Universitario Metropolitano"
                        {{ old('tipo_centro_universitario', $centro->tipo_centro_universitario ?? '') === 'Centro Universitario Metropolitano' ? 'selected' : '' }}>
                        Centro Universitario Metropolitano
                    </option>
                    <option value="Centro Universitario Regional"
                        {{ old('tipo_centro_universitario', $centro->tipo_centro_universitario ?? '') === 'Centro Universitario Regional' ? 'selected' : '' }}>
                        Centro Universitario Regional
                    </option>
                </select>
                <p class="text-xs text-gray-500 mt-1">Clasificación administrativa.</p>
                @error('tipo_centro_universitario') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Nombre del Centro --}}
            <div class="md:col-span-1">
                <label for="centro_universitario" class="block text-sm font-medium text-gray-700">
                    Nombre del Centro <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    name="centro_universitario"
                    id="centro_universitario"
                    value="{{ old('centro_universitario', $centro->centro_universitario ?? '') }}"
                    required
                    placeholder="Ej. Centro Universitario de la Costa"
                    class="mt-1 w-full rounded-lg border-gray-300 px-3 py-2
                           focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500">
                @error('centro_universitario') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Siglas --}}
            <div>
                <label for="siglas" class="block text-sm font-medium text-gray-700">
                    Siglas <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    name="siglas"
                    id="siglas"
                    value="{{ old('siglas', $centro->siglas ?? '') }}"
                    required
                    maxlength="50"
                    oninput="this.value=this.value.toUpperCase()"
                    placeholder="Ej. CUC, CUCEA, CUALTOS"
                    class="mt-1 w-full rounded-lg border-gray-300 px-3 py-2 uppercase
                           focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500">
                <p class="text-xs text-gray-500 mt-1">Se mostrará como identificador (en mayúsculas).</p>
                @error('siglas') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Teléfonos --}}
            <div>
                <label for="telefonos" class="block text-sm font-medium text-gray-700">
                    Teléfonos <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    name="telefonos"
                    id="telefonos"
                    value="{{ old('telefonos', $centro->telefonos ?? '') }}"
                    required
                    placeholder="Ej. 33 1234 5678 / 33 8765 4321"
                    class="mt-1 w-full rounded-lg border-gray-300 px-3 py-2
                           focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500">
                @error('telefonos') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Sitio Web --}}
            <div>
                <label for="sitio_web" class="block text-sm font-medium text-gray-700">
                    Sitio Web
                </label>
                <input
                    type="url"
                    name="sitio_web"
                    id="sitio_web"
                    value="{{ old('sitio_web', $centro->sitio_web ?? '') }}"
                    placeholder="https://ejemplo.udg.mx"
                    class="mt-1 w-full rounded-lg border-gray-300 px-3 py-2
                           focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500">
                @error('sitio_web') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Vigente (switch) --}}
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700">¿Vigente? <span class="text-red-500">*</span></label>
                <div class="mt-2">
                    <input type="hidden" name="vigente" value="0">
                    <label class="inline-flex items-center cursor-pointer select-none">
                        <input type="checkbox" name="vigente" value="1"
                               {{ old('vigente', $centro->vigente ?? 1) ? 'checked' : '' }}
                               class="peer sr-only">
                        <span class="relative inline-block h-6 w-11 rounded-full bg-gray-300 transition
                                     after:absolute after:left-0.5 after:top-0.5 after:h-5 after:w-5 after:rounded-full after:bg-white after:transition
                                     peer-checked:bg-green-600 peer-checked:after:translate-x-5"></span>
                        <span class="ms-3 text-sm text-gray-700">Activo en catálogo</span>
                    </label>
                </div>
                @error('vigente') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
        </div>
    </section>

    {{-- ========== Sección 2: Ubicación ========== --}}
    <section class="rounded-xl border bg-gray-50/50 p-5">
        <header class="mb-4 flex items-center gap-3">
            <div class="h-9 w-9 rounded-full bg-sky-100 text-sky-700 flex items-center justify-center">
                <!-- location icon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2a7 7 0 0 0-7 7c0 5.25 7 13 7 13s7-7.75 7-13a7 7 0 0 0-7-7zm0 9.5A2.5 2.5 0 1 1 12 6a2.5 2.5 0 0 1 0 5z"/></svg>
            </div>
            <h3 class="text-base font-semibold text-gray-800">Ubicación</h3>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label for="direccion" class="block text-sm font-medium text-gray-700">
                    Dirección <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    name="direccion"
                    id="direccion"
                    value="{{ old('direccion', $centro->direccion ?? '') }}"
                    required
                    placeholder="Calle, número, colonia"
                    class="mt-1 w-full rounded-lg border-gray-300 px-3 py-2
                           focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500">
                @error('direccion') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="colonia" class="block text-sm font-medium text-gray-700">
                    Colonia <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    name="colonia"
                    id="colonia"
                    value="{{ old('colonia', $centro->colonia ?? '') }}"
                    required
                    class="mt-1 w-full rounded-lg border-gray-300 px-3 py-2
                           focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500">
                @error('colonia') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="codigo_postal" class="block text-sm font-medium text-gray-700">
                    Código Postal <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    name="codigo_postal"
                    id="codigo_postal"
                    value="{{ old('codigo_postal', $centro->codigo_postal ?? '') }}"
                    required
                    class="mt-1 w-full rounded-lg border-gray-300 px-3 py-2
                           focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500">
                @error('codigo_postal') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="municipio" class="block text-sm font-medium text-gray-700">
                    Municipio <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    name="municipio"
                    id="municipio"
                    value="{{ old('municipio', $centro->municipio ?? '') }}"
                    required
                    class="mt-1 w-full rounded-lg border-gray-300 px-3 py-2
                           focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500">
                @error('municipio') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="estado" class="block text-sm font-medium text-gray-700">
                    Estado <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    name="estado"
                    id="estado"
                    value="{{ old('estado', $centro->estado ?? 'Jalisco') }}"
                    readonly
                    class="mt-1 w-full rounded-lg border-gray-300 px-3 py-2 bg-gray-100 cursor-not-allowed
                           focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500">
                @error('estado') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="pais" class="block text-sm font-medium text-gray-700">
                    País <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    name="pais"
                    id="pais"
                    value="{{ old('pais', $centro->pais ?? 'México') }}"
                    readonly
                    class="mt-1 w-full rounded-lg border-gray-300 px-3 py-2 bg-gray-100 cursor-not-allowed
                           focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500">
                @error('pais') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
        </div>
    </section>

    {{-- ========== Botones ========== --}}
    <div class="flex flex-col sm:flex-row gap-3 sm:justify-between sm:items-center">
        <a href="{{ route('admin.centros.index') }}"
           class="inline-flex items-center justify-center gap-2 bg-gray-700 text-white px-5 py-2.5 rounded-lg hover:bg-gray-800">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 -ms-1" viewBox="0 0 24 24" fill="currentColor"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2Z"/></svg>
            <span>← Regresar</span>
        </a>

        <button type="submit"
            class="inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-lg text-white
                   {{ isset($centro) ? 'bg-yellow-500 hover:bg-yellow-600' : 'bg-green-600 hover:bg-green-700' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 -ms-1" viewBox="0 0 24 24" fill="currentColor"><path d="M17 3H5a2 2 0 0 0-2 2v14l4-4h10a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2Z"/></svg>
            <span>{{ isset($centro) ? 'Actualizar' : 'Guardar' }}</span>
        </button>
    </div>

</div>
