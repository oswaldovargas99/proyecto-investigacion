<!-- resources/views/usuario/informes/form.blade.php -->
@php
    $informe           = $informe ?? null;
    $categoriasMejora  = $categoriasMejora  ?? collect();
    $tiposBeneficiario = $tiposBeneficiario ?? collect();

    $selectedCategoria = old('categoria_mejora_id', $informe->categoria_mejora_id ?? '');
    $selectedCriterio  = old('criterio_snp_id',    $informe->criterio_snp_id    ?? '');
    $selectedTipoBen   = old('tipo_beneficiario_id', $informe->tipo_beneficiario_id ?? '');
@endphp

<div class="rounded-2xl border bg-white shadow-sm">
    <div x-data="{ a1:true, a2:true }" class="space-y-4 p-4">

        {{-- ========== Bloque 1: Datos del Informe ========== --}}
        <section class="rounded-xl border bg-white overflow-hidden">
            <button type="button"
                    class="w-full flex items-center justify-between px-5 py-4 text-left hover:bg-gray-50"
                    @click="a1 = !a1">
                <div class="flex items-center gap-3">
                    <div class="h-9 w-9 rounded-full bg-indigo-50 text-indigo-700 ring-1 ring-inset ring-indigo-200 flex items-center justify-center">
                        <!-- icono doc -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M14 2H6a2 2 0 0 0-2 2v16l4-4h6a2 2 0 0 0 2-2V2z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-gray-800">Datos del Informe</h3>
                        <p class="text-xs text-gray-500">Completa la información general.</p>
                    </div>
                </div>
                <svg x-show="!a1" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 rotate-0 transition-transform text-gray-500" viewBox="0 0 24 24" fill="currentColor"><path d="M7 10l5 5 5-5"/></svg>
                <svg x-show="a1"  xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 rotate-180 transition-transform text-gray-500" viewBox="0 0 24 24" fill="currentColor"><path d="M7 10l5 5 5-5"/></svg>
            </button>

            <div x-show="a1" x-collapse class="p-5 border-t">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Fecha --}}
                    <div>
                        <label for="fecha" class="block text-sm font-medium text-gray-700">Fecha <span class="text-red-500">*</span></label>
                        <input type="date" id="fecha" name="fecha"
                               value="{{ old('fecha', optional($informe)->fecha ? \Illuminate\Support\Carbon::parse($informe->fecha)->format('Y-m-d') : '') }}"
                               class="w-full rounded-lg border-gray-300 px-3 py-2 text-sm
                                      focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500
                                      @error('fecha') !border-red-500 !ring-red-500 @enderror"
                               required>
                        @error('fecha') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Tipo de Beneficiario --}}
                    <div>
                        <label for="tipo_beneficiario_id" class="block text-sm font-medium text-gray-700">Tipo de Beneficiario</label>
                        <select name="tipo_beneficiario_id" id="tipo_beneficiario_id"
                                class="w-full rounded-lg border-gray-300 bg-white py-2 pl-3 pr-8 text-sm
                                       focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500
                                       @error('tipo_beneficiario_id') !border-red-500 !ring-red-500 @enderror">
                            <option value="">-- Selecciona --</option>
                            @foreach ($tiposBeneficiario as $tb)
                                <option value="{{ $tb->id }}" @selected($selectedTipoBen == $tb->id)>{{ $tb->nombre }}</option>
                            @endforeach
                        </select>
                        @error('tipo_beneficiario_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Categoría Mejora --}}
                    <div>
                        <label for="categoria_mejora_id" class="block text-sm font-medium text-gray-700">Categoría Mejora <span class="text-red-500">*</span></label>
                        <select name="categoria_mejora_id" id="categoria_mejora_id"
                                class="w-full rounded-lg border-gray-300 bg-white py-2 pl-3 pr-8 text-sm
                                       focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500
                                       @error('categoria_mejora_id') !border-red-500 !ring-red-500 @enderror"
                                required>
                            <option value="">-- Selecciona --</option>
                            @foreach ($categoriasMejora as $cat)
                                <option value="{{ $cat->id }}" @selected($selectedCategoria == $cat->id)>{{ $cat->nombre }}</option>
                            @endforeach
                        </select>
                        @error('categoria_mejora_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Criterio SNP --}}
                    <div>
                        <label for="criterio_snp_id" class="block text-sm font-medium text-gray-700">Criterio SNP <span class="text-red-500">*</span></label>
                        <select name="criterio_snp_id" id="criterio_snp_id"
                                class="w-full rounded-lg border-gray-300 bg-white py-2 pl-3 pr-8 text-sm
                                       focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500
                                       @error('criterio_snp_id') !border-red-500 !ring-red-500 @enderror"
                                required>
                            <option value="">
                                {{ $selectedCategoria ? '— Cargando… —' : '— Selecciona una categoría —' }}
                            </option>
                        </select>
                        @error('criterio_snp_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Número de Beneficiarios --}}
                    <div>
                        <label for="numero_beneficiario" class="block text-sm font-medium text-gray-700">Número de Beneficiarios</label>
                        <input type="number" id="numero_beneficiario" name="numero_beneficiario"
                               value="{{ old('numero_beneficiario', $informe->numero_beneficiario ?? '') }}"
                               class="w-full rounded-lg border-gray-300 px-3 py-2 text-sm
                                      focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500
                                      @error('numero_beneficiario') !border-red-500 !ring-red-500 @enderror"
                               min="0">
                        @error('numero_beneficiario') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Monto Destinado --}}
                    <div>
                        <label for="monto_destinado" class="block text-sm font-medium text-gray-700">Monto Destinado</label>
                        <input type="number" step="0.01" id="monto_destinado" name="monto_destinado"
                               value="{{ old('monto_destinado', $informe->monto_destinado ?? '') }}"
                               class="w-full rounded-lg border-gray-300 px-3 py-2 text-sm
                                      focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500
                                      @error('monto_destinado') !border-red-500 !ring-red-500 @enderror"
                               min="0">
                        @error('monto_destinado') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                </div>
            </div>
        </section>

        {{-- ========== Bloque 2: Contenido del Informe ========== --}}
        <section class="rounded-xl border bg-white overflow-hidden">
            <button type="button"
                    class="w-full flex items-center justify-between px-5 py-4 text-left hover:bg-gray-50"
                    @click="a2 = !a2">
                <div class="flex items-center gap-3">
                    <div class="h-9 w-9 rounded-full bg-gray-100 text-gray-700 ring-1 ring-inset ring-gray-200 flex items-center justify-center">
                        <!-- icono texto -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M4 4h16v2H4zm0 6h10v2H4zm0 6h16v2H4z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-gray-800">Contenido del Informe</h3>
                        <p class="text-xs text-gray-500">Describe impactos, conceptos y actividades.</p>
                    </div>
                </div>
                <svg x-show="!a2" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 rotate-0 transition-transform text-gray-500" viewBox="0 0 24 24" fill="currentColor"><path d="M7 10l5 5 5-5"/></svg>
                <svg x-show="a2"  xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 rotate-180 transition-transform text-gray-500" viewBox="0 0 24 24" fill="currentColor"><path d="M7 10l5 5 5-5"/></svg>
            </button>

            <div x-show="a2" x-collapse class="p-5 border-t">
                <div class="grid grid-cols-1 gap-6">

                    {{-- Impacto Académico --}}
                    <div>
                        <label for="impacto_academico" class="block text-sm font-medium text-gray-700">Impacto Académico <span class="text-red-500">*</span></label>
                        <textarea id="impacto_academico" name="impacto_academico" rows="3" maxlength="1000" required
                                  class="w-full rounded-lg border-gray-300 px-3 py-2 text-sm
                                         focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500
                                         @error('impacto_academico') !border-red-500 !ring-red-500 @enderror">{{ old('impacto_academico', $informe->impacto_academico ?? '') }}</textarea>
                        <p id="count_impacto_academico" class="mt-1 text-right text-xs text-gray-500">0 / 1000 caracteres</p>
                        @error('impacto_academico') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Concepto de Gasto --}}
                    <div>
                        <label for="concepto_gasto" class="block text-sm font-medium text-gray-700">Concepto de Gasto <span class="text-red-500">*</span></label>
                        <textarea id="concepto_gasto" name="concepto_gasto" rows="3" maxlength="1000" required
                                  class="w-full rounded-lg border-gray-300 px-3 py-2 text-sm
                                         focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500
                                         @error('concepto_gasto') !border-red-500 !ring-red-500 @enderror">{{ old('concepto_gasto', $informe->concepto_gasto ?? '') }}</textarea>
                        <p id="count_concepto_gasto" class="mt-1 text-right text-xs text-gray-500">0 / 1000 caracteres</p>
                        @error('concepto_gasto') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Actividad Realizada --}}
                    <div>
                        <label for="actividad_realizada" class="block text-sm font-medium text-gray-700">Actividad Realizada <span class="text-red-500">*</span></label>
                        <textarea id="actividad_realizada" name="actividad_realizada" rows="3" maxlength="1000" required
                                  class="w-full rounded-lg border-gray-300 px-3 py-2 text-sm
                                         focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500
                                         @error('actividad_realizada') !border-red-500 !ring-red-500 @enderror">{{ old('actividad_realizada', $informe->actividad_realizada ?? '') }}</textarea>
                        <p id="count_actividad_realizada" class="mt-1 text-right text-xs text-gray-500">0 / 1000 caracteres</p>
                        @error('actividad_realizada') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Comentarios --}}
                    <div>
                        <label for="comentarios" class="block text-sm font-medium text-gray-700">Comentarios</label>
                        <textarea id="comentarios" name="comentarios" rows="3" maxlength="500"
                                  class="w-full rounded-lg border-gray-300 px-3 py-2 text-sm
                                         focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500
                                         @error('comentarios') !border-red-500 !ring-red-500 @enderror">{{ old('comentarios', $informe->comentarios ?? '') }}</textarea>
                        <p id="count_comentarios" class="mt-1 text-right text-xs text-gray-500">0 / 500 caracteres</p>
                        @error('comentarios') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                </div>
            </div>
        </section>

        {{-- Acciones --}}
        <div class="pt-2 flex items-center justify-end">
            @php $isUpdate = isset($informe) && $informe?->exists; @endphp
            <button type="submit"
                class="inline-flex items-center rounded-md px-4 py-2 text-sm font-semibold text-white shadow-sm
                       focus:outline-none focus:ring-2 focus:ring-offset-1
                       {{ $isUpdate
                           ? 'bg-green-600 hover:bg-green-700 focus:ring-green-500'
                           : 'bg-blue-600 hover:bg-blue-700 focus:ring-blue-500' }}">
                {{ $isUpdate ? 'Actualizar' : 'Guardar' }}
            </button>
        </div>
    </div>
