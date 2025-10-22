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
            <div class="w-full max-w-md"
                 x-data="{ show:false }"
                 x-init="setTimeout(() => show = true, 100)">
                {{-- Tarjeta de login (animación de entrada) --}}
                <div x-bind:class="show ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-3'"
                     class="rounded-2xl border border-white/20 bg-white/80 shadow-xl backdrop-blur-md transition-all duration-500 ease-out">

                    {{-- Encabezado con logo y nombre del programa --}}
                    <div class="flex flex-col items-center gap-3 border-b border-slate-200/70 px-6 py-6 text-center">
                        <img src="{{ asset('images/logo-sgipfp.png') }}" alt="Logo SGIPFP"
                             class="h-12 w-12 rounded-full object-contain shadow-sm" />
                        <div>
                            <h1 class="text-lg font-semibold text-slate-800">
                                Sistema de Gestión de Información
                            </h1>
                            <p class="text-sm text-slate-500">
                                Programa de Fortalecimiento del Posgrado (SGIPFP)
                            </p>
                        </div>
                    </div>

                    {{-- Formulario de acceso --}}
                    <div class="px-6 py-6">
                        @if ($errors->any())
                            <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                                {{ __('Verifica tus credenciales e inténtalo de nuevo.') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}" class="space-y-4">
                            @csrf

                            {{-- Correo electrónico --}}
                            <div class="space-y-2">
                                <label for="email" class="text-sm font-medium text-slate-700">Correo electrónico</label>
                                <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                                       class="w-full rounded-lg border-slate-300 bg-white/70 placeholder-slate-400 focus:border-indigo-500 focus:ring-indigo-500"
                                       placeholder="admin@udg.mx">
                            </div>

                            {{-- Contraseña --}}
                            <div class="space-y-2">
                                <label for="password" class="text-sm font-medium text-slate-700">Contraseña</label>
                                <input id="password" name="password" type="password" required
                                       class="w-full rounded-lg border-slate-300 bg-white/70 placeholder-slate-400 focus:border-indigo-500 focus:ring-indigo-500"
                                       placeholder="••••••••">
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

    {{-- JS para cambiar fondo dinámicamente (Jetstream ya trae Alpine, pero esto es JS puro) --}}
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
