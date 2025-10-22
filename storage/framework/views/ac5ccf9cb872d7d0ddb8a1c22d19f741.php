
<?php
    $r = $rubro ?? null;
    $v = function($key, $default='') use($r) {
        return old($key, $r->$key ?? $default);
    };
    $esEditar = isset($modo) && $modo === 'editar';
?>

<div class="bg-white shadow-sm rounded-2xl border p-6 space-y-8">

    
    <section class="rounded-xl border bg-gray-50/50 p-5">
        <header class="mb-4 flex items-center gap-3">
            <div class="h-9 w-9 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center">
                <!-- icon doc -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6ZM8 7h5V3.5L18.5 9H14v4H8V7Zm0 8h8v2H8v-2Z"/></svg>
            </div>
            <h3 class="text-base font-semibold text-gray-800">Datos Generales</h3>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <!-- Rubro -->
            <div>
                <label for="rubro" class="block text-sm font-medium text-gray-700">
                    Rubro <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    name="rubro"
                    id="rubro"
                    value="<?php echo e($v('rubro')); ?>"
                    required
                    placeholder="Ej. 2111"
                    class="mt-1 w-full rounded-lg border-gray-300 px-3 py-2
                           focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500"
                >
                <p class="text-xs text-gray-500 mt-1">Código o clave del rubro.</p>
                <?php $__errorArgs = ['rubro'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Concepto -->
            <div>
                <label for="concepto" class="block text-sm font-medium text-gray-700">
                    Concepto <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    name="concepto"
                    id="concepto"
                    value="<?php echo e($v('concepto')); ?>"
                    required
                    placeholder="Ej. Materiales, útiles y equipos menores…"
                    class="mt-1 w-full rounded-lg border-gray-300 px-3 py-2
                           focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500"
                >
                <p class="text-xs text-gray-500 mt-1">Descripción corta del rubro.</p>
                <?php $__errorArgs = ['concepto'];
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

    
    <section class="rounded-xl border bg-gray-50/50 p-5">
        <header class="mb-4 flex items-center gap-3">
            <div class="h-9 w-9 rounded-full bg-sky-100 text-sky-700 flex items-center justify-center">
                <!-- icon tag -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M21.41 11.58 12.42 2.59A2 2 0 0 0 11 2H4a2 2 0 0 0-2 2v7c0 .53.21 1.04.59 1.41l8.99 8.99c.78.78 2.05.78 2.83 0l6-6c.79-.78.79-2.05 0-2.82ZM6.5 8A1.5 1.5 0 1 1 8 6.5 1.5 1.5 0 0 1 6.5 8Z"/></svg>
            </div>
            <h3 class="text-base font-semibold text-gray-800">Clasificación</h3>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <!-- Categoría -->
            <div class="md:col-span-2">
                <label for="categoria_id" class="block text-sm font-medium text-gray-700">
                    Categoría
                </label>
                <select
                    name="categoria_id"
                    id="categoria_id"
                    class="mt-1 w-full rounded-lg border-gray-300 px-3 py-2 bg-white
                           focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500"
                >
                    <option value="">-- Seleccionar --</option>
                    <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($c->id); ?>" <?php echo e((string)$v('categoria_id') === (string)$c->id ? 'selected' : ''); ?>>
                            <?php echo e($c->categoria); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <p class="text-xs text-gray-500 mt-1">Categoría a la que pertenece el rubro (opcional).</p>
                <?php $__errorArgs = ['categoria_id'];
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
        <a href="<?php echo e(route('admin.rubros.index')); ?>"
           class="inline-flex items-center justify-center gap-2 bg-gray-700 text-white px-5 py-2.5 rounded-lg hover:bg-gray-800">
            <!-- back icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 -ms-1" viewBox="0 0 24 24" fill="currentColor"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2Z"/></svg>
            <span>Regresar</span>
        </a>

        <button type="submit"
            class="inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-lg text-white
                   <?php echo e($esEditar ? 'bg-yellow-500 hover:bg-yellow-600' : 'bg-green-600 hover:bg-green-700'); ?>">
            <!-- save icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 -ms-1" viewBox="0 0 24 24" fill="currentColor"><path d="M17 3H5a2 2 0 0 0-2 2v14l4-4h10a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2Z"/></svg>
            <span><?php echo e($esEditar ? 'Actualizar' : 'Guardar'); ?></span>
        </button>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\proyecto-pfp_b\resources\views/administrador/rubros/form.blade.php ENDPATH**/ ?>