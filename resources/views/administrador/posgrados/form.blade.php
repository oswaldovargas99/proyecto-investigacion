<!-- resources/views/administrador/posgrados/form.blade.php -->
<div class="bg-white shadow-sm rounded-2xl border p-6 space-y-8">

    {{-- ========== Sección 1: Datos Generales ========== --}}
    <section class="rounded-xl border bg-gray-50/50 p-5">
        <header class="mb-4 flex items-center gap-3">
            <div class="h-9 w-9 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center">
                <!-- book icon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M18 2H8C6.9 2 6 2.9 6 4v15a3 3 0 0 1 3-3h10V4a2 2 0 0 0-1-1.73zM9 18c-1.1 0-2 .9-2 2s.9 2 2 2h10v-4H9z"/>
                </svg>
            </div>
            <h3 class="text-base font-semibold text-gray-800">Datos Generales</h3>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            {{-- Clave SNP --}}
            <div>
                <label for="clave_snp" class="block text-sm font-medium text-gray-700">
                    Clave SNP <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    name="clave_snp"
                    id="clave_snp"
                    value="{{ old('clave_snp', $posgrado->clave_snp ?? '') }}"
                    placeholder="Ej. SNP-001"
                    maxlength="50"
                    required
                    oninput="this.value=this.value.toUpperCase().trimStart()"
                    aria-describedby="help_snp"
                    class="mt-1 w-full rounded-lg px-3 py-2 border-gray-300
                           focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 @error('clave_snp') border-red-500 focus:ring-red-500 @enderror">
                <p id="help_snp" class="text-xs text-gray-500 mt-1">Formato alfanumérico en mayúsculas.</p>
                @error('clave_snp') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Nombre del Posgrado --}}
            <div>
                <label for="nombre_posgrado" class="block text-sm font-medium text-gray-700">
                    Nombre del Posgrado <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    name="nombre_posgrado"
                    id="nombre_posgrado"
                    value="{{ old('nombre_posgrado', $posgrado->nombre_posgrado ?? '') }}"
                    placeholder="Ej. Maestría en Ciencias"
                    maxlength="255"
                    required
                    aria-describedby="help_nombre"
                    class="mt-1 w-full rounded-lg px-3 py-2 border-gray-300
                           focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 @error('nombre_posgrado') border-red-500 focus:ring-red-500 @enderror">
                <p id="help_nombre" class="text-xs text-gray-500 mt-1">Nombre oficial del programa.</p>
                @error('nombre_posgrado') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
        </div>
    </section>

    {{-- ========== Sección 2: Académico y Adscripción ========== --}}
    <section class="rounded-xl border bg-gray-50/50 p-5">
        <header class="mb-4 flex items-center gap-3">
            <div class="h-9 w-9 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center">
                <!-- mortarboard -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 3 1 9l11 6 9-4.91V17h2V9L12 3zm0 10.2L4.24 9 12 5.8 19.76 9 12 13.2zM7 12v4c0 2 3 3 5 3s5-1 5-3v-4l-5 2.8L7 12z"/>
                </svg>
            </div>
            <h3 class="text-base font-semibold text-gray-800">Académico y Adscripción</h3>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            {{-- Centro Universitario --}}
            <div>
                <label for="centro_universitario_id" class="block text-sm font-medium text-gray-700">
                    Centro Universitario <span class="text-red-500">*</span>
                </label>
                <select
                    name="centro_universitario_id"
                    id="centro_universitario_id"
                    required
                    class="mt-1 w-full rounded-lg px-3 py-2 border-gray-300 bg-white
                           focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 @error('centro_universitario_id') border-red-500 focus:ring-red-500 @enderror">
                    <option value="">-- Selecciona --</option>
                    @foreach($centros as $centro)
                        <option value="{{ $centro->id }}"
                            @selected((string)old('centro_universitario_id', $posgrado->centro_universitario_id ?? '') === (string)$centro->id)>
                            {{ $centro->centro_universitario }}
                        </option>
                    @endforeach
                </select>
                <p class="text-xs text-gray-500 mt-1">Adscripción institucional del programa.</p>
                @error('centro_universitario_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Nivel Académico --}}
            <div>
                <label for="nivel_academico_id" class="block text-sm font-medium text-gray-700">
                    Nivel Académico <span class="text-red-500">*</span>
                </label>
                <select
                    name="nivel_academico_id"
                    id="nivel_academico_id"
                    required
                    class="mt-1 w-full rounded-lg px-3 py-2 border-gray-300 bg-white
                           focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 @error('nivel_academico_id') border-red-500 focus:ring-red-500 @enderror">
                    <option value="">-- Selecciona --</option>
                    @foreach($niveles as $nivel)
                        <option value="{{ $nivel->id }}"
                            @selected((string)old('nivel_academico_id', $posgrado->nivel_academico_id ?? '') === (string)$nivel->id)>
                            {{ $nivel->nombre }}
                        </option>
                    @endforeach
                </select>
                <p class="text-xs text-gray-500 mt-1">Especialidad, Maestría o Doctorado.</p>
                @error('nivel_academico_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Orientación --}}
            <div>
                <label for="orientacion_posgrado_id" class="block text-sm font-medium text-gray-700">
                    Orientación <span class="text-red-500">*</span>
                </label>
                <select
                    name="orientacion_posgrado_id"
                    id="orientacion_posgrado_id"
                    required
                    class="mt-1 w-full rounded-lg px-3 py-2 border-gray-300 bg-white
                           focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 @error('orientacion_posgrado_id') border-red-500 focus:ring-red-500 @enderror">
                    <option value="">-- Selecciona --</option>
                    @foreach($orientaciones as $orientacion)
                        <option value="{{ $orientacion->id }}"
                            @selected((string)old('orientacion_posgrado_id', $posgrado->orientacion_posgrado_id ?? '') === (string)$orientacion->id)>
                            {{ $orientacion->nombre }}
                        </option>
                    @endforeach
                </select>
                <p class="text-xs text-gray-500 mt-1">Investigación, Profesionalizante, etc.</p>
                @error('orientacion_posgrado_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Modalidad --}}
            <div>
                <label for="modalidad_posgrado_id" class="block text-sm font-medium text-gray-700">
                    Modalidad <span class="text-red-500">*</span>
                </label>
                <select
                    name="modalidad_posgrado_id"
                    id="modalidad_posgrado_id"
                    required
                    class="mt-1 w-full rounded-lg px-3 py-2 border-gray-300 bg-white
                           focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 @error('modalidad_posgrado_id') border-red-500 focus:ring-red-500 @enderror">
                    <option value="">-- Selecciona --</option>
                    @foreach($modalidades as $modalidad)
                        <option value="{{ $modalidad->id }}"
                            @selected((string)old('modalidad_posgrado_id', $posgrado->modalidad_posgrado_id ?? '') === (string)$modalidad->id)>
                            {{ $modalidad->nombre }}
                        </option>
                    @endforeach
                </select>
                <p class="text-xs text-gray-500 mt-1">Escolarizada, Mixta, No escolarizada…</p>
                @error('modalidad_posgrado_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
        </div>
    </section>

    {{-- ========== Botones (únicos) ========== --}}
    <div class="flex flex-col sm:flex-row gap-3 sm:justify-between sm:items-center">
        <a href="{{ route('admin.posgrados.index') }}"
           class="inline-flex items-center justify-center gap-2 bg-gray-700 text-white px-5 py-2.5 rounded-lg hover:bg-gray-800">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 -ms-1" viewBox="0 0 24 24" fill="currentColor">
                <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2Z"/>
            </svg>
            <span>Regresar</span>
        </a>

        <button type="submit"
            class="inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-lg text-white
                   {{ isset($posgrado) ? 'bg-yellow-500 hover:bg-yellow-600' : 'bg-green-600 hover:bg-green-700' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 -ms-1" viewBox="0 0 24 24" fill="currentColor">
                <path d="M17 3H5a2 2 0 0 0-2 2v14l4-4h10a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2Z"/>
            </svg>
            <span>{{ isset($posgrado) ? 'Actualizar' : 'Guardar' }}</span>
        </button>
    </div>

</div>
