<?php
    use Illuminate\Support\Facades\Storage;

    // Campos de Documentación (sin cambios en lógica/keys)
    $campos = [
        'acta_junta'        => 'Acta de la Junta Académica',
        'carta_no_adeudo'   => 'Carta de No Adeudo',
        'p3e'               => 'P3e',
        'solicitud_firmado' => 'Solicitud Firmado',
        'informe_firmado'   => 'Informe Firmado',
    ];

    // Grupos solo para UI
    $grupos = [
        'Académico'      => ['acta_junta'],
        'Administrativo' => ['carta_no_adeudo', 'p3e'],
        'Firmados'       => ['solicitud_firmado', 'informe_firmado'],
    ];

    $grupoUi = [
        'Académico'      => ['bg' => 'bg-sky-50',     'text' => 'text-sky-700',     'ring' => 'ring-sky-200'],
        'Administrativo' => ['bg' => 'bg-amber-50',   'text' => 'text-amber-700',   'ring' => 'ring-amber-200'],
        'Firmados'       => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'ring' => 'ring-emerald-200'],
    ];
?>

<div class="rounded-2xl border bg-white shadow-sm">
    <div class="p-5" x-data="accordionPage()">

        
        <header class="mb-5 flex items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <div class="h-9 w-9 rounded-full bg-rose-50 text-rose-700 ring-1 ring-inset ring-rose-200 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M16.5 6.5 7 16a3.5 3.5 0 1 0 5 5l9-9a5 5 0 1 0-7-7l-10 10a6.5 6.5 0 1 0 9.19 9.19l8.1-8.1-1.41-1.41-8.1 8.1A4.5 4.5 0 1 1 5.64 14.1l10-10a3 3 0 1 1 4.24 4.24l-9 9a1.5 1.5 0 1 1-2.12-2.12l7.6-7.6-1.41-1.41-7.6 7.6A3.5 3.5 0 0 0 12 18.5l9-9"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-semibold text-gray-800">Adjuntar Documentación</h3>
                    <p class="text-xs text-gray-500">PDF (máx. 5 MB). La lógica del backend no cambia.</p>
                </div>
            </div>

            <button type="button"
                    @click="toggleAll()"
                    class="inline-flex items-center gap-2 rounded-md border border-gray-200 bg-white px-3 py-1.5 text-xs font-medium text-gray-700 hover:bg-gray-50">
                <svg :class="allOpen ? 'rotate-180' : ''" xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform" viewBox="0 0 24 24" fill="currentColor"><path d="m7 10 5 5 5-5"/></svg>
                <span x-text="allOpen ? 'Contraer todo' : 'Expandir todo'"></span>
            </button>
        </header>

        
        <form id="doc-form"
              action="<?php echo e(route('usuario.documentaciones.store')); ?>"
              method="POST"
              enctype="multipart/form-data"
              @submit.prevent="if (validarTodo()) $el.submit()"
              class="space-y-4">
            <?php echo csrf_field(); ?>

            
            <?php $__currentLoopData = $grupos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grupo => $keys): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $ui = $grupoUi[$grupo]; ?>

                <section class="rounded-xl border bg-white" x-data="{ open: true }">
                    <button type="button"
                            class="w-full flex items-center justify-between px-4 py-3 text-left hover:bg-gray-50"
                            @click="open = !open">
                        <div class="flex items-center gap-3">
                            <div class="h-8 w-8 rounded-full <?php echo e($ui['bg']); ?> <?php echo e($ui['text']); ?> ring-1 ring-inset <?php echo e($ui['ring']); ?> flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M6 2h7l5 5v13a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2zm7 1v4h4l-4-4z"/></svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-semibold text-gray-800"><?php echo e($grupo); ?></h4>
                                <p class="text-xs text-gray-500">Documentos: <?php echo e(implode(', ', array_map(fn($k) => $campos[$k], $keys))); ?></p>
                            </div>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform text-gray-600" :class="open ? 'rotate-180' : ''" viewBox="0 0 24 24" fill="currentColor"><path d="m7 10 5 5 5-5"/></svg>
                    </button>

                    <div x-show="open" style="display:none">
                        <div class="border-t px-4 py-4">
                            <div class="grid grid-cols-1 gap-y-6 gap-x-10 md:grid-cols-2">
                                <?php $__currentLoopData = $keys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $label        = $campos[$name];
                                        $tieneArchivo = isset($documentacion) && !empty($documentacion->{$name});
                                        $deleteFormId = 'del-'.$name;
                                        $rutaActual   = null;

                                        if ($tieneArchivo) {
                                            try {
                                                $disk = config('filesystems.default');
                                                $path = $documentacion->{$name};

                                                // Discos remotos privados: generar URL temporal embebible
                                                if (in_array($disk, ['s3','minio','spaces','digitalocean','linode'])) {
                                                    $rutaActual = Storage::disk($disk)->temporaryUrl(
                                                        $path,
                                                        now()->addMinutes(5),
                                                        [
                                                            'Response-Content-Type'        => 'application/pdf',
                                                            'Response-Content-Disposition' => 'inline; filename="'.basename($path).'"',
                                                        ]
                                                    );
                                                } else {
                                                    // Local/public (requiere storage:link)
                                                    $rutaActual = Storage::url($path);
                                                }
                                            } catch (\Throwable $e) {
                                                $rutaActual = null; // si falló, se mostrará fallback de UI
                                            }
                                        }
                                    ?>

                                    <div class="col-span-1">
                                        <label class="block text-sm font-medium text-gray-700 mb-2"><?php echo e($label); ?></label>

                                        
                                        <div id="preview-<?php echo e($name); ?>" class="<?php echo e($tieneArchivo ? '' : 'hidden'); ?>">
                                            <div class="rounded-lg border bg-gray-50">
                                                <div class="flex items-center justify-between px-3 py-2">
                                                    <p class="text-xs text-gray-600">Archivo actual</p>
                                                    <div class="flex flex-wrap items-center gap-2">
                                                        <?php if($rutaActual): ?>
                                                            <a href="<?php echo e($rutaActual); ?>" target="_blank" rel="noopener"
                                                               class="inline-flex items-center rounded-md border border-gray-200 bg-white px-2.5 py-1.5 text-xs text-gray-700 hover:bg-gray-50">Ver</a>
                                                            <a href="<?php echo e($rutaActual); ?>" target="_blank" rel="noopener" download
                                                               class="inline-flex items-center rounded-md border border-gray-200 bg-white px-2.5 py-1.5 text-xs text-gray-700 hover:bg-gray-50">Descargar</a>
                                                        <?php endif; ?>
                                                        <button type="button"
                                                                onclick="toggleInput('<?php echo e($name); ?>')"
                                                                class="inline-flex items-center rounded-md bg-indigo-600 px-2.5 py-1.5 text-xs font-medium text-white hover:bg-indigo-700">
                                                            Reemplazar
                                                        </button>
                                                        <button type="submit"
                                                                form="<?php echo e($deleteFormId); ?>"
                                                                class="inline-flex items-center rounded-md bg-red-600 px-2.5 py-1.5 text-xs font-medium text-white hover:bg-red-700"
                                                                onclick="return confirm('¿Seguro que deseas eliminar este archivo?')">
                                                            Eliminar
                                                        </button>
                                                    </div>
                                                </div>

                                                <div class="border-t relative">
                                                    <?php if($rutaActual): ?>
                                                        <iframe src="<?php echo e($rutaActual); ?>" class="w-full" style="height: 320px;" data-pdf-frame loading="lazy"></iframe>

                                                        
                                                        <div class="hidden absolute inset-0 z-10 bg-white/80 backdrop-blur-sm flex items-center justify-center p-4" data-pdf-error>
                                                            <div class="text-center">
                                                                <p class="text-sm font-medium text-gray-800">No se pudo cargar la vista previa del PDF.</p>
                                                                <p class="mt-1 text-xs text-gray-600">Puede ser restricción del servidor o permisos.</p>
                                                                <div class="mt-3">
                                                                    <a href="<?php echo e($rutaActual); ?>" target="_blank" rel="noopener"
                                                                       class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-1.5 text-xs font-semibold text-white hover:bg-indigo-700">
                                                                        Abrir en pestaña
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php else: ?>
                                                        <div class="p-4 text-sm text-gray-600">
                                                            No hay URL disponible para vista previa. Verifica permisos o la ruta del archivo.
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>

                                        
                                        <div id="wrap-<?php echo e($name); ?>" class="<?php echo e($tieneArchivo ? 'hidden' : ''); ?>">
                                            <input id="input-<?php echo e($name); ?>"
                                                   name="<?php echo e($name); ?>"
                                                   type="file"
                                                   accept="application/pdf"
                                                   class="sr-only"
                                                   data-file-input
                                                   aria-describedby="hint-<?php echo e($name); ?>">

                                            <label for="input-<?php echo e($name); ?>"
                                                   data-dropzone
                                                   data-field="<?php echo e($name); ?>"
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
                                                <p id="hint-<?php echo e($name); ?>" class="mt-1 text-xs text-gray-500">Solo PDF • Máx. 5 MB</p>

                                                <div class="mt-3 hidden" data-file-state>
                                                    <div class="inline-flex items-center gap-2 rounded-full bg-gray-100 px-2.5 py-1 text-xs text-gray-700">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M5 4h14v2H5zM5 9h14v2H5zM5 14h14v2H5z"/></svg>
                                                        <span data-file-name>Archivo seleccionado.pdf</span>
                                                        <span aria-hidden="true">•</span>
                                                        <span data-file-size>0 MB</span>
                                                    </div>
                                                </div>

                                                <p class="mt-2 hidden text-xs text-red-600" data-file-error></p>
                                            </label>

                                            <div class="mt-2 flex flex-wrap items-center gap-2">
                                                <button type="button" data-clear data-field="<?php echo e($name); ?>"
                                                        class="inline-flex items-center rounded-md border border-gray-200 bg-white px-2.5 py-1.5 text-xs text-gray-700 hover:bg-gray-50">
                                                    Limpiar selección
                                                </button>
                                                <?php if($tieneArchivo): ?>
                                                    <button type="button"
                                                            onclick="toggleInput('<?php echo e($name); ?>', true)"
                                                            class="inline-flex items-center rounded-md border border-gray-200 bg-white px-2.5 py-1.5 text-xs text-gray-700 hover:bg-gray-50">
                                                        Cancelar
                                                    </button>
                                                <?php endif; ?>
                                            </div>

                                            <?php $__errorArgs = [$name];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </section>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <div class="border-t pt-4">
                <button type="submit" id="btn-submit"
                        class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-indigo-700 shadow-sm disabled:opacity-50 disabled:cursor-not-allowed">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 -ms-0.5" viewBox="0 0 24 24" fill="currentColor"><path d="M17 3H5a2 2 0 0 0-2 2v14l4-4h10a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2Z"/></svg>
                    Guardar
                </button>
            </div>
        </form>

        
        <?php $__currentLoopData = $campos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $name => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php $deleteFormId = 'del-'.$name; ?>
            <form id="<?php echo e($deleteFormId); ?>"
                  action="<?php echo e(route('usuario.documentaciones.deleteFile', ['field' => $name])); ?>"
                  method="POST" class="hidden">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
            </form>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>

