
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
            Edición de Rubros
        </h2>
     <?php $__env->endSlot(); ?>

    <?php
        // Mantener la estructura original y añadir compatibilidad con las nuevas rutas seccionales
        $isEdit            = true;
        $action            = route('usuario.rubros-solicitados.update', $registroId ?? auth()->id()); // el partial lo ignora (usa rutas seccionales)
        $rubrosMontosPrev  = $rubrosMontosPrev ?? [];
        $otrosRubrosPrev   = $otrosRubrosPrev  ?? [];

        // Parámetro para rutas seccionales (id del usuario autenticado)
        $registroId        = $registroId ?? auth()->id();

        // Monto asignado con valor por defecto si no viene desde el controlador
        $montoAsignado     = isset($montoAsignado) ? (float) $montoAsignado : 150000.00;

        // Totales persistidos para bloqueo del botón en el front
        $totalRubrosBD     = $totalRubrosBD ?? (\App\Models\RubroSolicitado::where('user_id', auth()->id())->sum('monto') ?: 0);
        $totalOtrosBD      = $totalOtrosBD  ?? (\App\Models\OtroRubro::where('user_id', auth()->id())->sum('monto') ?: 0);
    ?>

    <?php echo $__env->make('usuario.rubros-solicitados.form', compact(
        'isEdit',
        'action',
        'montoAsignado',
        'categorias',
        'rubros',
        'rubrosMontosPrev',
        'otrosRubrosPrev',
        'registroId',
        'totalRubrosBD',
        'totalOtrosBD'
    ), array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
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

<?php /**PATH C:\xampp\htdocs\proyecto-pfp_b\resources\views/usuario/rubros-solicitados/edit.blade.php ENDPATH**/ ?>