<!-- resources/views/administrador/convocatorias/show.blade.php -->
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
            Detalle de la Convocatoria
        </h2>
     <?php $__env->endSlot(); ?>

    <?php
        $isActive = (bool) ($convocatoria->id_status ?? false);

        // Iniciales para el avatar (a partir del nombre de la convocatoria)
        $parts = preg_split('/\s+/', trim($convocatoria->nombre_convocatoria ?? ''));
        $first = strtoupper(mb_substr($parts[0] ?? '', 0, 1));
        $last  = strtoupper(mb_substr(end($parts) ?: '', 0, 1));
        $initials = ($first ?: 'C') . ($last ?: '');

        $fi = $convocatoria->fecha_inicio ? \Carbon\Carbon::parse($convocatoria->fecha_inicio) : null;
        $ff = $convocatoria->fecha_fin ? \Carbon\Carbon::parse($convocatoria->fecha_fin) : null;
    ?>

    <div class="py-6">
        <div class="mx-auto max-w-6xl px-4 space-y-6">

            
            <div class="flex items-center justify-between rounded-2xl border bg-white px-5 py-4 shadow-sm">
                <div class="flex items-center gap-4">
                    <div class="flex h-12 w-12 items-center justify-center rounded-full bg-indigo-100 text-indigo-700">
                        <span class="text-sm font-semibold"><?php echo e($initials); ?></span>
                    </div>
                    <div>
                        <h3 class="text-base sm:text-lg font-semibold text-gray-900">
                            <?php echo e($convocatoria->nombre_convocatoria); ?>

                        </h3>
                        <p class="text-xs text-gray-500">
                            ID:
                            <span class="font-semibold text-indigo-600">#<?php echo e($convocatoria->id); ?></span>
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <a href="<?php echo e(route('admin.convocatorias.edit', $convocatoria)); ?>"
                       class="inline-flex items-center gap-2 rounded-lg bg-yellow-500 px-3 py-2 text-sm font-semibold text-white hover:bg-yellow-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 -ms-0.5" viewBox="0 0 24 24" fill="currentColor">
                            <path d="m3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04a1.004 1.004 0 0 0 0-1.42l-2.34-2.34a1.004 1.004 0 0 0-1.42 0l-1.83 1.83 3.75 3.75 1.84-1.82z"/>
                        </svg>
                        <span>Editar</span>
                    </a>

                    <a href="<?php echo e(route('admin.convocatorias.index')); ?>"
                       class="inline-flex items-center gap-2 rounded-lg bg-gray-800 px-3 py-2 text-sm font-semibold text-white hover:bg-gray-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 -ms-0.5" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2Z"/>
                        </svg>
                        <span>Regresar</span>
                    </a>

                    
                    <form action="<?php echo e(route('admin.convocatorias.destroy', $convocatoria)); ?>" method="POST"
                          onsubmit="return confirm('¿Eliminar esta convocatoria?');">
                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                        <button type="submit"
                                class="inline-flex items-center gap-2 rounded-lg bg-red-600 px-3 py-2 text-sm font-semibold text-white hover:bg-red-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 -ms-0.5" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M6 7h12v2H6zm2 3h2v8H8zm6 0h2v8h-2z"/><path d="M15.5 4 14 3H10L8.5 4H5v2h14V4z"/>
                            </svg>
                            <span>Eliminar</span>
                        </button>
                    </form>
                </div>
            </div>

            
            <div class="space-y-6">

                
                <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                    
                    <section class="rounded-2xl border bg-white p-5 shadow-sm">
                        <header class="mb-4 flex items-center gap-3">
                            <div class="h-9 w-9 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center">
                                
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2a10 10 0 1 0 .001 20.001A10 10 0 0 0 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/>
                                </svg>
                            </div>
                            <h3 class="text-base font-semibold text-gray-800">Información general</h3>
                        </header>

                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Lema</span>
                                <span class="text-sm font-medium text-gray-800"><?php echo e($convocatoria->lema ?? '—'); ?></span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Año</span>
                                <span class="text-sm font-medium text-gray-800"><?php echo e($convocatoria->anio); ?></span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Responsable</span>
                                <span class="text-sm font-medium text-gray-800"><?php echo e($convocatoria->responsable ?? '—'); ?></span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Cargo</span>
                                <span class="text-sm font-medium text-gray-800"><?php echo e($convocatoria->cargo ?? '—'); ?></span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Estado</span>
                                <?php if($isActive): ?>
                                    <span class="inline-flex items-center rounded-full bg-green-50 px-2.5 py-0.5 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-200">
                                        Activa
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center rounded-full bg-red-50 px-2.5 py-0.5 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-200">
                                        Inactiva
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </section>

                    
                    <section class="rounded-2xl border bg-white p-5 shadow-sm">
                        <header class="mb-4 flex items-center gap-3">
                            <div class="h-9 w-9 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center">
                                
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M7 2h2v3H7V2zm8 0h2v3h-2V2z"/><path d="M5 6h14a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2zm0 4v9h14v-9H5z"/>
                                </svg>
                            </div>
                            <h3 class="text-base font-semibold text-gray-800">Periodo</h3>
                        </header>

                        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                            <div class="rounded-xl border bg-gray-50 px-4 py-3">
                                <p class="text-[11px] font-semibold tracking-wider text-gray-500">FECHA DE INICIO</p>
                                <p class="mt-1 text-sm text-gray-800">
                                    <?php echo e($fi ? $fi->format('d/m/Y') : '—'); ?>

                                </p>
                            </div>
                            <div class="rounded-xl border bg-gray-50 px-4 py-3">
                                <p class="text-[11px] font-semibold tracking-wider text-gray-500">FECHA DE CIERRE</p>
                                <p class="mt-1 text-sm text-gray-800">
                                    <?php echo e($ff ? $ff->format('d/m/Y') : '—'); ?>

                                </p>
                            </div>

                            <div class="md:col-span-2 rounded-xl border bg-gray-50 px-4 py-3">
                                <p class="text-[11px] font-semibold tracking-wider text-gray-500">NOTA</p>
                                <p class="mt-1 text-sm text-gray-700">
                                    Los plazos pueden ajustarse según la publicación oficial.
                                </p>
                            </div>
                        </div>
                    </section>
                </div>

                
                <section class="rounded-2xl border bg-white p-5 shadow-sm">
                    <header class="mb-4 flex items-center gap-3">
                        <div class="h-9 w-9 rounded-full bg-sky-100 text-sky-700 flex items-center justify-center">
                            
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2a10 10 0 1 0 .001 20.001A10 10 0 0 0 12 2zm1 11h5v-2h-4V7h-2v6z"/>
                            </svg>
                        </div>
                        <h3 class="text-base font-semibold text-gray-800">Metadatos</h3>
                    </header>

                    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                        <div class="rounded-xl border bg-gray-50 px-4 py-3">
                            <p class="text-[11px] font-semibold tracking-wider text-gray-500">CREADA EL</p>
                            <p class="mt-1 text-sm text-gray-800">
                                <?php echo e(optional($convocatoria->created_at)->format('d/m/Y H:i') ?? '—'); ?>

                            </p>
                        </div>

                        <div class="rounded-xl border bg-gray-50 px-4 py-3">
                            <p class="text-[11px] font-semibold tracking-wider text-gray-500">ACTUALIZADA EL</p>
                            <p class="mt-1 text-sm text-gray-800">
                                <?php echo e(optional($convocatoria->updated_at)->format('d/m/Y H:i') ?? '—'); ?>

                            </p>
                        </div>

                        <div class="rounded-xl border bg-gray-50 px-4 py-3">
                            <p class="text-[11px] font-semibold tracking-wider text-gray-500">ID CONVOCATORIA</p>
                            <p class="mt-1 text-sm text-gray-800">#<?php echo e($convocatoria->id); ?></p>
                        </div>
                    </div>
                </section>

            </div>
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
<?php /**PATH C:\xampp\htdocs\proyecto-pfp_b\resources\views/administrador/convocatorias/show.blade.php ENDPATH**/ ?>