</div>

{{-- JS: Categoría → Criterios + Contadores (se conserva lógica original) --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    // -------- CASCADA --------
    const catSelect  = document.getElementById('categoria_mejora_id');
    const critSelect = document.getElementById('criterio_snp_id');

    const preselectedCategoria = @json($selectedCategoria);
    const preselectedCriterio  = @json($selectedCriterio);

    function setOptions(message) {
        critSelect.innerHTML = `<option value="">${message}</option>`;
    }

    function loadCriterios(categoriaId, preselect = null) {
        if (!categoriaId) { setOptions('— Selecciona una categoría —'); return; }
        setOptions('— Cargando… —');

        const base = `{{ url('/usuario/informes/categorias') }}`;
        const url  = `${base}/${categoriaId}/criterios`;

        fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' }})
            .then(r => r.json())
            .then(data => {
                critSelect.innerHTML = '';
                if (!Array.isArray(data) || data.length === 0) {
                    setOptions('— Sin criterios para la categoría —');
                    return;
                }
                critSelect.insertAdjacentHTML('beforeend', `<option value="">-- Selecciona --</option>`);
                data.forEach(item => {
                    const text = (item.clave ? (item.clave + ' - ') : '') + item.nombre;
                    const selected = preselect && String(preselect) === String(item.id) ? 'selected' : '';
                    critSelect.insertAdjacentHTML('beforeend', `<option value="${item.id}" ${selected}>${text}</option>`);
                });
            })
            .catch(() => setOptions('— Error al cargar —'));
    }

    catSelect?.addEventListener('change', e => loadCriterios(e.target.value, null));
    if (preselectedCategoria) {
        loadCriterios(preselectedCategoria, preselectedCriterio);
    }

    // -------- CONTADORES -------- (manteniendo IDs y lógica original)
    const textareas = [
        { id: 'impacto_academico',   counter: 'count_impacto_academico' },
        { id: 'concepto_gasto',      counter: 'count_concepto_gasto' },
        { id: 'actividad_realizada', counter: 'count_actividad_realizada' },
        { id: 'comentarios',         counter: 'count_comentarios' },
    ];

    textareas.forEach(({ id, counter }) => {
        const textarea = document.getElementById(id);
        const output   = document.getElementById(counter);

        if (textarea && output) {
            const updateCount = () => {
                output.textContent = `${textarea.value.length} / ${textarea.maxLength} caracteres`;
            };
            textarea.addEventListener('input', updateCount);
            updateCount();
        }
    });
});
</script>
