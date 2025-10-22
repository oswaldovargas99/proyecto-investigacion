<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="mt-6 sm:mt-24 text-xl font-semibold text-gray-800 leading-tight">
            Actualizar Solicitud
        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-6">
        <div class="max-w-5xl mx-auto px-4">
            <?php if($errors->any()): ?>
                <div class="mb-4 rounded-md border border-red-300 bg-red-50 p-4 text-sm text-red-700">
                    <strong class="font-semibold">Se encontraron errores:</strong>
                    <ul class="mt-2 list-disc ps-6">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if(session('success')): ?>
                <div x-data="{ show: true }" x-init="setTimeout(()=>show=false, 5000)" x-show="show"
                    class="mb-4 rounded-md border border-yellow-300 bg-yellow-50 p-3 text-yellow-800 text-sm">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('usuario.solicitud.update', $solicitud->id)); ?>">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <?php echo $__env->make('usuario.solicitud.form', [
                    'solicitud' => $solicitud,
                    'temas' => $temas,
                    'temasSeleccionados' => old('temas', $temasSeleccionados ?? []),
                    'codigo' => $codigo ?? '',
                    'nombre_coordinador' => $nombre_coordinador ?? '',
                    'submitLabel' => 'Actualizar'
                ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </form>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH C:\xampp\htdocs\proyecto-pfp_b\resources\views/usuario/solicitud/edit.blade.php ENDPATH**/ ?>