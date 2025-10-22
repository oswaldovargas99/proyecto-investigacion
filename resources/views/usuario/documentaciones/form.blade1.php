@php
    // Campos de Documentación (sin cambios)
    $campos = [
        'acta_junta'        => 'Acta de la Junta Académica',
        'carta_no_adeudo'   => 'Carta de No Adeudo',
        'p3e'               => 'P3e',
        'solicitud_firmado' => 'Solicitud Firmado',
        'informe_firmado'   => 'Informe Firmado',
    ];
@endphp

<div class="rounded-2xl border bg-white shadow-sm">
    <div class="p-5">

        {{-- Header coherente con módulos previos --}}
        <header class="mb-5 flex items-center gap-3">
            <div class="h-9 w-9 rounded-full bg-rose-50 text-rose-700 ring-1 ring-inset ring-rose-200 flex items-center justify-center">
                {{-- paperclip --}}
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M16.5 6.5 7 16a3.5 3.5 0 1 0 5 5l9-9a5 5 0 1 0-7-7l-10 10a6.5 6.5 0 1 0 9.19 9.19l8.1-8.1-1.41-1.41-8.1 8.1A4.5 4.5 0 1 1 5.64 14.1l10-10a3 3 0 1 1 4.24 4.24l-9 9a1.5 1.5 0 1 1-2.12-2.12l7.6-7.6-1.41-1.41-7.6 7.6A3.5 3.5 0 0 0 12 18.5l9-9"/>
                </svg>
            </div>
            <div>
                <h3 class="text-base font-semibold text-gray-800">Adjuntar Documentación</h3>
                <p class="text-xs text-gray-500">Archivos en formato PDF (máx. 50 MB). El contenido y la lógica de guardado permanecen iguales.</p>
            </div>
        </header>

        {{-- ====== FORM PRINCIPAL (GUARDAR) ====== --}}
        <form action="{{ route('usuario.documentaciones.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6" id="doc-form">
            @csrf

            <div class="grid grid-cols-1 gap-y-6 gap-x-10 md:grid-cols-2">
                @foreach ($campos as $name => $label)
                    @php
                        $tieneArchivo = isset($documentacion) && !empty($documentacion->{$name});
                        $deleteFormId = 'del-'.$name;
                        $rutaActual   = $tieneArchivo ? asset('storage/' . $documentacion->{$name}) : null;
                    @endphp

                    <div class="col-span-1">
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ $label }}</label>

                        {{-- PREVIEW si hay archivo (mismo comportamiento) --}}
                        <div id="preview-{{ $name }}" class="{{ $tieneArchivo ? '' : 'hidden' }}">
                            <div class="rounded-lg border bg-gray-50">
                                <div class="flex items-center justify-between px-3 py-2">
                                    <p class="text-xs text-gray-600">Archivo actual</p>
                                    <div class="flex flex-wrap items-center gap-2">
                                        @if($rutaActual)
                                            <a href="{{ $rutaActual }}" target="_blank"
                                               class="inline-flex items-center rounded-md border border-gray-200 bg-white px-2.5 py-1.5 text-xs text-gray-700 hover:bg-gray-50">
                                                Ver
                                            </a>
                                            <a href="{{ $rutaActual }}" target="_blank" download
                                               class="inline-flex items-center rounded-md border border-gray-200 bg-white px-2.5 py-1.5 text-xs text-gray-700 hover:bg-gray-50">
                                                Descargar
                                            </a>
                                        @endif
                                        <button type="button"
                                                onclick="toggleInput('{{ $name }}')"
                                                class="inline-flex items-center rounded-md bg-indigo-600 px-2.5 py-1.5 text-xs font-medium text-white hover:bg-indigo-700">
                                            Reemplazar
                                        </button>
                                        <button type="submit"
                                                form="{{ $deleteFormId }}"
                                                class="inline-flex items-center rounded-md bg-red-600 px-2.5 py-1.5 text-xs font-medium text-white hover:bg-red-700"
                                                onclick="return confirm('¿Seguro que deseas eliminar este archivo?')">
                                            Eliminar
                                        </button>
                                    </div>
                                </div>

                                <div class="border-t">
                                    <iframe src="{{ $rutaActual }}" class="w-full" style="height: 320px;"></iframe>
                                </div>
                            </div>
                        </div>

                        {{-- INPUT para cargar/reemplazar (sin alterar name/id) --}}
                        <div id="wrap-{{ $name }}" class="{{ $tieneArchivo ? 'hidden' : '' }}">
                            {{-- input real (oculto) --}}
                            <input
                                id="input-{{ $name }}"
                                name="{{ $name }}"
                                type="file"
                                accept="application/pdf"
                                class="sr-only"
                                aria-describedby="hint-{{ $name }}"
                                data-file-input
                            >

                            {{-- zona drag & drop / click --}}
                            <label for="input-{{ $name }}"
                                   data-dropzone
                                   data-field="{{ $name }}"
                                   tabindex="0"
                                   class="group block cursor-pointer rounded-lg border border-dashed border-gray-300 bg-white px-4 py-5 text-center outline-none transition
                                          hover:border-indigo-400 hover:bg-indigo-50/40 focus:ring-2 focus:ring-indigo-500">
                                <div class="mx-auto mb-2 flex h-10 w-10 items-center justify-center rounded-full bg-gray-100 transition group-hover:bg-indigo-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600 group-hover:text-indigo-600" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M19 12h-4v8H9v-8H5l7-7 7 7z"/><path d="M5 20h14v2H5z"/>
                                    </svg>
                                </div>
                                <p class="text-sm text-gray-700">
                                    <span class="font-medium text-indigo-700">Suelta aquí</span> tu PDF o <span class="font-medium text-indigo-700">haz clic</span> para buscar.
                                </p>
                                <p id="hint-{{ $name }}" class="mt-1 text-xs text-gray-500">Solo PDF · Máx. 50 MB</p>

                                {{-- estado de selección --}}
                                <div class="mt-3 hidden" data-file-state>
                                    <div class="inline-flex items-center gap-2 rounded-full bg-gray-100 px-2.5 py-1 text-xs text-gray-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M5 4h14v2H5zM5 9h14v2H5zM5 14h14v2H5z"/></svg>
                                        <span data-file-name>Archivo seleccionado.pdf</span>
                                        <span aria-hidden="true">•</span>
                                        <span data-file-size>0 MB</span>
                                    </div>
                                </div>

                                {{-- error local (tamaño / tipo) --}}
                                <p class="mt-2 hidden text-xs text-red-600" data-file-error></p>
                            </label>

                            {{-- acciones debajo del dropzone --}}
                            <div class="mt-2 flex flex-wrap items-center gap-2">
                                <button type="button"
                                        data-clear
                                        data-field="{{ $name }}"
                                        class="inline-flex items-center rounded-md border border-gray-200 bg-white px-2.5 py-1.5 text-xs text-gray-700 hover:bg-gray-50">
                                    Limpiar selección
                                </button>

                                {{-- Si hay archivo, botón para volver al preview (solo UI) --}}
                                @if($tieneArchivo)
                                    <button type="button"
                                            onclick="toggleInput('{{ $name }}', true)"
                                            class="inline-flex items-center rounded-md border border-gray-200 bg-white px-2.5 py-1.5 text-xs text-gray-700 hover:bg-gray-50">
                                        Cancelar
                                    </button>
                                @endif
                            </div>

                            @error($name)
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="border-t pt-4">
                <button type="submit" id="btn-submit"
                        class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-indigo-700 shadow-sm disabled:opacity-50 disabled:cursor-not-allowed">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 -ms-0.5" viewBox="0 0 24 24" fill="currentColor"><path d="M17 3H5a2 2 0 0 0-2 2v14l4-4h10a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2Z"/></svg>
                    Guardar
                </button>
            </div>
        </form>

        {{-- ====== FORMs DELETE EXTERNOS (UNO POR CAMPO) ====== --}}
        @foreach ($campos as $name => $label)
            @php $deleteFormId = 'del-'.$name; @endphp
            <form id="{{ $deleteFormId }}"
                  action="{{ route('usuario.documentaciones.deleteFile', ['field' => $name]) }}"
                  method="POST" class="hidden">
                @csrf
                @method('DELETE')
            </form>
        @endforeach
    </div>
