
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
            Dashboard de Usuario
        </h2>
     <?php $__env->endSlot(); ?>

    <div class="mx-auto max-w-7xl px-4 py-6">

        
        <div class="mb-8 flex items-center gap-4">
            
            <span class="select-none text-4xl md:text-5xl" aria-hidden="true">👋</span>

            

            <div class="min-w-0">
                <p class="text-3xl md:text-4xl font-extrabold text-blue-700 leading-tight">
                    Bienvenido, <?php echo e(auth()->user()->name); ?>.
                </p>
                <p class="mt-1 text-sm md:text-base text-blue-700/70">
                    Accede a las reglas de operación, solicitud e informe.
                </p>
            </div>
        </div>

        <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">

            
            <div
                class="group relative rounded-2xl bg-gradient-to-br from-white to-gray-50 p-6 
                    ring-1 ring-gray-100 hover:ring-blue-200/70 shadow-sm hover:shadow-md 
                    transition-all duration-200 hover:-translate-y-0.5 focus-within:ring-blue-300">
                <div class="flex items-start gap-4">
                    <div class="grid h-12 w-12 place-items-center rounded-xl bg-blue-100/80 ring-1 ring-blue-200">
                        
                        <svg class="h-6 w-6 text-blue-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                                d="M3 6h7a3 3 0 0 1 3 3v11H6a3 3 0 0 1-3-3V6z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                                d="M21 6h-7a3 3 0 0 0-3 3v11h7a3 3 0 0 0 3-3V6z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                                d="M12 9v11"/>
                        </svg>
                    </div>

                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2">
                            <h3 class="text-lg font-semibold text-gray-800 truncate">Reglas de Operación</h3>
                            <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-0.5 
                                        text-xs font-medium text-blue-600 ring-1 ring-inset ring-blue-200">PDF</span>
                        </div>
                        <p class="mt-1 text-sm text-gray-500">Descarga las reglas de operación en formato PDF.</p>

                        <div class="mt-4 flex items-center gap-3">
                            
                            <a href="https://vicerrectoriaacademica.udg.mx/sites/default/files/2025-03/3-ROP_PCP_2025.pdf"
                            download="3-ROP_PCP_2025.pdf"
                            class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-3.5 py-2 
                                    text-sm font-medium text-white hover:bg-blue-700 
                                    focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 
                                    focus-visible:ring-offset-2 focus-visible:ring-offset-white">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M4 20h16M12 4v10m0 0l-4-4m4 4l4-4"/>
                                </svg>
                                Descargar ROP
                            </a>

                            
                            <a href="https://vicerrectoriaacademica.udg.mx/sites/default/files/2025-03/3-ROP_PCP_2025.pdf"
                            target="_blank" rel="noopener"
                            class="text-sm font-medium text-blue-700 hover:text-blue-800">
                                Ver vista previa
                            </a>
                        </div>
                    </div>
                </div>
            </div>


            
            <div
                class="group relative rounded-2xl bg-gradient-to-br from-white to-gray-50 p-6 
                       ring-1 ring-gray-100 hover:ring-blue-200/70 shadow-sm hover:shadow-md 
                       transition-all duration-200 hover:-translate-y-0.5 focus-within:ring-blue-300">
                <div class="flex items-start gap-4">
                    <div class="grid h-12 w-12 place-items-center rounded-xl bg-blue-100/80 ring-1 ring-blue-200">
                        
                        <svg class="h-6 w-6 text-blue-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                                  d="M6 4h7l5 5v11a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M13 4v5h5"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M8 13h8M8 17h6"/>
                        </svg>
                    </div>

                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2">
                            <h3 class="text-lg font-semibold text-gray-800 truncate">Solicitud</h3>
                            <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-0.5 
                                           text-xs font-medium text-blue-600 ring-1 ring-inset ring-blue-200">PDF</span>
                        </div>
                        <p class="mt-1 text-sm text-gray-500">Descarga la solicitud en formato PDF.</p>

                        <div class="mt-4 flex items-center gap-3">
                            
                            <a href="<?php echo e(route('usuario.oficios.solicitud.pdf')); ?>" download="solicitud-pfp-2025.pdf"
                               class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-3.5 py-2 
                                      text-sm font-medium text-white hover:bg-blue-700 
                                      focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 
                                      focus-visible:ring-offset-2 focus-visible:ring-offset-white">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                          d="M4 20h16M12 4v10m0 0l-4-4m4 4l4-4"/>
                                </svg>
                                Descargar Solicitud
                            </a>

                            
                            <a href="<?php echo e(route('usuario.oficios.solicitud.pdf')); ?>" target="_blank"
                               class="text-sm font-medium text-blue-700 hover:text-blue-800">
                                Ver vista previa
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            
            <div
                class="group relative rounded-2xl bg-gradient-to-br from-white to-gray-50 p-6 
                       ring-1 ring-gray-100 hover:ring-blue-200/70 shadow-sm hover:shadow-md 
                       transition-all duration-200 hover:-translate-y-0.5 focus-within:ring-blue-300">
                <div class="flex items-start gap-4">
                    <div class="grid h-12 w-12 place-items-center rounded-xl bg-blue-100/80 ring-1 ring-blue-200">
                        
                        <svg class="h-6 w-6 text-blue-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6"
                                  d="M9 4h6a2 2 0 0 1 2 2v1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V9a2 2 0 0 1 2-2h1V6a2 2 0 0 1 2-2z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M9 6h6"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M8 12h8M8 16h8"/>
                        </svg>
                    </div>

                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2">
                            <h3 class="text-lg font-semibold text-gray-800 truncate">Informe</h3>
                            <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-0.5 
                                           text-xs font-medium text-blue-600 ring-1 ring-inset ring-blue-200">PDF</span>
                        </div>
                        <p class="mt-1 text-sm text-gray-500">Descarga el Informe en formato PDF.</p>

                        <div class="mt-4 flex items-center gap-3">
                            
                            <a href="<?php echo e(route('usuario.oficios.solicitud.pdf')); ?>" download="informe-pfp-2025.pdf"
                               class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-3.5 py-2 
                                      text-sm font-medium text-white hover:bg-blue-700 
                                      focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 
                                      focus-visible:ring-offset-2 focus-visible:ring-offset-white">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                          d="M4 20h16M12 4v10m0 0l-4-4m4 4l4-4"/>
                                </svg>
                                Descargar Informe
                            </a>

                            
                            <a href="<?php echo e(route('usuario.oficios.solicitud.pdf')); ?>" target="_blank"
                               class="text-sm font-medium text-blue-700 hover:text-blue-800">
                                Ver vista previa
                            </a>
                        </div>
                    </div>
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
<?php /**PATH C:\xampp\htdocs\proyecto-pfp_b\resources\views/usuario/dashboard.blade.php ENDPATH**/ ?>