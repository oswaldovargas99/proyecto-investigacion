<!-- resources/views/administrador/coordinadores/form.blade.php -->

<div class="bg-white shadow-sm rounded-2xl border p-6 space-y-8">

    
    <section class="rounded-xl border bg-gray-50/50 p-5">
        <header class="mb-4 flex items-center gap-3">
            <div class="h-9 w-9 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center">
                <!-- icon user -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5Zm0 2c-5 0-9 2.5-9 5.5V22h18v-2.5C21 16.5 17 14 12 14Z"/></svg>
            </div>
            <h3 class="text-base font-semibold text-gray-800">Datos Generales</h3>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <!-- Código -->
            <div>
                <label for="codigo" class="block text-sm font-medium text-gray-700">
                    Código <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    name="codigo"
                    id="codigo"
                    value="<?php echo e(old('codigo', $coordinador->codigo ?? '')); ?>"
                    required
                    placeholder="Ej. A12345"
                    class="mt-1 w-full rounded-lg border-gray-300 px-3 py-2
                           focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500"
                >
                <p class="text-xs text-gray-500 mt-1">Identificador único del/la coordinador(a).</p>
                <?php $__errorArgs = ['codigo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Nombre -->
            <div>
                <label for="nombre_coordinador" class="block text-sm font-medium text-gray-700">
                    Nombre del/la Coordinador(a) <span class="text-red-500">*</span>
                </label>
                <input
                    type="text"
                    name="nombre_coordinador"
                    id="nombre_coordinador"
                    value="<?php echo e(old('nombre_coordinador', $coordinador->nombre_coordinador ?? '')); ?>"
                    required
                    placeholder="Nombre completo"
                    class="mt-1 w-full rounded-lg border-gray-300 px-3 py-2
                           focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500"
                >
                <p class="text-xs text-gray-500 mt-1">Tal como aparecerá en documentos oficiales.</p>
                <?php $__errorArgs = ['nombre_coordinador'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Centro Universitario -->
            <div>
                <label for="centro_universitario_id" class="block text-sm font-medium text-gray-700">
                    Centro Universitario <span class="text-red-500">*</span>
                </label>
                <select
                    name="centro_universitario_id"
                    id="centro_universitario_id"
                    required
                    class="mt-1 w-full rounded-lg border-gray-300 px-3 py-2 bg-white
                           focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500"
                >
                    <option value="">-- Selecciona --</option>
                    <?php $__currentLoopData = $centros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $centro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($centro->id); ?>"
                            <?php echo e((string)old('centro_universitario_id', $coordinador->centro_universitario_id ?? '') === (string)$centro->id ? 'selected' : ''); ?>>
                            <?php echo e($centro->centro_universitario); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <p class="text-xs text-gray-500 mt-1">Seleccione el centro al que pertenece.</p>
                <?php $__errorArgs = ['centro_universitario_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Posgrado -->
            <div>
                <label for="posgrado_id" class="block text-sm font-medium text-gray-700">
                    Posgrado <span class="text-red-500">*</span>
                </label>
                <select
                    name="posgrado_id"
                    id="posgrado_id"
                    required
                    class="mt-1 w-full rounded-lg border-gray-300 px-3 py-2 bg-white
                           focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500"
                >
                    <option value="">-- Selecciona --</option>
                    <?php $__currentLoopData = $posgrados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $posgrado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($posgrado->id); ?>"
                            <?php echo e((string)old('posgrado_id', $coordinador->posgrado_id ?? '') === (string)$posgrado->id ? 'selected' : ''); ?>>
                            <?php echo e($posgrado->nombre_posgrado); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <p class="text-xs text-gray-500 mt-1">Programa de posgrado relacionado.</p>
                <?php $__errorArgs = ['posgrado_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Género -->
            <div>
                <label for="genero_id" class="block text-sm font-medium text-gray-700">
                    Género <span class="text-red-500">*</span>
                </label>
                <select
                    name="genero_id"
                    id="genero_id"
                    required
                    class="mt-1 w-full rounded-lg border-gray-300 px-3 py-2 bg-white
                           focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500"
                >
                    <option value="">-- Selecciona --</option>
                    <?php $__currentLoopData = $generos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($g->id); ?>"
                            <?php echo e((string)old('genero_id', $coordinador->genero_id ?? '') === (string)$g->id ? 'selected' : ''); ?>>
                            <?php echo e($g->genero); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <p class="text-xs text-gray-500 mt-1">Elija del catálogo institucional.</p>
                <?php $__errorArgs = ['genero_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Nivel de estudios -->
            <div>
                <label for="nivel_estudios_id" class="block text-sm font-medium text-gray-700">
                    Nivel de estudios <span class="text-red-500">*</span>
                </label>
                <select
                    name="nivel_estudios_id"
                    id="nivel_estudios_id"
                    required
                    class="mt-1 w-full rounded-lg border-gray-300 px-3 py-2 bg-white
                           focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500"
                >
                    <option value="">-- Selecciona --</option>
                    <?php $__currentLoopData = $nivelesEstudios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $n): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($n->id); ?>"
                            <?php echo e((string)old('nivel_estudios_id', $coordinador->nivel_estudios_id ?? '') === (string)$n->id ? 'selected' : ''); ?>>
                            <?php echo e($n->nivel_estudios); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <p class="text-xs text-gray-500 mt-1">Último grado académico concluido.</p>
                <?php $__errorArgs = ['nivel_estudios_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Fecha de nacimiento -->
            <div>
                <label for="fecha_nacimiento" class="block text-sm font-medium text-gray-700">
                    Fecha de nacimiento <span class="text-red-500">*</span>
                </label>
                <?php
                    $fnOld = old('fecha_nacimiento');
                    $fnVal = $fnOld !== null
                        ? $fnOld
                        : (isset($coordinador->fecha_nacimiento) && $coordinador->fecha_nacimiento
                            ? \Illuminate\Support\Carbon::parse($coordinador->fecha_nacimiento)->format('Y-m-d')
                            : '');
                ?>
                <input
                    type="date"
                    name="fecha_nacimiento"
                    id="fecha_nacimiento"
                    value="<?php echo e($fnVal); ?>"
                    required
                    class="mt-1 w-full rounded-lg border-gray-300 px-3 py-2
                           focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500"
                >
                <p class="text-xs text-gray-500 mt-1">Formato: AAAA-MM-DD.</p>
                <?php $__errorArgs = ['fecha_nacimiento'];
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
                <!-- icon mail/phone -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M12 13 2 6.76V18h20V6.76L12 13Zm0-2L2 4h20L12 11Z"/></svg>
            </div>
            <h3 class="text-base font-semibold text-gray-800">Contacto</h3>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
                <label for="correo_institucional" class="block text-sm font-medium text-gray-700">
                    Correo institucional <span class="text-red-500">*</span>
                </label>
                <input
                    type="email"
                    name="correo_institucional"
                    id="correo_institucional"
                    value="<?php echo e(old('correo_institucional', $coordinador->correo_institucional ?? '')); ?>"
                    placeholder="ejemplo@institucion.edu.mx"
                    required
                    class="mt-1 w-full rounded-lg border-gray-300 px-3 py-2
                           focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500"
                >
                <p class="text-xs text-gray-500 mt-1">Use su correo institucional activo.</p>
                <?php $__errorArgs = ['correo_institucional'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div>
                <label for="correo_alternativo" class="block text-sm font-medium text-gray-700">
                    Correo alternativo
                </label>
                <input
                    type="email"
                    name="correo_alternativo"
                    id="correo_alternativo"
                    value="<?php echo e(old('correo_alternativo', $coordinador->correo_alternativo ?? '')); ?>"
                    placeholder="correo@alternativo.com"
                    class="mt-1 w-full rounded-lg border-gray-300 px-3 py-2
                           focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500"
                >
                <p class="text-xs text-gray-500 mt-1">Opcional, para notificaciones de respaldo.</p>
                <?php $__errorArgs = ['correo_alternativo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div>
                <label for="telefono" class="block text-sm font-medium text-gray-700">
                    Teléfono
                </label>
                <input
                    type="text"
                    name="telefono"
                    id="telefono"
                    value="<?php echo e(old('telefono', $coordinador->telefono ?? '')); ?>"
                    placeholder="Ej. 33 1234 5678"
                    class="mt-1 w-full rounded-lg border-gray-300 px-3 py-2
                           focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500"
                >
                <p class="text-xs text-gray-500 mt-1">Incluya lada si aplica.</p>
                <?php $__errorArgs = ['telefono'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div>
                <label for="extension" class="block text-sm font-medium text-gray-700">
                    Extensión
                </label>
                <input
                    type="text"
                    name="extension"
                    id="extension"
                    value="<?php echo e(old('extension', $coordinador->extension ?? '')); ?>"
                    placeholder="Ej. 1234"
                    class="mt-1 w-full rounded-lg border-gray-300 px-3 py-2
                           focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500"
                >
                <p class="text-xs text-gray-500 mt-1">Solo números.</p>
                <?php $__errorArgs = ['extension'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-sm mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="md:col-span-2">
                <label for="celular" class="block text-sm font-medium text-gray-700">
                    Celular
                </label>
                <input
                    type="text"
                    name="celular"
                    id="celular"
                    value="<?php echo e(old('celular', $coordinador->celular ?? '')); ?>"
                    placeholder="Ej. 33 1234 5678"
                    class="mt-1 w-full rounded-lg border-gray-300 px-3 py-2
                           focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500"
                >
                <p class="text-xs text-gray-500 mt-1">Teléfono móvil de contacto.</p>
                <?php $__errorArgs = ['celular'];
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
        <a href="<?php echo e(route('admin.coordinadores.index')); ?>"
           class="inline-flex items-center justify-center gap-2 bg-gray-700 text-white px-5 py-2.5 rounded-lg hover:bg-gray-800">
            <!-- back icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 -ms-1" viewBox="0 0 24 24" fill="currentColor"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2Z"/></svg>
            <span>Regresar</span>
        </a>

        <button type="submit"
            class="inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-lg text-white
                   <?php echo e(isset($coordinador) ? 'bg-yellow-500 hover:bg-yellow-600' : 'bg-green-600 hover:bg-green-700'); ?>">
            <!-- save icon -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 -ms-1" viewBox="0 0 24 24" fill="currentColor"><path d="M17 3H5a2 2 0 0 0-2 2v14l4-4h10a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2Z"/></svg>
            <span><?php echo e(isset($coordinador) ? 'Actualizar' : 'Guardar'); ?></span>
        </button>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\proyecto-pfp_b\resources\views/administrador/coordinadores/form.blade.php ENDPATH**/ ?>