</div>

{{-- Utilidades de UI (no alteran la lógica de envío/eliminación) --}}
<script>
    const MAX_MB = 50;
    const MAX_BYTES = MAX_MB * 1024 * 1024;

    function toggleInput(field, cancelar = false) {
        const preview = document.getElementById(`preview-${field}`);
        const wrap    = document.getElementById(`wrap-${field}`);
        if (!preview || !wrap) return;
        if (cancelar) {
            const input = document.getElementById(`input-${field}`);
            if (input) {
                input.value = '';
                updateState(input);
            }
        }
        preview.classList.toggle('hidden');
        wrap.classList.toggle('hidden');
        if (!wrap.classList.contains('hidden')) {
            const input = document.getElementById(`input-${field}`);
            if (input) input.focus();
        }
    }

    function humanSize(bytes) {
        if (!Number.isFinite(bytes)) return '—';
        const mb = bytes / (1024 * 1024);
        return `${mb.toFixed(2)} MB`;
    }

    function updateState(input) {
        const zone   = input?.closest('[id^="wrap-"]')?.querySelector('[data-dropzone]');
        if (!zone) return;

        const state  = zone.querySelector('[data-file-state]');
        const nameEl = zone.querySelector('[data-file-name]');
        const sizeEl = zone.querySelector('[data-file-size]');
        const errEl  = zone.querySelector('[data-file-error]');
        const btn    = document.getElementById('btn-submit');

        let valid = true;
        errEl?.classList.add('hidden');
        errEl && (errEl.textContent = '');

        if (input.files && input.files[0]) {
            const f = input.files[0];

            // Validación simple: tipo + tamaño
            if (f.type !== 'application/pdf') {
                valid = false;
                errEl.textContent = 'Solo se permiten archivos PDF.';
                errEl.classList.remove('hidden');
            } else if (f.size > MAX_BYTES) {
                valid = false;
                errEl.textContent = `El archivo supera el máximo permitido (${MAX_MB} MB).`;
                errEl.classList.remove('hidden');
            }

            // Mostrar estado
            state?.classList.remove('hidden');
            if (nameEl) nameEl.textContent = f.name;
            if (sizeEl) sizeEl.textContent = humanSize(f.size);
        } else {
            // Sin archivo seleccionado
            state?.classList.add('hidden');
        }

        // Si cualquier campo tiene error, deshabilitar submit
        const anyError = !!document.querySelector('[data-file-error]:not(.hidden)');
        if (btn) btn.disabled = anyError;
    }

    // Inicialización para todos los inputs
    document.addEventListener('DOMContentLoaded', () => {
        const inputs = document.querySelectorAll('[data-file-input]');
        inputs.forEach((input) => {
            // Cambio por selector del sistema
            input.addEventListener('change', () => updateState(input));

            // Dropzone asociado
            const zone = input.closest('[id^="wrap-"]').querySelector('[data-dropzone]');
            if (zone) {
                // Visual de arrastre
                ['dragenter','dragover'].forEach(evt =>
                    zone.addEventListener(evt, (e) => {
                        e.preventDefault(); e.stopPropagation();
                        zone.classList.add('border-indigo-400','bg-indigo-50/40');
                    })
                );
                ['dragleave','drop'].forEach(evt =>
                    zone.addEventListener(evt, (e) => {
                        e.preventDefault(); e.stopPropagation();
                        zone.classList.remove('border-indigo-400','bg-indigo-50/40');
                    })
                );
                // Soltar archivo
                zone.addEventListener('drop', (e) => {
                    const file = e.dataTransfer?.files?.[0];
                    if (file) {
                        input.files = e.dataTransfer.files;
                        updateState(input);
                    }
                });
                // Accesible con teclado (Enter/Space abre selector)
                zone.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        input.click();
                    }
                });
            }

            // Botón limpiar selección
            const clearBtn = input.closest('[id^="wrap-"]').querySelector('[data-clear]');
            clearBtn?.addEventListener('click', () => {
                input.value = '';
                updateState(input);
            });

            // Estado inicial
            updateState(input);
        });
    });
</script>
