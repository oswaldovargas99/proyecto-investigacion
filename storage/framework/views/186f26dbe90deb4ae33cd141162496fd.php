
<?php
    // Normaliza variables
    $row     = $row     ?? null;
    $prefill = (isset($prefill) && is_object($prefill)) ? $prefill : (object)[];

    // Helper para priorizar valores: old() → $row → $prefill → ''
    $val = function ($name, $rowField = null, $prefillField = null) use ($row, $prefill) {
        $rowField     = $rowField     ?? $name;
        $prefillField = $prefillField ?? $name;
        return old($name, ($row->$rowField ?? null) ?? ($prefill->$prefillField ?? ''));
    };
?>

<div x-data="{ a1:true, a2:false, a3:false }" class="space-y-4">

    
    <section class="rounded-xl border bg-white">
        
        <button type="button"
                class="w-full flex items-center justify-between gap-3 px-5 py-4 text-left hover:bg-gray-50"
                @click="a1 = !a1">
            <div class="flex items-center gap-3">
                <div class="h-9 w-9 rounded-full bg-blue-50 text-blue-700 ring-1 ring-inset ring-blue-200 flex items-center justify-center">
                    
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M18 2H8C6.9 2 6 2.9 6 4v15a3 3 0 0 1 3-3h10V4a2 2 0 0 0-1-1.73zM9 18c-1.1 0-2 .9-2 2s.9 2 2 2h10v-4H9z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-semibold text-gray-800">Datos del Posgrado</h3>
                    <p class="text-xs text-gray-500">Captura la información base del programa.</p>
                </div>
            </div>
            <svg x-show="!a1" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 rotate-0 transition-transform text-gray-500" viewBox="0 0 24 24" fill="currentColor"><path d="M7 10l5 5 5-5"/></svg>
            <svg x-show="a1"  xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 rotate-180 transition-transform text-gray-500" viewBox="0 0 24 24" fill="currentColor"><path d="M7 10l5 5 5-5"/></svg>
        </button>

        
        <div x-show="a1" x-collapse class="p-5 border-t">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                
                <div>
                    <label for="clave_snp" class="block text-sm font-medium text-gray-700">
                        Clave SNP <span class="text-red-600">*</span>
                    </label>
                    <div class="relative">
                        <input
                            type="text"
                            id="clave_snp"
                            name="clave_snp"
                            value="<?php echo e($val('clave_snp')); ?>"
                            placeholder="Ej. SNP-001"
                            required
                            class="w-full rounded-lg border-gray-300 pl-3 pr-9 py-2 text-sm placeholder:text-gray-400
                                   focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 <?php $__errorArgs = ['clave_snp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> !border-red-500 !ring-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        
                        <button type="button"
                                class="absolute inset-y-0 right-2 hidden items-center text-gray-400 hover:text-gray-600
                                       peer-[&:not(:placeholder-shown)]:flex"
                                onclick="document.getElementById('clave_snp').value='';document.getElementById('clave_snp').focus();"
                                aria-label="Limpiar">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="m13.41 12 4.3-4.29-1.42-1.42L12 10.59 7.71 6.29 6.29 7.71 10.59 12l-4.3 4.29 1.42 1.42L12 13.41l4.29 4.3 1.42-1.42z"/></svg>
                        </button>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Formato recomendado: <span class="font-medium">SNP-001</span>.</p>
                    <?php $__errorArgs = ['clave_snp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                
                <div>
                    <label for="posgrado_id" class="block text-sm font-medium text-gray-700">
                        Programa de Posgrado <span class="text-red-600">*</span>
                    </label>
                    <select
                        id="posgrado_id"
                        name="posgrado_id"
                        required
                        class="w-full rounded-lg border-gray-300 bg-white py-2 pl-3 pr-8 text-sm
                               focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 <?php $__errorArgs = ['posgrado_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> !border-red-500 !ring-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <option value="">-- Seleccionar --</option>
                        <?php $__currentLoopData = $posgrados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $nombre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($id); ?>" <?php if( (string)$val('posgrado_id') === (string)$id ): echo 'selected'; endif; ?>>
                                <?php echo e($nombre); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <p class="mt-1 text-xs text-gray-500">Selecciona el programa al que pertenece.</p>
                    <?php $__errorArgs = ['posgrado_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                
                <?php
                    // Valor seleccionado con prioridad: old() > $row > $prefill > ''
                    $cuSelected = (string) old(
                        'centro_universitario_id',
                        (string)($row->centro_universitario_id ?? ($prefill->centro_universitario_id ?? ''))
                    );
                ?>

                <div>
                    <label for="centro_universitario_id" class="block text-sm font-medium text-gray-700">
                        Centro Universitario <span class="text-red-600">*</span>
                    </label>

                    <select
                        id="centro_universitario_id"
                        name="centro_universitario_id"
                        required
                        class="w-full rounded border px-3 py-2
                            <?php $__errorArgs = ['centro_universitario_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 ring-1 ring-red-300 <?php else: ?> border-gray-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        aria-invalid="<?php $__errorArgs = ['centro_universitario_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> true <?php else: ?> false <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        aria-describedby="<?php $__errorArgs = ['centro_universitario_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> centro_universitario_id_error <?php else: ?> null <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <option value="">-- Seleccionar --</option>

                        
                        <?php $__currentLoopData = $centros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $nombre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($id); ?>" <?php echo e((string)$id === $cuSelected ? 'selected' : ''); ?>>
                                <?php echo e($nombre); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>

                    <?php $__errorArgs = ['centro_universitario_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p id="centro_universitario_id_error" class="text-red-500 text-sm mt-1"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                
                <div>
                    <label for="nivel_academico_id" class="block text-sm font-medium text-gray-700">
                        Nivel Académico <span class="text-red-600">*</span>
                    </label>
                    <select
                        id="nivel_academico_id"
                        name="nivel_academico_id"
                        required
                        class="w-full rounded-lg border-gray-300 bg-white py-2 pl-3 pr-8 text-sm
                               focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 <?php $__errorArgs = ['nivel_academico_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> !border-red-500 !ring-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <option value="">-- Seleccionar --</option>
                        <?php $__currentLoopData = $niveles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $nombre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($id); ?>" <?php if( (string)$val('nivel_academico_id') === (string)$id ): echo 'selected'; endif; ?>>
                                <?php echo e($nombre); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <p class="mt-1 text-xs text-gray-500">Especialidad, Maestría o Doctorado.</p>
                    <?php $__errorArgs = ['nivel_academico_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                
                <div>
                    <label for="orientacion_id" class="block text-sm font-medium text-gray-700">
                        Orientación <span class="text-red-600">*</span>
                    </label>
                    <select
                        id="orientacion_id"
                        name="orientacion_id"
                        required
                        class="w-full rounded-lg border-gray-300 bg-white py-2 pl-3 pr-8 text-sm
                               focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 <?php $__errorArgs = ['orientacion_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> !border-red-500 !ring-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <option value="">-- Seleccionar --</option>
                        <?php $__currentLoopData = $orientaciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $nombre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($id); ?>" <?php if( (string)$val('orientacion_id') === (string)$id ): echo 'selected'; endif; ?>>
                                <?php echo e($nombre); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <p class="mt-1 text-xs text-gray-500">Investigación, Profesionalizante, etc.</p>
                    <?php $__errorArgs = ['orientacion_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                
                <div>
                    <label for="modalidad_id" class="block text-sm font-medium text-gray-700">
                        Modalidad <span class="text-red-600">*</span>
                    </label>
                    <select
                        id="modalidad_id"
                        name="modalidad_id"
                        required
                        class="w-full rounded-lg border-gray-300 bg-white py-2 pl-3 pr-8 text-sm
                               focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 <?php $__errorArgs = ['modalidad_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> !border-red-500 !ring-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <option value="">-- Seleccionar --</option>
                        <?php $__currentLoopData = $modalidades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $nombre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($id); ?>" <?php if( (string)$val('modalidad_id') === (string)$id ): echo 'selected'; endif; ?>>
                                <?php echo e($nombre); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <p class="mt-1 text-xs text-gray-500">Escolarizada, Mixta, No escolarizada…</p>
                    <?php $__errorArgs = ['modalidad_id'];
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

    
    <section class="rounded-xl border bg-white">
        <button type="button"
                class="w-full flex items-center justify-between gap-3 px-5 py-4 text-left hover:bg-gray-50"
                @click="a2 = !a2">
            <div class="flex items-center gap-3">
                <div class="h-9 w-9 rounded-full bg-indigo-50 text-indigo-700 ring-1 ring-inset ring-indigo-200 flex items-center justify-center">
                    
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M12 12c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm0 2c-3.31 0-10 1.66-10 5v3h20v-3c0-3.34-6.69-5-10-5z"/></svg>
                </div>
                <div>
                    <h3 class="text-base font-semibold text-gray-800">Datos del Coordinador</h3>
                    <p class="text-xs text-gray-500">Información de contacto institucional.</p>
                </div>
            </div>
            <svg x-show="!a2" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 rotate-0 transition-transform text-gray-500" viewBox="0 0 24 24" fill="currentColor"><path d="M7 10l5 5 5-5"/></svg>
            <svg x-show="a2"  xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 rotate-180 transition-transform text-gray-500" viewBox="0 0 24 24" fill="currentColor"><path d="M7 10l5 5 5-5"/></svg>
        </button>

        <div x-show="a2" x-collapse class="p-5 border-t">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                
                <div>
                    <label for="codigo" class="block text-sm font-medium text-gray-700">Código <span class="text-red-600">*</span></label>
                    <input type="text" id="codigo" name="codigo"
                           value="<?php echo e($val('codigo')); ?>"
                           placeholder="Ej. 12345"
                           required
                           class="w-full rounded-lg border-gray-300 pl-3 pr-3 py-2 text-sm placeholder:text-gray-400
                                  focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 <?php $__errorArgs = ['codigo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> !border-red-500 !ring-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <?php $__errorArgs = ['codigo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                
                <div>
                    <label for="nombre_coordinador" class="block text-sm font-medium text-gray-700">Nombre del Coordinador <span class="text-red-600">*</span></label>
                    <input type="text" id="nombre_coordinador" name="nombre_coordinador"
                           value="<?php echo e($val('nombre_coordinador')); ?>"
                           required
                           class="w-full rounded-lg border-gray-300 pl-3 pr-3 py-2 text-sm placeholder:text-gray-400
                                  focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 <?php $__errorArgs = ['nombre_coordinador'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> !border-red-500 !ring-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <?php $__errorArgs = ['nombre_coordinador'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                
                <div>
                    <label for="correo_institucional" class="block text-sm font-medium text-gray-700">Correo Institucional <span class="text-red-600">*</span></label>
                    <input type="email" id="correo_institucional" name="correo_institucional"
                           value="<?php echo e($val('correo_institucional')); ?>"
                           placeholder="nombre@cu.uc.mx"
                           required
                           class="w-full rounded-lg border-gray-300 pl-3 pr-3 py-2 text-sm placeholder:text-gray-400
                                  focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 <?php $__errorArgs = ['correo_institucional'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> !border-red-500 !ring-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <?php $__errorArgs = ['correo_institucional'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                
                <div>
                    <label for="correo_alternativo" class="block text-sm font-medium text-gray-700">Correo Alternativo <span class="text-red-600">*</span></label>
                    <input type="email" id="correo_alternativo" name="correo_alternativo"
                           value="<?php echo e($val('correo_alternativo')); ?>"
                           placeholder="alterno@dominio.com"
                           required
                           class="w-full rounded-lg border-gray-300 pl-3 pr-3 py-2 text-sm placeholder:text-gray-400
                                  focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 <?php $__errorArgs = ['correo_alternativo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> !border-red-500 !ring-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <?php $__errorArgs = ['correo_alternativo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                
                <div>
                    <label for="telefono" class="block text-sm font-medium text-gray-700">Teléfono <span class="text-red-600">*</span></label>
                    <input type="text" id="telefono" name="telefono"
                           value="<?php echo e($val('telefono')); ?>"
                           placeholder="Ej. 33 1234 5678"
                           required
                           class="w-full rounded-lg border-gray-300 pl-3 pr-3 py-2 text-sm placeholder:text-gray-400
                                  focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 <?php $__errorArgs = ['telefono'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> !border-red-500 !ring-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <?php $__errorArgs = ['telefono'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                
                <div>
                    <label for="extension" class="block text-sm font-medium text-gray-700">Extensión <span class="text-red-600">*</span></label>
                    <input type="text" id="extension" name="extension"
                           value="<?php echo e($val('extension')); ?>"
                           required
                           class="w-full rounded-lg border-gray-300 pl-3 pr-3 py-2 text-sm placeholder:text-gray-400
                                  focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 <?php $__errorArgs = ['extension'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> !border-red-500 !ring-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <?php $__errorArgs = ['extension'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                
                <div>
                    <label for="celular" class="block text-sm font-medium text-gray-700">Celular <span class="text-red-600">*</span></label>
                    <input type="text" id="celular" name="celular"
                           value="<?php echo e($val('celular')); ?>"
                           placeholder="Ej. 3312345678"
                           required
                           class="w-full rounded-lg border-gray-300 pl-3 pr-3 py-2 text-sm placeholder:text-gray-400
                                  focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 <?php $__errorArgs = ['celular'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> !border-red-500 !ring-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <?php $__errorArgs = ['celular'];
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

    
    <section class="rounded-xl border bg-white">
        <button type="button"
                class="w-full flex items-center justify-between gap-3 px-5 py-4 text-left hover:bg-gray-50"
                @click="a3 = !a3">
            <div class="flex items-center gap-3">
                <div class="h-9 w-9 rounded-full bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-200 flex items-center justify-center">
                    
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5s-3 1.34-3 3 1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.67 0-8 1.34-8 4v3h10v-3c0-1.3.84-2.4 2.05-3.2C11.07 11.9 9.67 11 8 11zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.95 1.97 3.45v3h10v-3c0-2.66-5.33-4-8-4z"/></svg>
                </div>
                <div>
                    <h3 class="text-base font-semibold text-gray-800">Datos del Asistente</h3>
                    <p class="text-xs text-gray-500">Contacto y datos demográficos.</p>
                </div>
            </div>
            <svg x-show="!a3" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 rotate-0 transition-transform text-gray-500" viewBox="0 0 24 24" fill="currentColor"><path d="M7 10l5 5 5-5"/></svg>
            <svg x-show="a3"  xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 rotate-180 transition-transform text-gray-500" viewBox="0 0 24 24" fill="currentColor"><path d="M7 10l5 5 5-5"/></svg>
        </button>

        <div x-show="a3" x-collapse class="p-5 border-t">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                
                <div class="md:col-span-2">
                    <label for="nombre_asistente" class="block text-sm font-medium text-gray-700">Nombre del Asistente</label>
                    <input type="text" id="nombre_asistente" name="nombre_asistente"
                           value="<?php echo e($val('nombre_asistente')); ?>"
                           class="w-full rounded-lg border-gray-300 pl-3 pr-3 py-2 text-sm placeholder:text-gray-400
                                  focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 <?php $__errorArgs = ['nombre_asistente'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> !border-red-500 !ring-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <?php $__errorArgs = ['nombre_asistente'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                
                <div>
                    <label for="fecha_nacimiento_asistente" class="block text-sm font-medium text-gray-700">Fecha de Nacimiento</label>
                    <input
                        type="date"
                        id="fecha_nacimiento_asistente"
                        name="fecha_nacimiento_asistente"
                        class="w-full rounded-lg border-gray-300 pl-3 pr-3 py-2 text-sm
                               focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 <?php $__errorArgs = ['fecha_nacimiento_asistente'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> !border-red-500 !ring-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        value="<?php echo e(old('fecha_nacimiento_asistente',
                            ($row && $row->fecha_nacimiento_asistente)
                                ? \Illuminate\Support\Carbon::parse($row->fecha_nacimiento_asistente)->format('Y-m-d')
                                : (isset($prefill->fecha_nacimiento_asistente) && $prefill->fecha_nacimiento_asistente
                                    ? \Illuminate\Support\Carbon::parse($prefill->fecha_nacimiento_asistente)->format('Y-m-d')
                                    : '')
                        )); ?>">
                    <?php $__errorArgs = ['fecha_nacimiento_asistente'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                
                <div>
                    <label for="genero_id" class="block text-sm font-medium text-gray-700">Género</label>
                    <select id="genero_id" name="genero_id"
                            class="w-full rounded-lg border-gray-300 bg-white py-2 pl-3 pr-8 text-sm
                                   focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 <?php $__errorArgs = ['genero_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> !border-red-500 !ring-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <option value="">-- Seleccionar --</option>
                        <?php $__currentLoopData = $generos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $genero): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($id); ?>" <?php if( (string)$val('genero_id') === (string)$id ): echo 'selected'; endif; ?>>
                                <?php echo e($genero); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['genero_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                
                <div>
                    <label for="correo_asistente" class="block text-sm font-medium text-gray-700">Correo del Asistente</label>
                    <input type="email" id="correo_asistente" name="correo_asistente"
                           value="<?php echo e($val('correo_asistente')); ?>"
                           class="w-full rounded-lg border-gray-300 pl-3 pr-3 py-2 text-sm placeholder:text-gray-400
                                  focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 <?php $__errorArgs = ['correo_asistente'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> !border-red-500 !ring-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <?php $__errorArgs = ['correo_asistente'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                
                <div>
                    <label for="telefono_asistente" class="block text-sm font-medium text-gray-700">Teléfono del Asistente</label>
                    <input type="text" id="telefono_asistente" name="telefono_asistente"
                           value="<?php echo e($val('telefono_asistente')); ?>"
                           class="w-full rounded-lg border-gray-300 pl-3 pr-3 py-2 text-sm placeholder:text-gray-400
                                  focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 <?php $__errorArgs = ['telefono_asistente'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> !border-red-500 !ring-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <?php $__errorArgs = ['telefono_asistente'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                
                <div>
                    <label for="extension_asistente" class="block text-sm font-medium text-gray-700">Extensión del Asistente</label>
                    <input type="text" id="extension_asistente" name="extension_asistente"
                           value="<?php echo e($val('extension_asistente')); ?>"
                           class="w-full rounded-lg border-gray-300 pl-3 pr-3 py-2 text-sm placeholder:text-gray-400
                                  focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 <?php $__errorArgs = ['extension_asistente'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> !border-red-500 !ring-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <?php $__errorArgs = ['extension_asistente'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                
                <div>
                    <label for="celular_asistente" class="block text-sm font-medium text-gray-700">Celular del Asistente</label>
                    <input type="text" id="celular_asistente" name="celular_asistente"
                           value="<?php echo e($val('celular_asistente')); ?>"
                           class="w-full rounded-lg border-gray-300 pl-3 pr-3 py-2 text-sm placeholder:text-gray-400
                                  focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 <?php $__errorArgs = ['celular_asistente'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> !border-red-500 !ring-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <?php $__errorArgs = ['celular_asistente'];
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

</div>
<?php /**PATH C:\xampp\htdocs\proyecto-pfp_b\resources\views/usuario/datos-generales/form.blade.php ENDPATH**/ ?>