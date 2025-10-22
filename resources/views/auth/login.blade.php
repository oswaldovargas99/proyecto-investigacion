<x-guest-layout>
    <style>
        [x-cloak]{ display:none !important; }

        /* Fondo fijo con efecto sutil */
        #wallpaper{
            background-attachment: fixed;
            will-change: transform, opacity;
            animation: kb 22s ease-in-out infinite alternate;
        }
        @keyframes kb{
            0%   { transform: scale(1.03) translateY(0); }
            100% { transform: scale(1.08) translateY(-1%); }
        }

        /* Botón con gradiente (opcional) */
        .btn-gradient{
            background: linear-gradient(90deg, #4f46e5, #7c3aed, #4f46e5);
            background-size: 200% 100%;
            transition: background-position .6s ease, transform .2s ease;
        }
        .btn-gradient:hover{ background-position: 100% 0; transform: translateY(-1px); }
        .btn-gradient:active{ transform: translateY(0); }
    </style>

    <div class="relative min-h-screen w-full overflow-hidden"
         x-data="{ show:false, privacy:false }"
         x-init="setTimeout(() => show = true, 120)">

        {{-- Fondo único --}}
        <div id="wallpaper"
             class="absolute inset-0 -z-10 bg-cover bg-center bg-no-repeat transition-opacity duration-700"
             style="background-image:url('{{ asset('images/login/cgipv04.jpg') }}')"></div>

        <div class="absolute inset-0 -z-10 bg-gradient-to-b from-black/35 via-black/25 to-black/40"></div>

        {{-- ======================== TOASTS (arriba a la derecha) ======================== --}}
        @if (session('success'))
            <div x-data="{ show:true }" x-init="setTimeout(()=> show=false, 4200)" x-show="show" x-cloak x-transition
                 class="fixed top-4 right-4 z-[11000] max-w-sm">
                <div class="flex items-start gap-3 rounded-lg bg-emerald-600 text-white px-4 py-3 shadow-lg ring-1 ring-emerald-500/40">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mt-0.5" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M9 12.75 10.5 14.25 15 9.75 16.5 11.25 10.5 17.25 7.5 14.25 9 12.75Z"/>
                    </svg>
                    <div class="text-sm/5">
                        <div class="font-semibold">Éxito</div>
                        <div>{{ session('success') }}</div>
                    </div>
                    <button class="ms-auto opacity-80 hover:opacity-100" @click="show=false" aria-label="Cerrar">
                        ✕
                    </button>
                </div>
            </div>
        @endif

        @if (session('status'))
            <div x-data="{ show:true }" x-init="setTimeout(()=> show=false, 4200)" x-show="show" x-cloak x-transition
                 class="fixed top-4 right-4 z-[11000] max-w-sm">
                <div class="flex items-start gap-3 rounded-lg bg-indigo-600 text-white px-4 py-3 shadow-lg ring-1 ring-indigo-500/40">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mt-0.5" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 3 1 9l11 6 9-4.91V17h2V9L12 3Z"/>
                    </svg>
                    <div class="text-sm/5">
                        <div class="font-semibold">Información</div>
                        <div>{{ session('status') }}</div>
                    </div>
                    <button class="ms-auto opacity-80 hover:opacity-100" @click="show=false" aria-label="Cerrar">
                        ✕
                    </button>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div x-data="{ show:true }" x-init="setTimeout(()=> show=false, 5200)" x-show="show" x-cloak x-transition
                 class="fixed top-4 right-4 z-[11000] max-w-sm">
                <div class="flex items-start gap-3 rounded-lg bg-rose-600 text-white px-4 py-3 shadow-lg ring-1 ring-rose-500/40">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mt-0.5" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M11 7h2v6h-2V7Zm0 8h2v2h-2v-2Zm1-13C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2Z"/>
                    </svg>
                    <div class="text-sm/5">
                        <div class="font-semibold">Error</div>
                        <div>{{ session('error') }}</div>
                    </div>
                    <button class="ms-auto opacity-80 hover:opacity-100" @click="show=false" aria-label="Cerrar">
                        ✕
                    </button>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div x-data="{ show:true }" x-init="setTimeout(()=> show=false, 6000)" x-show="show" x-cloak x-transition
                 class="fixed top-4 right-4 z-[11000] max-w-sm">
                <div class="flex items-start gap-3 rounded-lg bg-amber-600 text-white px-4 py-3 shadow-lg ring-1 ring-amber-500/40">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mt-0.5" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M1 21h22L12 2 1 21Zm12-3h-2v-2h2v2Zm0-4h-2v-4h2v4Z"/>
                    </svg>
                    <div class="text-sm/5">
                        <div class="font-semibold">Hay errores en el formulario</div>
                        <div>Revisa los campos marcados ({{ $errors->count() }}).</div>
                    </div>
                    <button class="ms-auto opacity-80 hover:opacity-100" @click="show=false" aria-label="Cerrar">
                        ✕
                    </button>
                </div>
            </div>
        @endif


        {{-- ====================== FIN TOASTS ====================== --}}

        {{-- Contenido principal --}}
        <div class="mx-auto flex min-h-screen max-w-7xl items-center justify-center px-4 py-8">
            <div class="w-full max-w-md">
                {{-- Card blanco --}}
                <div x-bind:class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-3'"
                     class="rounded-2xl border border-slate-200 bg-white shadow-xl transition-all duration-500 ease-out">

                    {{-- Encabezado --}}
                    <div class="flex flex-col items-center gap-4 px-6 pt-8 pb-2 text-center">
                        <img id="login-logo" src="{{ asset('images/login/logo_cgipv01.png') }}" alt="Logo CGIPV"
                             class="object-contain" />
                        <h1 class="text-xl font-semibold text-slate-800 leading-snug">
                            Programa de Fortalecimiento del<br class="hidden sm:block"> Posgrado (PFP)
                        </h1>
                    </div>

                    <style>
                        #login-logo { width: 150px; height: auto; } /* ajusta a gusto */
                    </style>

                    {{-- Formulario --}}
                    <div class="px-6 pt-3 pb-6 space-y-4">
                        {{-- Alerta de errores en bloque (se mantiene, además del toast) --}}
                        @if ($errors->any())
                            <div 
                                x-data="{ show:true }" 
                                x-init="setTimeout(()=> show=false, 5000)" 
                                x-show="show"
                                x-transition.opacity.duration.500ms
                                x-cloak
                                class="rounded-lg border border-red-200 bg-red-50 px-3 py-2.5 text-sm text-red-700"
                                role="alert"
                            >
                                <div class="font-semibold mb-1">No fue posible iniciar sesión</div>
                                <ul class="list-disc pl-5 space-y-0.5">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif


                        <form method="POST" action="{{ route('login') }}" class="space-y-3.5" novalidate>
                            @csrf

                            {{-- Email --}}
                            <div class="space-y-1">
                                <label for="email" class="text-sm font-medium text-slate-700">Correo electrónico</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-3 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M20 4H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2Zm0 4-8 5L4 8V6l8 5 8-5Z"/>
                                        </svg>
                                    </span>
                                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                                           class="w-full rounded-lg pl-9 pr-3 py-2.5 border @error('email') border-red-400 @else border-slate-300 @enderror
                                                  bg-white placeholder-slate-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/30"
                                           placeholder="admin@udg.mx" autocomplete="username">
                                </div>
                            </div>

                            {{-- Contraseña con ojo (Alpine) --}}
                            <div class="space-y-1">
                                <label for="password" class="text-sm font-medium text-slate-700">Contraseña</label>
                                <div class="relative" x-data="{ visible:false }">
                                    <span class="absolute inset-y-0 left-3 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 1a5 5 0 0 0-5 5v3H5a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V10a1 1 0 0 0-1-1h-2V6a5 5 0 0 0-5-5Zm-3 8V6a3 3 0 1 1 6 0v3Z"/>
                                        </svg>
                                    </span>

                                    <input id="password" name="password" :type="visible ? 'text' : 'password'" required
                                           class="w-full rounded-lg pl-9 pr-10 py-2.5 border @error('password') border-red-400 @else border-slate-300 @enderror
                                                  bg-white placeholder-slate-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/30"
                                           placeholder="••••••••" autocomplete="current-password">

                                    {{-- Botón ojo --}}
                                    <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-500 hover:text-[#003366] focus:outline-none"
                                            @click="visible = !visible" :aria-label="visible ? 'Ocultar contraseña' : 'Mostrar contraseña'">
                                        {{-- ojo cerrado --}}
                                        <svg x-show="!visible" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                             viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                  d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 15.39 7.046 18 12 18c4.954 0 8.774-2.61 10.066-6a10.474 10.474 0 00-2.905-3.776M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        {{-- ojo abierto --}}
                                        <svg x-show="visible" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                             viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                  d="M3 3l18 18" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <div class="flex items-center justify-between pt-1">
                                <label class="flex items-center gap-2 text-sm text-slate-600">
                                    <input type="checkbox" name="remember"
                                           class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                                    Mantener sesión activa
                                </label>
                                @if (Route::has('password.request'))
                                    <a class="text-sm font-medium text-indigo-600 hover:text-indigo-700"
                                       href="{{ route('password.request') }}">
                                       ¿Olvidó su contraseña?
                                    </a>
                                @endif
                            </div>

                            {{-- Botón centrado --}}
                            <div class="flex justify-center mt-4">
                                <style>
                                    .btn-login {
                                        width: 280px;   /* ancho fijo */
                                        height: 45px;   /* alto fijo */
                                    }
                                </style>

                                <button type="submit" class="btn-login bg-[#003366] text-white rounded-md hover:bg-[#002244] transition">
                                    Iniciar sesión
                                </button>
                            </div>

                            {{-- Aviso de privacidad --}}
                            <div class="mt-2 text-center">
                                <button type="button"
                                        class="text-[14px] text-slate-600 underline underline-offset-4 hover:text-slate-800"
                                        @click="privacy = true" aria-haspopup="dialog" aria-controls="privacy-modal">
                                    Aviso de Privacidad
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="mt-4 text-center text-[11px] text-white/90">
                    Universidad de Guadalajara · CGIPV · {{ now()->year }}
                </div>
            </div>
        </div>

        {{-- Modal Aviso --}}
        <div x-cloak x-show="privacy" x-transition.opacity
             x-trap.noscroll="privacy"
             @keydown.escape.window="privacy = false"
             class="fixed inset-0 z-[10000] flex items-center justify-center p-4 sm:p-6">
            <div class="absolute inset-0 bg-black/55" @click="privacy = false" aria-hidden="true"></div>
            <div class="relative w-full max-w-2xl rounded-2xl border border-slate-200 bg-white shadow-2xl">
                <div class="flex items-start justify-between border-b border-slate-200 px-5 py-4">
                    <h2 class="text-base font-semibold text-slate-800">Aviso de Privacidad</h2>
                    <button type="button" class="rounded-md p-1 text-slate-500 hover:text-slate-700"
                            @click="privacy = false" aria-label="Cerrar">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                            <path d="m13.41 12 4.3-4.29-1.42-1.42L12 10.59 7.71 6.29 6.29 7.71 10.59 12l-4.3 4.29 1.42 1.42L12 13.41l4.29 4.3 1.42-1.42Z"/>
                        </svg>
                    </button>
                </div>
                <div class="max-h-[70vh] overflow-y-auto px-5 py-4 text-sm leading-relaxed text-slate-700 space-y-3">
                    <p>
                    La Universidad de Guadalajara (en adelante UdeG), con domicilio en Avenida Juárez 976, colonia Centro, código postal 44100, en Guadalajara, Jalisco, 
                    hace de su conocimiento que se considerará como información confidencial aquella que se encuentre contemplada en los artículos 3, fracciones IX y X de la LPDPPSOEJM; 21 de la LTAIPEJM; 
                    Lineamientos Cuadragésimo Octavo y Cuadragésimo Noveno de los Lineamientos de Clasificación; Lineamientos Décimo Sexto, Décimo Séptimo y Quincuagésimo Octavo de los Lineamientos de Protección, 
                    así como aquellos datos de una persona física identificada o identificable y la inherente a las personas jurídicas, los cuales podrán ser sometidos a tratamiento y serán única y exclusivamente utilizados para los fines que fueron proporcionados, 
                    de acuerdo con las finalidades y atribuciones establecidas en los artículos 1, 5 y 6 de la Ley Orgánica, así como 2 y 3 del Estatuto General, ambas legislaciones de la UdeG, de igual forma, para la prestación de los servicios que la misma ofrece conforme a las facultades y prerrogativas de la entidad universitaria correspondiente y estarán a resguardo y protección de la misma.
                    </p>

                    <p>
                       Usted puede consultar nuestro Aviso de Privacidad integral en la siguiente página web: http://www.transparencia.udg.mx/aviso-confidencialidad-integral
                    </p>

                </div>
                <div class="flex items-center justify-end gap-2 border-t border-slate-200 px-5 py-3">
                    <button type="button"
                            class="rounded-lg bg-indigo-600 px-3 py-1.5 text-sm font-semibold text-white hover:bg-indigo-700"
                            @click="privacy = false">
                        Entendido
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Si vienes de Jetstream/Fortify, no necesitas nada más para Alpine.
        document.addEventListener('alpine:init', () => {
            // espacio para inicializaciones futuras si lo requieres
        });
    </script>
</x-guest-layout>
