{{-- resources/views/auth/login.blade.php --}}
<x-guest-layout>
    <div class="relative min-h-screen w-full overflow-hidden">

        {{-- Fondo dinámico (slideshow) --}}
        <div id="wallpaper"
             class="absolute inset-0 -z-10 bg-cover bg-center bg-no-repeat transition-opacity duration-700"></div>

        {{-- Overlay para legibilidad --}}
        <div class="absolute inset-0 -z-10 bg-gradient-to-b from-black/30 via-black/20 to-black/40 backdrop-blur-[1px]"></div>

        {{-- Contenedor principal --}}
        <div class="mx-auto flex min-h-screen max-w-7xl items-center justify-center px-4">
            <div class="w-full max-w-md" x-data="{ show:false }" x-init="setTimeout(() => show = true, 100)">
                
                {{-- Tarjeta de login (animación de entrada) --}}
                <div x-bind:class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-3'"
                     class="rounded-2xl border border-white/20 bg-white/80 shadow-xl backdrop-blur-md transition-all duration-500 ease-out">

                    {{-- Encabezado con logo y nombre del programa --}}
                    <div class="flex flex-col items-center gap-3 border-b border-slate-200/70 px-6 py-6 text-center">
                        <img src="{{ asset('images/logo-sgipfp.png') }}" alt="Logo SGIPFP"
                             class="h-12 w-12 rounded-full object-contain shadow-sm" />
                        <div>
                            <h1 class="text-lg font-semibold text-slate-800">Sistema de Gestión de Información</h1>
                            <p class="text-sm text-slate-500">Programa de Fortalecimiento del Posgrado (SGIPFP)</p>
                        </div>
                    </div>

                    {{-- Contenido --}}
                    <div class="px-6 py-6 space-y-4">

                        {{-- Alerts (auto-dismiss 5s) --}}
                        @if(session('success') || session('warning') || session('danger') || session('error') || session('status'))
                            @php
                                $msg  = session('success') ?? session('warning') ?? session('danger') ?? session('error') ?? session('status');
                                $type = session('success') ? 'green'
                                       : (session('warning') ? 'yellow'
                                       : (session('status') ? 'blue' : 'red'));
                            @endphp

                            <div x-data="{ show: true }"
                                 x-init="setTimeout(() => show = false, 5000)"
                                 x-show="show"
                                 x-transition.opacity.duration.400ms
                                 role="alert"
                                 class="mb-2 flex items-center gap-2 rounded-lg border px-4 py-3
                                        bg-{{ $type }}-50 text-{{ $type }}-800 border-{{ $type }}-200">
                                {{-- ícono simple --}}
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 shrink-0" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2a10 10 0 1 0 10 10A10.011 10.011 0 0 0 12 2Zm1 15h-2v-2h2Zm0-4h-2V7h2Z"/>
                                </svg>
                                <span class="text-sm">{{ $msg }}</span>
                            </div>
                        @endif

                        {{-- Alert de validación/credenciales inválidas --}}
                        @if ($errors->any())
                            <div x-data="{ show: true }"
                                 x-init="setTimeout(() => show = false, 5000)"
                                 x-show="show"
                                 x-transition.opacity.duration.400ms
                                 class="mb-2 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700"
                                 role="alert">
                                <div class="font-semibold mb-1">No fue posible iniciar sesión</div>
                                <ul class="list-disc pl-5 space-y-0.5">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Formulario de acceso (misma lógica de Jetstream) --}}
                        <form method="POST" action="{{ route('login') }}" class="space-y-4" novalidate>
                            @csrf

                            {{-- Correo electrónico --}}
                            <div class="space-y-2">
                                <label for="email" class="text-sm font-medium text-slate-700">Correo electrónico</label>
                                <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                                       class="w-full rounded-lg border @error('email') border-red-400 @else border-slate-300 @enderror
                                              bg-white/70 placeholder-slate-400 focus:border-indigo-500 focus:ring-indigo-500"
                                       placeholder="admin@udg.mx" autocomplete="username">
                                @error('email')
                                    <p class="text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Contraseña --}}
                            <div class="space-y-2">
                                <label for="password" class="text-sm font-medium text-slate-700">Contraseña</label>
                                <input id="password" name="password" type="password" required
                                       class="w-full rounded-lg border @error('password') border-red-400 @else border-slate-300 @enderror
                                              bg-white/70 placeholder-slate-400 focus:border-indigo-500 focus:ring-indigo-500"
                                       placeholder="••••••••" autocomplete="current-password">
                                @error('password')
                                    <p class="text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Mantener sesión / Olvidó contraseña --}}
                            <div class="flex items-center justify-between">
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
                                    class="mt-2 inline-flex w-full items-center justify-center rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                Iniciar sesión
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Pie de página --}}
                <div class="mt-6 text-center text-xs text-white/80">
                    Universidad de Guadalajara · CGIPV · {{ now()->year }}
                </div>
            </div>
        </div>
    </div>

    {{-- JS para cambiar fondo dinámicamente (no altera la lógica del login) --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const wallpapers = [
                "{{ asset('images/login/udg-1.jpg') }}",
                "{{ asset('images/login/udg-2.jpg') }}",
                "{{ asset('images/login/udg-3.jpg') }}",
                "{{ asset('images/login/udg-4.jpg') }}",
            ];

            const el = document.getElementById('wallpaper');
            let i = Math.floor(Math.random() * wallpapers.length);

            const setImage = (idx) => {
                el.style.opacity = 0;
                setTimeout(() => {
                    el.style.backgroundImage = `url('${wallpapers[idx]}')`;
                    el.style.opacity = 1;
                }, 300);
            };

            setImage(i);
            setInterval(() => {
                i = (i + 1) % wallpapers.length;
                setImage(i);
            }, 10000); // 10s
        });
    </script>
</x-guest-layout>
