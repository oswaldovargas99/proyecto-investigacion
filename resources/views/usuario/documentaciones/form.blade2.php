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
        <form action="{{ route('usuario.documentaciones.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 gap-y-6 gap-x-10 md:grid-cols-2">
                @foreach ($campos as $name => $label)
                    @php
                        $tieneArchivo = isset($documentacion) && !empty($documentacion->{$name});
                        $deleteFormId = 'del-'.$name;
                        $rutaActual   = $tieneArchivo ? asset('storage/' . $documentacion->{$name}) : null;
                    @endphp

                    <div class="col-span-1" x-data="{filename:''}">
                        <label class="block text-sm font-medium text-gray-700 mb-2">{{ $label }}</label>

                        {{-- PREVIEW si hay archivo (mismo comportamiento) --}}
                        <div id="preview-{{ $name }}" class="{{ $tieneArchivo ? '' : 'hidden' }}">
                            <div class="rounded-lg border bg-gray-50">
                                <div class="flex items-center justify-between px-3 py-2">
                                    <p class="text-xs text-gray-600">Archivo actual</p>
                                    <div class="flex items-center gap-2">
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
                            <input
                                id="input-{{ $name }}"
                                name="{{ $name }}"
                                type="file"
                                accept="application/pdf"
                                class="sr-only"
                                onchange="this.nextElementSibling.querySelector('[data-file]').textContent = this.files[0]?.name || 'Ningún archivo seleccionado'">
                            <label for="input-{{ $name }}"
                                   class="inline-flex items-center gap-2 rounded-md bg-gray-800 px-3 py-2 text-sm font-semibold text-white hover:bg-gray-900 cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 -ms-0.5" viewBox="0 0 24 24" fill="currentColor"><path d="M5 4h14v2H5zM5 9h14v2H5zM5 14h14v2H5zM5 19h14v2H5z"/></svg>
                                Seleccionar archivo
                            </label>
                            <div class="mt-2 truncate text-sm text-gray-600"><span data-file>Ningún archivo seleccionado</span></div>
                            <p class="mt-1 text-xs text-gray-500">
                                {{ $tieneArchivo ? 'Selecciona un nuevo PDF para reemplazar el archivo actual.' : 'Carga un archivo PDF (máx. 50 MB).' }}
                            </p>
                            @error($name)
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror

                            {{-- Si hay archivo, botón para volver al preview (solo UI) --}}
                            @if($tieneArchivo)
                                <button type="button"
                                        onclick="toggleInput('{{ $name }}', true)"
                                        class="mt-2 inline-flex items-center rounded-md border border-gray-200 bg-white px-2.5 py-1.5 text-xs text-gray-700 hover:bg-gray-50">
                                    Cancelar
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="border-t pt-4">
                <button type="submit"
                        class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-indigo-700 shadow-sm">
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

{{-- Pequeña utilidad (solo presentación) para alternar preview/input --}}
<script>
    function toggleInput(field, cancelar = false) {
        const preview = document.getElementById(`preview-${field}`);
        const wrap    = document.getElementById(`wrap-${field}`);
        if (!preview || !wrap) return;
        if (cancelar) {
            // Si cancela, limpia selección del input
            const input = document.getElementById(`input-${field}`);
            if (input) input.value = '';
        }
        preview.classList.toggle('hidden');
        wrap.classList.toggle('hidden');
        if (!wrap.classList.contains('hidden')) {
            // foco al input cuando se muestra
            const input = document.getElementById(`input-${field}`);
            if (input) input.focus();
        }
    }
</script>