<script>
    // ===== Config =====
    const MAX_MB = 5;
    const MAX_BYTES = MAX_MB * 1024 * 1024;

    // ===== Acordeón (sin x-collapse) =====
    function accordionPage() {
        return {
            allOpen: true,
            toggleAll() {
                this.allOpen = !this.allOpen;
                document.querySelectorAll('section[x-data]').forEach(s => {
                    const state = Alpine.$data(s);
                    if (state && typeof state.open !== 'undefined') state.open = this.allOpen;
                });
            },
            validarTodo() {
                // Ya NO se requiere adjuntar archivos.
                // Solo valida tipo y tamaño si el usuario seleccionó alguno.
                let ok = true;
                document.querySelectorAll('[data-file-input]').forEach(input => {
                    const wrap = input.closest('[id^="wrap-"]');
                    if (!wrap || wrap.classList.contains('hidden')) return; // si hay archivo previo, no validar

                    if (input.files && input.files[0]) {
                        const f = input.files[0];
                        if (f.type !== 'application/pdf') {
                            mostrarError(input, 'Solo se permiten archivos PDF.');
                            ok = false; return;
                        }
                        if (f.size > MAX_BYTES) {
                            mostrarError(input, `El archivo supera el máximo permitido (${MAX_MB} MB).`);
                            ok = false; return;
                        } else {
                            limpiarError(input);
                        }
                    } else {
                        // Sin archivo seleccionado: no es error
                        limpiarError(input);
                    }
                });
                const btn = document.getElementById('btn-submit');
                if (btn) btn.disabled = !ok;
                return ok;
            }
        };
    }

    // ===== Utilidades UI =====
    function humanSize(bytes){ const mb = bytes / (1024*1024); return `${mb.toFixed(2)} MB`; }

    function mostrarError(input, msg){
        const zone = input.closest('[id^="wrap-"]').querySelector('[data-dropzone]');
        const errEl = zone?.querySelector('[data-file-error]');
        if (errEl){ errEl.textContent = msg; errEl.classList.remove('hidden'); }
    }

    function limpiarError(input){
        const zone = input.closest('[id^="wrap-"]').querySelector('[data-dropzone]');
        const errEl = zone?.querySelector('[data-file-error]');
        if (errEl){ errEl.textContent = ''; errEl.classList.add('hidden'); }
    }

    function updateState(input) {
        const zone   = input.closest('[id^="wrap-"]').querySelector('[data-dropzone]');
        const state  = zone.querySelector('[data-file-state]');
        const nameEl = zone.querySelector('[data-file-name]');
        const sizeEl = zone.querySelector('[data-file-size]');

        limpiarError(input);

        if (input.files && input.files[0]) {
            const f = input.files[0];
            state.classList.remove('hidden');
            if (nameEl) nameEl.textContent = f.name;
            if (sizeEl) sizeEl.textContent = humanSize(f.size);

            // Validaciones inmediatas
            if (f.type !== 'application/pdf') {
                mostrarError(input, 'Solo se permiten archivos PDF.');
            } else if (f.size > MAX_BYTES) {
                mostrarError(input, `El archivo supera el máximo permitido (${MAX_MB} MB).`);
            }
        } else {
            state.classList.add('hidden');
        }
    }

    function toggleInput(field, cancelar = false) {
        const preview = document.getElementById(`preview-${field}`);
        const wrap    = document.getElementById(`wrap-${field}`);
        if (!preview || !wrap) return;
        if (cancelar) {
            const input = document.getElementById(`input-${field}`);
            if (input) { input.value = ''; updateState(input); limpiarError(input); }
        }
        preview.classList.toggle('hidden');
        wrap.classList.toggle('hidden');
        if (!wrap.classList.contains('hidden')) {
            const input = document.getElementById(`input-${field}`);
            if (input) input.focus();
        }
    }

    // (Mantenemos el resto de la UX: drag & drop, limpiar, etc.)
    document.addEventListener('DOMContentLoaded', () => {
        const inputs = document.querySelectorAll('[data-file-input]');
        inputs.forEach((input) => {
            input.addEventListener('change', () => updateState(input));

            const zone = input.closest('[id^="wrap-"]').querySelector('[data-dropzone]');
            if (zone) {
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
                zone.addEventListener('drop', (e) => {
                    const file = e.dataTransfer?.files?.[0];
                    if (file) {
                        if (file.type !== 'application/pdf') return mostrarError(input, 'Solo se permiten archivos PDF.');
                        input.files = e.dataTransfer.files;
                        updateState(input);
                    }
                });
                zone.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        input.click();
                    }
                });
            }

            const clearBtn = input.closest('[id^="wrap-"]').querySelector('[data-clear]');
            clearBtn?.addEventListener('click', () => {
                input.value = '';
                updateState(input);
                limpiarError(input);
            });

            updateState(input); // estado inicial
        });
    });
</script>
<?php /**PATH C:\xampp\htdocs\proyecto-pfp_b\resources\views/usuario/documentaciones/form.blade.php ENDPATH**/ ?>