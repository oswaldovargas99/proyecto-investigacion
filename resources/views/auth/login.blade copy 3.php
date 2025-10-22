{{-- resources/views/auth/login.blade.php --}}
<x-guest-layout>
    {{-- TOASTS (si ya creaste el componente): --}}
    {{-- <x-toast /> --}}

    <style>
        /* Evita parpadeos Alpine */
        [x-cloak]{ display:none !important; }

        /* Fondo con Ken Burns (más nítido, sin blur global) */
        #wallpaper{
            background-attachment: fixed;     /* parallax suave */
            will-change: transform, opacity;
            animation: kb 22s ease-in-out infinite alternate;
            image-rendering: -webkit-optimize-contrast;
            image-rendering: crisp-edges;
        }
        @keyframes kb{
            0%   { transform: scale(1.05) translateY(0);    }
            100% { transform: scale(1.14) translateY(-1.5%);}
        }

        /* Botón con gradiente animado */
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

        {{-- Fondo dinámico (nítido) --}}
        <div id="wallpaper" class="absolute inset-0 -z-10 bg-cover bg-center bg-no-repeat transition-opacity duration-700"></div>

        {{-- Overlay sin blur (solo oscurece para legibilidad) --}}
        <div class="absolute inset-0 -z-10 bg-gradient-to-b from-black/35 via-black/25 to-black/40"></div>

        {{-- Contenido principal --}}
        <div class="mx-auto flex min-h-screen max-w-7xl items-center justify-center px-4 py-8">
            <div class="w-full max-w-lg">
                {{-- Card con glassmorphism real --}}
                <div x-bind:class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-3'"
                     class="rounded-3xl border border-white/30 bg-white/75 shadow-2xl ring-1 ring-white/60 backdrop-blur-xl transition-all duration-500 ease-out">

                    {{-- Encabezado centrado --}}
                    <div class="flex flex-col items-center gap-4 border-b border-white/40 px-8 pt-8 pb-6 text-center">
                        <img src="{{ asset('images/login/logo_cgipv01.png') }}" alt="Logo CGIPV"
                             class="h-16 w-16 rounded-full object-contain shadow-sm" />
                        <div class="space-y-1">
                            <h1 class="text-xl sm:text-2xl font-semibold text-slate-800">
                                Programa de Fortalecimiento del Posgrado (PFP)
                            </h1>
                        </div>
                    </div>

                    {{-- Contenido / Alerts / Form --}}
                    <div class="px-8 py-7 space-y-4">

                        {{-- Alert global por sesión (success/warning/error/status/rol) --}}
                        @if(session('success') || session('warning') || session('danger') || session('error') || session('status') || session('rol'))
                            @php
                                $msg  = session('success') ?? session('warning') ?? session('danger') ?? session('error') ?? session('status') ?? session('rol');
                                $type = session('success') ? 'green'
                                       : (session('warning') ? 'yellow'
                                       : (session('status') ? 'blue'
                                       : (session('rol') ? 'green' : 'red')));
                            @endphp
                            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
                                 x-transition.opacity.duration.400ms role="alert"
                                 class="flex items-center gap-2 rounded-xl border px-4 py-3
                                        bg-{{ $type }}-50 text-{{ $type }}-800 border-{{ $type }}-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2a10 10 0 1 0 10 10A10.011 10.011 0 0 0 12 2Zm1 15h-2v-2h2Zm0-4h-2V7h2Z"/>
                                </svg>
                                <span class="text-sm">{{ $msg }}</span>
                            </div>
                        @endif

                        {{-- Alert de validación/credenciales --}}
                        @if ($errors->any())
                            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 6000)" x-show="show"
                                 x-transition.opacity.duration.400ms
                                 class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700" role="alert">
                                <div class="font-semibold mb-1">No fue posible iniciar sesión</div>
                                <ul class="list-disc pl-5 space-y-0.5">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Formulario de acceso (lógica Jetstream intacta) --}}
                        <form method="POST" action="{{ route('login') }}" class="space-y-4" novalidate>
                            @csrf

                            {{-- Email con icono --}}
                            <div class="space-y-1.5">
                                <label for="email" class="text-sm font-medium text-slate-700">Correo electrónico</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-3 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M20 4H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2Zm0 4-8 5L4 8V6l8 5 8-5Z"/>
                                        </svg>
                                    </span>
                                    <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                                           class="w-full rounded-xl pl-9 pr-3 py-2.5 border @error('email') border-red-400 @else border-slate-300 @enderror
                                                  bg-white/80 placeholder-slate-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/40"
                                           placeholder="admin@udg.mx" autocomplete="username">
                                </div>
                                @error('email') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>

                            {{-- Password con icono --}}
                            <div class="space-y-1.5">
                                <label for="password" class="text-sm font-medium text-slate-700">Contraseña</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-3 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M12 1a5 5 0 0 0-5 5v3H5a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1V10a1 1 0 0 0-1-1h-2V6a5 5 0 0 0-5-5Zm-3 8V6a3 3 0 1 1 6 0v3Z"/>
                                        </svg>
                                    </span>
                                    <input id="password" name="password" type="password" required
                                           class="w-full rounded-xl pl-9 pr-3 py-2.5 border @error('password') border-red-400 @else border-slate-300 @enderror
                                                  bg-white/80 placeholder-slate-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/40"
                                           placeholder="••••••••" autocomplete="current-password">
                                </div>
                                @error('password') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                            </div>

                            {{-- Mantener sesión / Olvidó Contraseña --}}
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

                            {{-- Botón --}}
                            <button type="submit"
                                    class="btn-gradient mt-1 inline-flex w-full items-center justify-center rounded-xl px-4 py-3 text-sm font-semibold text-white shadow-lg focus:outline-none focus:ring-2 focus:ring-indigo-500/40 focus:ring-offset-2">
                                Iniciar sesión
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Pie: marca + Aviso de Privacidad (Modal) --}}
                <div class="mt-6 text-center text-[11px] text-white/90 space-y-1">
                    <div>Universidad de Guadalajara · CGIPV · {{ now()->year }}</div>
                    <button type="button"
                            class="underline decoration-white/50 underline-offset-4 hover:decoration-white"
                            @click="privacy = true" aria-haspopup="dialog" aria-controls="privacy-modal">
                        Aviso de Privacidad
                    </button>
                </div>
            </div>
        </div>

        {{-- ===== Modal Aviso de Privacidad ===== --}}
        <div  x-cloak
              x-show="privacy"
              x-transition.opacity
              x-trap.noscroll="privacy"
              @keydown.escape.window="privacy = false"
              class="fixed inset-0 z-[10000] flex items-center justify-center p-4 sm:p-6">

            {{-- Backdrop --}}
            <div class="absolute inset-0 bg-black/55" @click="privacy = false" aria-hidden="true"></div>

            {{-- Dialog --}}
            <div id="privacy-modal" role="dialog" aria-modal="true" aria-labelledby="privacy-title"
                 class="relative w-full max-w-2xl rounded-2xl border border-slate-200 bg-white shadow-2xl">
                <div class="flex items-start justify-between border-b border-slate-200 px-5 py-4">
                    <h2 id="privacy-title" class="text-base font-semibold text-slate-800">Aviso de Privacidad</h2>
                    <button type="button" class="rounded-md p-1 text-slate-500 hover:text-slate-700"
                            @click="privacy = false" aria-label="Cerrar">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                            <path d="m13.41 12 4.3-4.29-1.42-1.42L12 10.59 7.71 6.29 6.29 7.71 10.59 12l-4.3 4.29 1.42 1.42L12 13.41l4.29 4.3 1.42-1.42Z"/>
                        </svg>
                    </button>
                </div>

                <div class="max-h-[70vh] overflow-y-auto px-5 py-4 text-sm leading-relaxed text-slate-700 space-y-3">
                    <p>
                        Este sistema trata datos personales conforme al marco normativo aplicable en la Universidad de Guadalajara:
                        Constitución (Arts. 6º y 16º), LGPDPPSO, LGTAIP, lineamientos del INAI y el RIAG. La información recabada se
                        utiliza con fines administrativos vinculados al Programa de Fortalecimiento del Posgrado, aplicando medidas
                        técnicas y organizativas para proteger su confidencialidad, integridad y disponibilidad.
                    </p>
                    <p>
                        Las personas titulares pueden ejercer sus derechos ARCO (Acceso, Rectificación, Cancelación y Oposición)
                        a través de los mecanismos institucionales. Para más información, consulte el aviso integral o contacte a
                        la unidad responsable designada por la UdeG.
                    </p>
                    <p class="text-xs text-slate-500">
                        Nota: Este resumen no sustituye al aviso integral. Puede consultar la versión completa en el portal institucional.
                    </p>
                </div>

                <div class="flex items-center justify-end gap-2 border-t border-slate-200 px-5 py-3">
                    @if (Route::has('privacy.notice'))
                        <a href="{{ route('privacy.notice') }}"
                           class="rounded-lg border border-slate-300 px-3 py-1.5 text-sm text-slate-700 hover:bg-slate-50"
                           target="_blank" rel="noopener">
                            Ver aviso completo
                        </a>
                    @endif
                    <button type="button"
                            class="rounded-lg bg-indigo-600 px-3 py-1.5 text-sm font-semibold text-white hover:bg-indigo-700"
                            @click="privacy = false">
                        Entendido
                    </button>
                </div>
            </div>
        </div>
        {{-- ===== Fin Modal ===== --}}
    </div>

    {{-- JS fondos dinámicos --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const wallpapers = [
                "{{ asset('images/login/cgipv04.jpg') }}",
                "{{ asset('images/login/cgipv05.jpg') }}",
                "{{ asset('images/login/cgipv06.jpg') }}",
            ];
            const el = document.getElementById('wallpaper');
            let i = Math.floor(Math.random() * wallpapers.length);
            const setImage = (idx) => {
                el.style.opacity = 0;
                setTimeout(() => {
                    el.style.backgroundImage = `url('${wallpapers[idx]}')`;
                    el.style.opacity = 1;
                }, 250);
            };
            setImage(i);
            setInterval(() => { i = (i + 1) % wallpapers.length; setImage(i); }, 12000);
        });
    </script>
</x-guest-layout>
