{{-- resources/views/usuario/solicitud/form.blade.php --}}
@php
    $solicitud = $solicitud ?? null;
    $v = function($key, $default='') use($solicitud) {
        return old($key, $solicitud->$key ?? $default);
    };
    // ids preseleccionados (old() o de la vista)
    $temasSeleccionados = array_map('strval', old('temas', $temasSeleccionados ?? []));
@endphp

<div class="rounded-2xl border bg-white shadow-sm">
    <div x-data="{ a1:true, a2:true }" class="space-y-4 p-4">

        {{-- ========== Bloque 1: Información de la Solicitud ========== --}}
        <section class="rounded-xl border bg-white overflow-hidden">
            <button type="button"
                    class="w-full flex items-center justify-between px-5 py-4 text-left hover:bg-gray-50"
                    @click="a1 = !a1">
                <div class="flex items-center gap-3">
                    <div class="h-9 w-9 rounded-full bg-indigo-50 text-indigo-700 ring-1 ring-inset ring-indigo-200 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M14 2H6a2 2 0 0 0-2 2v16l4-4h6a2 2 0 0 0 2-2V2z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-gray-800">Información de la Solicitud</h3>
                        <p class="text-xs text-gray-500">Completa los datos de la solicitud.</p>
                    </div>
                </div>
                <svg x-show="!a1" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 rotate-0 transition-transform text-gray-500" viewBox="0 0 24 24" fill="currentColor"><path d="M7 10l5 5 5-5"/></svg>
                <svg x-show="a1"  xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 rotate-180 transition-transform text-gray-500" viewBox="0 0 24 24" fill="currentColor"><path d="M7 10l5 5 5-5"/></svg>
            </button>

            <div x-show="a1" x-collapse class="p-5 border-t">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Código (solo lectura) --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Código</label>
                        <input type="text" class="w-full rounded-lg border-gray-300 bg-gray-50 px-3 py-2 text-sm" value="{{ $codigo ?? '' }}" disabled>
                    </div>

                    {{-- Nombre del Coordinador (solo lectura) --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nombre del Coordinador</label>
                        <input type="text" class="w-full rounded-lg border-gray-300 bg-gray-50 px-3 py-2 text-sm" value="{{ $nombre_coordinador ?? '' }}" disabled>
                    </div>

                    {{-- Fecha de Solicitud --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Fecha de Solicitud <span class="text-red-500">*</span></label>
                        <input type="date" name="fecha_solicitud"
                               class="w-full rounded-lg border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 @error('fecha_solicitud') !border-red-500 !ring-red-500 @enderror"
                               value="{{ $v('fecha_solicitud') }}" required>
                        @error('fecha_solicitud') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Modalidad --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Modalidad <span class="text-red-500">*</span></label>
                        <select name="modalidad"
                                class="w-full rounded-lg border-gray-300 bg-white py-2 pl-3 pr-8 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 @error('modalidad') !border-red-500 !ring-red-500 @enderror"
                                required>
                            <option value="">-- Seleccionar --</option>
                            @php $modalidadVal = $v('modalidad'); @endphp
                            @foreach (['Presencial','Mixta','En línea'] as $op)
                                <option value="{{ $op }}" {{ $modalidadVal === $op ? 'selected' : '' }}>{{ $op }}</option>
                            @endforeach
                        </select>
                        @error('modalidad') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Objetivo --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Objetivo <span class="text-red-500">*</span></label>
                        <textarea name="objetivo" rows="4" maxlength="500"
                                  class="w-full rounded-lg border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 @error('objetivo') !border-red-500 !ring-red-500 @enderror"
                                  oninput="this.nextElementSibling.querySelector('[data-count]').textContent=this.value.length"
                                  required>{{ $v('objetivo') }}</textarea>
                        <div class="mt-1 text-right text-xs text-gray-500"><span data-count>{{ mb_strlen($v('objetivo')) }}</span>/500</div>
                        @error('objetivo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Justificación --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Justificación <span class="text-red-500">*</span></label>
                        <textarea name="justificacion" rows="4" maxlength="500"
                                  class="w-full rounded-lg border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 @error('justificacion') !border-red-500 !ring-red-500 @enderror"
                                  oninput="this.nextElementSibling.querySelector('[data-count]').textContent=this.value.length"
                                  required>{{ $v('justificacion') }}</textarea>
                        <div class="mt-1 text-right text-xs text-gray-500"><span data-count>{{ mb_strlen($v('justificacion')) }}</span>/500</div>
                        @error('justificacion') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    {{-- Resultados esperados --}}
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Resultados esperados <span class="text-red-500">*</span></label>
                        <textarea name="resultados_esperados" rows="4" maxlength="500"
                                  class="w-full rounded-lg border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 @error('resultados_esperados') !border-red-500 !ring-red-500 @enderror"
                                  oninput="this.nextElementSibling.querySelector('[data-count]').textContent=this.value.length"
                                  required>{{ $v('resultados_esperados') }}</textarea>
                        <div class="mt-1 text-right text-xs text-gray-500"><span data-count>{{ mb_strlen($v('resultados_esperados')) }}</span>/500</div>
                        @error('resultados_esperados') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                </div>
            </div>
        </section>

        {{-- ========== Bloque 2: Temas Seleccionados (con listado y UX mejorada) ========== --}}
        <section class="rounded-xl border bg-white overflow-hidden"
                 x-data="{
                    query: '',
                    selected: @js($temasSeleccionados),
                    total: {{ $temas->count() }},
                    toggleAllVisible() {
                        const boxes = this.$refs.temas.querySelectorAll('[data-item]:not([hidden]) input[type=checkbox]');
                        const ids   = Array.from(boxes).map(b => String(b.value));
                        const allOn = ids.every(id => this.selected.includes(id));
                        if (allOn) {
                            this.selected = this.selected.filter(id => !ids.includes(id));
                        } else {
                            this.selected = Array.from(new Set([...this.selected, ...ids]));
                        }
                    },
                    clearAll() { this.selected = []; },
                    matches(n) { return !this.query || n.toLowerCase().includes(this.query.toLowerCase()); }
                 }">
            <button type="button"
                    class="w-full flex items-center justify-between px-5 py-4 text-left hover:bg-gray-50"
                    @click="a2 = !a2">
                <div class="flex items-center gap-3">
                    <div class="h-9 w-9 rounded-full bg-gray-100 text-gray-700 ring-1 ring-inset ring-gray-200 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="m21 10-9-9H3v9l9 9 9-9zM7 7a2 2 0 1 1 0-4 2 2 0 0 1 0 4z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-gray-800">Temas Seleccionados</h3>
                        <p class="text-xs text-gray-500">Marca los temas que aplican a esta solicitud.</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <span class="hidden sm:inline-flex items-center rounded-full bg-indigo-50 px-2.5 py-1 text-xs font-medium text-indigo-700 ring-1 ring-inset ring-indigo-200"
                          x-text="`${selected.length} / ${total} seleccionados`"></span>
                    <svg x-show="!a2" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 rotate-0 transition-transform text-gray-500" viewBox="0 0 24 24" fill="currentColor"><path d="M7 10l5 5 5-5"/></svg>
                    <svg x-show="a2"  xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 rotate-180 transition-transform text-gray-500" viewBox="0 0 24 24" fill="currentColor"><path d="M7 10l5 5 5-5"/></svg>
                </div>
            </button>

            <div x-show="a2" x-collapse class="p-5 border-t">

                {{-- Toolbar de temas --}}
                <div class="mb-4 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                    <div class="relative w-full sm:max-w-md">
                        <input type="search" x-model="query" placeholder="Buscar tema…"
                               class="w-full rounded-lg border-gray-300 pl-9 pr-3 py-2 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500">
                        <span class="pointer-events-none absolute inset-y-0 left-2 flex items-center text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="m20.94 19.54-4.28-4.28A7.94 7.94 0 1 0 16 17.66l4.28 4.28 1.66-1.66ZM4 10a6 6 0 1 1 12 0A6 6 0 0 1 4 10Z"/></svg>
                        </span>
                    </div>
                    <div class="flex gap-2">
                        <!-- Botón Seleccionar visibles (Azul - acción positiva) -->
                        <button type="button" @click="toggleAllVisible()"
                                class="inline-flex items-center rounded-md border border-blue-600 bg-blue-600 px-3 py-1.5 text-xs font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1">
                            Seleccionar visibles
                        </button>
                        <!-- Botón Limpiar todo (Rojo - acción de borrar) -->
                        <button type="button" @click="clearAll()"
                                class="inline-flex items-center rounded-md border border-red-600 bg-red-600 px-3 py-1.5 text-xs font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1">
                            Limpiar todo
                        </button>
                    </div>
                </div>

                {{-- Grid de temas --}}
                {{-- Grid de temas (FIX: sin x-data por item; se filtra con :hidden) --}}
                @if($temas->count())
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3" x-ref="temas">
                    @foreach ($temas as $tema)
                    @php
                        $id      = (string)$tema->id;
                        $texto   = $tema->nombre ?? $tema->titulo ?? ('Tema #'.$id);
                        $checked = in_array($id, $temasSeleccionados, true);
                    @endphp

                    <label
                        data-item
                        data-name="{{ strtolower($texto) }}"
                        :hidden="query && !matches($el.dataset.name)"
                        class="flex items-start gap-2 rounded-lg border p-3 hover:bg-gray-50 cursor-pointer transition
                            {{ $checked ? 'border-indigo-300 bg-indigo-50/50' : 'border-gray-200' }}"
                        :class="selected.includes('{{ $id }}') ? 'border-indigo-300 bg-indigo-50/50' : 'border-gray-200'">

                        <input
                        type="checkbox"
                        name="temas[]"
                        value="{{ $id }}"
                        class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                        x-model="selected"
                        {{ $checked ? 'checked' : '' }}>

                        <span class="text-sm text-gray-800">{{ $texto }}</span>
                    </label>
                    @endforeach
                </div>
                @else
                <p class="text-sm text-gray-600">No hay temas disponibles.</p>
                @endif


                @error('temas') <p class="mt-2 text-sm text-red-600">{{ $message }}</p> @enderror

                {{-- Resumen de seleccionados (chips) --}}
                <template x-if="selected.length">
                    <div class="mt-4 flex flex-wrap gap-2">
                        <template x-for="id in selected" :key="id">
                            <span class="inline-flex items-center rounded-full bg-indigo-50 text-indigo-700 px-2.5 py-1 text-xs ring-1 ring-inset ring-indigo-200" x-text="`Tema #${id}`"></span>
                        </template>
                    </div>
                </template>
            </div>
        </section>

        {{-- Acciones --}}
        <div class="pt-2">
            <x-primary-button>
                {{ isset($solicitud) && $solicitud->exists ? 'Actualizar' : 'Guardar' }}
            </x-primary-button>
        </div>

    </div>
</div>
