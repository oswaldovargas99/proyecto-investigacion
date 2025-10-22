<!-- resources/views/administrador/convocatorias/form.blade.php -->
<?php
    $isEdit = isset($convocatoria) && $convocatoria->exists;
?>

<div class="bg-white shadow-sm rounded-2xl border p-6 space-y-8">

    
    <?php if($errors->any()): ?>
        <div class="rounded-lg border border-red-200 bg-red-50 px-3 py-2.5 text-sm text-red-700">
            <div class="font-semibold mb-1">Por favor corrige los siguientes errores:</div>
            <ul class="list-disc pl-5 space-y-0.5">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($e); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    
    <section class="rounded-xl border bg-gray-50/50 p-5">
        <header class="mb-4 flex items-center gap-3">
            <div class="h-9 w-9 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center">
                
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M7 2h2v3H7V2zm8 0h2v3h-2V2z"/><path d="M5 6h14a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2zm0 4v9h14v-9H5z"/>
                </svg>
            </div>
            <h3 class="text-base font-semibold text-gray-800">
                <?php echo e($isEdit ? 'Editar Convocatoria' : 'Nueva Convocatoria'); ?>

            </h3>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            
            <div class="md:col-span-2">
                <label for="nombre_convocatoria" class="block text-sm font-medium text-gray-700">
                    Nombre de la convocatoria <span class="text-red-500">*</span>
                </label>
                <input
                    id="nombre_convocatoria"
                    name="nombre_convocatoria"
                    type="text"
                    value="<?php echo e(old('nombre_convocatoria', $convocatoria->nombre_convocatoria ?? '')); ?>"
                    required
                    class="mt-1 w-full rounded-lg border-gray-300 px-3 py-2
                           focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500">
                <?php $__errorArgs = ['nombre_convocatoria'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            
            <div class="md:col-span-2">
                <label for="lema" class="block text-sm font-medium text-gray-700">Lema</label>
                <input
                    id="lema"
                    name="lema"
                    type="text"
                    value="<?php echo e(old('lema', $convocatoria->lema ?? '')); ?>"
                    class="mt-1 w-full rounded-lg border-gray-300 px-3 py-2
                           focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500">
                <?php $__errorArgs = ['lema'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            
            <div>
                <label for="responsable" class="block text-sm font-medium text-gray-700">Responsable</label>
                <input
                    id="responsable"
                    name="responsable"
                    type="text"
                    value="<?php echo e(old('responsable', $convocatoria->responsable ?? '')); ?>"
                    class="mt-1 w-full rounded-lg border-gray-300 px-3 py-2
                           focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500">
                <?php $__errorArgs = ['responsable'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            
            <div>
                <label for="cargo" class="block text-sm font-medium text-gray-700">Cargo</label>
                <input
                    id="cargo"
                    name="cargo"
                    type="text"
                    value="<?php echo e(old('cargo', $convocatoria->cargo ?? '')); ?>"
                    class="mt-1 w-full rounded-lg border-gray-300 px-3 py-2
                           focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500">
                <?php $__errorArgs = ['cargo'];
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
            <div class="h-9 w-9 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center">
                
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2a10 10 0 1 0 .001 20.001A10 10 0 0 0 12 2zm1 11h5v-2h-4V7h-2v6z"/>
                </svg>
            </div>
            <h3 class="text-base font-semibold text-gray-800">Periodo y Estatus</h3>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            
            <div>
                <label for="fecha_inicio" class="block text-sm font-medium text-gray-700">Fecha de inicio</label>
                <input
                    id="fecha_inicio"
                    name="fecha_inicio"
                    type="date"
                    value="<?php echo e(old('fecha_inicio', isset($convocatoria->fecha_inicio) ? \Carbon\Carbon::parse($convocatoria->fecha_inicio)->format('Y-m-d') : '')); ?>"
                    class="mt-1 w-full rounded-lg border-gray-300 px-3 py-2
                           focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500">
                <?php $__errorArgs = ['fecha_inicio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            
            <div>
                <label for="fecha_fin" class="block text-sm font-medium text-gray-700">Fecha de cierre</label>
                <input
                    id="fecha_fin"
                    name="fecha_fin"
                    type="date"
                    value="<?php echo e(old('fecha_fin', isset($convocatoria->fecha_fin) ? \Carbon\Carbon::parse($convocatoria->fecha_fin)->format('Y-m-d') : '')); ?>"
                    class="mt-1 w-full rounded-lg border-gray-300 px-3 py-2
                           focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500">
                <?php $__errorArgs = ['fecha_fin'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            
            <div>
                <label for="anio" class="block text-sm font-medium text-gray-700">
                    Año (4 dígitos) <span class="text-red-500">*</span>
                </label>
                <input
                    id="anio"
                    name="anio"
                    type="text"
                    maxlength="4"
                    required
                    value="<?php echo e(old('anio', $convocatoria->anio ?? '')); ?>"
                    class="mt-1 w-full rounded-lg border-gray-300 px-3 py-2
                           focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500">
                <?php $__errorArgs = ['anio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            
            <div x-data="{ activo: <?php echo e(old('id_status', $convocatoria->id_status ?? 1) ? 'true' : 'false'); ?> }">
                <label class="block text-sm font-medium text-gray-700">Estatus</label>
                <div class="mt-2 flex items-center gap-3">
                    <button type="button"
                            @click="activo = !activo"
                            :class="activo ? 'bg-green-600' : 'bg-gray-300'"
                            class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <span class="sr-only">Cambiar estatus</span>
                        <span :class="activo ? 'translate-x-6' : 'translate-x-1'"
                              class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform"></span>
                    </button>
                    <span class="text-sm font-medium text-gray-700" x-text="activo ? 'Activa' : 'Inactiva'"></span>
                </div>
                <input type="hidden" name="id_status" :value="activo ? 1 : 0">
                <?php $__errorArgs = ['id_status'];
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
        <a href="<?php echo e(route('admin.convocatorias.index')); ?>"
           class="inline-flex items-center justify-center gap-2 bg-gray-700 text-white px-5 py-2.5 rounded-lg hover:bg-gray-800">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 -ms-1" viewBox="0 0 24 24" fill="currentColor">
                <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2Z"/>
            </svg>
            <span>Regresar</span>
        </a>

        <button type="submit"
            class="inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-lg text-white
                   <?php echo e($isEdit ? 'bg-yellow-500 hover:bg-yellow-600' : 'bg-green-600 hover:bg-green-700'); ?>">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 -ms-1" viewBox="0 0 24 24" fill="currentColor">
                <path d="M17 3H5a2 2 0 0 0-2 2v14l4-4h10a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2Z"/>
            </svg>
            <span><?php echo e($isEdit ? 'Actualizar' : 'Guardar'); ?></span>
        </button>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\proyecto-pfp_b\resources\views/administrador/convocatorias/form.blade.php ENDPATH**/ ?>