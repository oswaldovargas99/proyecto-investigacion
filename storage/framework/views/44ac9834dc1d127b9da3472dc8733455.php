<?php
    /** @var \App\Models\RubroCategoria|null $categoria */
    $categoria  = $categoria ?? null;
    $esEdicion  = isset($categoria) && $categoria?->exists;
    $v = function($key, $default = '') use ($categoria) {
        return old($key, $categoria->{$key} ?? $default);
    };
?>

<div class="bg-white shadow-sm rounded-2xl border p-6 space-y-8">

    
    <section class="rounded-xl border bg-gray-50/50 p-5">
        <header class="mb-4 flex items-center gap-3">
            <div class="h-9 w-9 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center">
                <!-- icon list -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M3 5h18v2H3zM3 11h18v2H3zM3 17h12v2H3z"/>
                </svg>
            </div>
            <h3 class="text-base font-semibold text-gray-800">Datos de la Categoría</h3>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <!-- Categoría -->
            <div class="md:col-span-1">
                <label for="categoria" class="block text-sm font-medium text-gray-700">
                    Categoría <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    name="categoria"
                    id="categoria"
                    value="<?php echo e($v('categoria')); ?>"
                    required
                    placeholder="Ej. 2000 - MATERIALES Y SUMINISTROS"
                    class="mt-1 w-full rounded-lg border-gray-300 px-3 py-2
                           focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500"
                >
                <p class="text-xs text-gray-500 mt-1">Nombre de la categoría (puede incluir clave numérica).</p>
                <?php $__errorArgs = ['categoria'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Descripción -->
            <div class="md:col-span-2">
                <label for="descripcion" class="block text-sm font-medium text-gray-700">
                    Descripción
                </label>
                <textarea
                    name="descripcion"
                    id="descripcion"
                    rows="4"
                    placeholder="Descripción breve de la categoría…"
                    class="mt-1 w-full rounded-lg border-gray-300 px-3 py-2
                           focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500"
                ><?php echo e($v('descripcion')); ?></textarea>
                <p class="text-xs text-gray-500 mt-1">Opcional. Puede detallar el alcance o ejemplos.</p>
                <?php $__errorArgs = ['descripcion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>
    </section>

    
    <div class="flex flex-col sm:flex-row gap-3 sm:justify-between sm:items-center">
        <a href="<?php echo e(route('admin.rubros-categorias.index')); ?>"
           class="inline-flex items-center justify-center gap-2 bg-gray-700 text-white px-5 py-2.5 rounded-lg hover:bg-gray-800">
            <!-- back icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 -ms-1" viewBox="0 0 24 24" fill="currentColor">
                <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2Z"/>
            </svg>
            <span>Regresar</span>
        </a>

        <button type="submit"
            class="inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-lg text-white
                   <?php echo e($esEdicion ? 'bg-yellow-500 hover:bg-yellow-600' : 'bg-green-600 hover:bg-green-700'); ?>">
            <!-- save icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 -ms-1" viewBox="0 0 24 24" fill="currentColor">
                <path d="M17 3H5a2 2 0 0 0-2 2v14l4-4h10a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2Z"/>
            </svg>
            <span><?php echo e($esEdicion ? 'Actualizar' : 'Guardar'); ?></span>
        </button>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\proyecto-pfp_b\resources\views/administrador/rubros-categorias/form.blade.php ENDPATH**/ ?>