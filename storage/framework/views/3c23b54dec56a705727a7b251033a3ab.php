
<?php
    $solicitud = $solicitud ?? null;
    $v = function($key, $default='') use($solicitud) {
        return old($key, $solicitud->$key ?? $default);
    };
    // ids preseleccionados (old() o de la vista)
    $temasSeleccionados = array_map('strval', old('temas', $temasSeleccionados ?? []));
?>

<div class="rounded-2xl border bg-white shadow-sm">
    <div x-data="{ a1:true, a2:true }" class="space-y-4 p-4">

        
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

                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Código</label>
                        <input type="text" class="w-full rounded-lg border-gray-300 bg-gray-50 px-3 py-2 text-sm" value="<?php echo e($codigo ?? ''); ?>" disabled>
                    </div>

                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nombre del Coordinador</label>
                        <input type="text" class="w-full rounded-lg border-gray-300 bg-gray-50 px-3 py-2 text-sm" value="<?php echo e($nombre_coordinador ?? ''); ?>" disabled>
                    </div>

                    
                    
                    <?php
                        $fechaValue = old('fecha_solicitud',
                            optional($solicitud?->fecha_solicitud)->format('Y-m-d')
                        );
                    ?>

                    <div>
                        <label for="fecha_solicitud" class="block text-sm font-medium text-gray-700">
                            Fecha de Solicitud <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="fecha_solicitud" id="fecha_solicitud"
                            value="<?php echo e($fechaValue); ?>"
                            required
                            class="w-full rounded-lg border-gray-300 px-3 py-2 text-sm
                                    focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500
                                    <?php $__errorArgs = ['fecha_solicitud'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> !border-red-500 !ring-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php $__errorArgs = ['fecha_solicitud'];
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


                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Modalidad <span class="text-red-500">*</span></label>
                        <select name="modalidad"
                                class="w-full rounded-lg border-gray-300 bg-white py-2 pl-3 pr-8 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 <?php $__errorArgs = ['modalidad'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> !border-red-500 !ring-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                required>
                            <option value="">-- Seleccionar --</option>
                            <?php $modalidadVal = $v('modalidad'); ?>
                            <?php $__currentLoopData = ['Presencial','Mixta','En línea']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $op): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($op); ?>" <?php echo e($modalidadVal === $op ? 'selected' : ''); ?>><?php echo e($op); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <?php $__errorArgs = ['modalidad'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
                    <div class="md:col-span-2" x-data="{ text: <?php echo \Illuminate\Support\Js::from($v('objetivo'))->toHtml() ?>, max: 500 }">
                        <label class="block text-sm font-medium text-gray-700">Objetivo <span class="text-red-500">*</span></label>
                        <textarea name="objetivo" rows="4" maxlength="500"
                                  class="w-full rounded-lg border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 <?php $__errorArgs = ['objetivo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> !border-red-500 !ring-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                  x-model="text"
                                  required><?php echo e($v('objetivo')); ?></textarea>
                        <div class="mt-1 text-right text-xs text-gray-500" aria-live="polite">
                            <span data-count x-text="(text || '').length"><?php echo e(mb_strlen($v('objetivo'))); ?></span>/<span x-text="max">500</span>
                        </div>
                        <?php $__errorArgs = ['objetivo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
                    <div class="md:col-span-2" x-data="{ text: <?php echo \Illuminate\Support\Js::from($v('justificacion'))->toHtml() ?>, max: 500 }">
                        <label class="block text-sm font-medium text-gray-700">Justificación <span class="text-red-500">*</span></label>
                        <textarea name="justificacion" rows="4" maxlength="500"
                                  class="w-full rounded-lg border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 <?php $__errorArgs = ['justificacion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> !border-red-500 !ring-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                  x-model="text"
                                  required><?php echo e($v('justificacion')); ?></textarea>
                        <div class="mt-1 text-right text-xs text-gray-500" aria-live="polite">
                            <span data-count x-text="(text || '').length"><?php echo e(mb_strlen($v('justificacion'))); ?></span>/<span x-text="max">500</span>
                        </div>
                        <?php $__errorArgs = ['justificacion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    
                    <div class="md:col-span-2" x-data="{ text: <?php echo \Illuminate\Support\Js::from($v('resultados_esperados'))->toHtml() ?>, max: 500 }">
                        <label class="block text-sm font-medium text-gray-700">Resultados esperados <span class="text-red-500">*</span></label>
                        <textarea name="resultados_esperados" rows="4" maxlength="500"
                                  class="w-full rounded-lg border-gray-300 px-3 py-2 text-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 <?php $__errorArgs = ['resultados_esperados'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> !border-red-500 !ring-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                  x-model="text"
                                  required><?php echo e($v('resultados_esperados')); ?></textarea>
                        <div class="mt-1 text-right text-xs text-gray-500" aria-live="polite">
                            <span data-count x-text="(text || '').length"><?php echo e(mb_strlen($v('resultados_esperados'))); ?></span>/<span x-text="max">500</span>
                        </div>
                        <?php $__errorArgs = ['resultados_esperados'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                </div>
            </div>
        </section>


        
        <section class="rounded-xl border bg-white overflow-hidden"
                 x-data="{
                    query: '',
                    selected: <?php echo \Illuminate\Support\Js::from($temasSeleccionados)->toHtml() ?>,
                    total: <?php echo e($temas->count()); ?>,
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
                        <button type="button" @click="toggleAllVisible"
                                class="inline-flex items-center rounded-md border border-blue-600 bg-blue-600 px-3 py-1.5 text-xs font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1">
                            Seleccionar visibles
                        </button>
                        <!-- Botón Limpiar todo (Rojo - acción de borrar) -->
                        <button type="button" @click="clearAll"
                                class="inline-flex items-center rounded-md border border-red-600 bg-red-600 px-3 py-1.5 text-xs font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1">
                            Limpiar todo
                        </button>
                    </div>
                </div>

                
                
                <?php if($temas->count()): ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3" x-ref="temas">
                    <?php $__currentLoopData = $temas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tema): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $id      = (string)$tema->id;
                        $texto   = $tema->nombre ?? $tema->titulo ?? ('Tema #'.$id);
                        $checked = in_array($id, $temasSeleccionados, true);
                    ?>

                    <label
                        data-item
                        data-name="<?php echo e(strtolower($texto)); ?>"
                        :hidden="query && !matches($el.dataset.name)"
                        class="flex items-start gap-2 rounded-lg border p-3 hover:bg-gray-50 cursor-pointer transition
                            <?php echo e($checked ? 'border-indigo-300 bg-indigo-50/50' : 'border-gray-200'); ?>"
                        :class="selected.includes('<?php echo e($id); ?>') ? 'border-indigo-300 bg-indigo-50/50' : 'border-gray-200'">

                        <input
                        type="checkbox"
                        name="temas[]"
                        value="<?php echo e($id); ?>"
                        class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                        x-model="selected"
                        <?php echo e($checked ? 'checked' : ''); ?>>

                        <span class="text-sm text-gray-800"><?php echo e($texto); ?></span>
                    </label>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php else: ?>
                <p class="text-sm text-gray-600">No hay temas disponibles.</p>
                <?php endif; ?>

                <?php $__errorArgs = ['temas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                
                <template x-if="selected.length">
                    <div class="mt-4 flex flex-wrap gap-2">
                        <template x-for="id in selected" :key="id">
                            <span class="inline-flex items-center rounded-full bg-indigo-50 text-indigo-700 px-2.5 py-1 text-xs ring-1 ring-inset ring-indigo-200" x-text="`Tema #${id}`"></span>
                        </template>
                    </div>
                </template>
            </div>
        </section>

        
        <div class="pt-2">
            <?php $isUpdate = isset($solicitud) && $solicitud->exists; ?>

            <button type="submit"
                class="inline-flex items-center rounded-md px-4 py-2 text-sm font-semibold text-white shadow-sm
                    focus:outline-none focus:ring-2 focus:ring-offset-1
                    <?php echo e($isUpdate
                            ? 'bg-green-600 hover:bg-green-700 focus:ring-green-500'
                            : 'bg-blue-600 hover:bg-blue-700 focus:ring-blue-500'); ?>">
                <?php echo e($isUpdate ? 'Actualizar' : 'Guardar'); ?>

            </button>
        </div>

<?php /**PATH C:\xampp\htdocs\proyecto-pfp_b\resources\views/usuario/solicitud/form.blade.php ENDPATH**/ ?>