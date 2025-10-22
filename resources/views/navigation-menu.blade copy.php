{{-- resources/views/navigation-menu.blade.php --}}
<nav class="relative" 
     x-data="{ open: true }"
     x-init="$nextTick(()=>document.documentElement.style.setProperty('--sbw', open ? '18rem' : '5rem'))"
     x-effect="document.documentElement.style.setProperty('--sbw', open ? '18rem' : '5rem')">

    @php
        $u         = auth()->user();
        $datos     = optional(optional($u)->datosGenerales);
        $codigo    = $datos->codigo ?? null;
        $nivel     = optional($datos->nivelEstudio)->nivel_estudios ?? ($datos->nivel_estudios ?? null);

        $userName  = $u->name  ?? 'Usuario';
        $userEmail = $u->email ?? '';
        $userLabel = collect([$codigo, $nivel, $userName])->filter(fn($v) => !blank($v))->implode(' | ');
        $role      = (int) ($u->role ?? 0);

        $initials  = collect(explode(' ', trim($userName)))
                        ->filter()
                        ->map(fn($p)=> mb_substr($p, 0, 1))
                        ->take(2)->implode('');


    $hasAdminSolicitudes = \Illuminate\Support\Facades\Route::has('admin.solicitudes.index');
    $hasAdminInformes    = \Illuminate\Support\Facades\Route::has('admin.informes.index');
    $hasAdminStats       = \Illuminate\Support\Facades\Route::has('admin.estadistica.index');

    @endphp

    {{-- ============================ --}}
    {{-- HEADER SUPERIOR (Fijo)      --}}
    {{-- ============================ --}}
    <div class="fixed top-0 right-0 z-40 h-20 bg-white/70 backdrop-blur border-b border-gray-200"
         :style="`left: var(--sbw);`">
        <div class="h-full px-4 sm:px-6 flex items-center justify-end gap-3">


            <div class="flex items-center gap-3 rounded-xl border border-gray-200 bg-white/80 px-3 py-2 shadow-sm">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <img class="size-9 rounded-full object-cover" src="{{ $u->profile_photo_url }}" alt="{{ $userLabel }}">
                @else
                    <div class="grid size-9 place-items-center rounded-full bg-blue-100 text-blue-700 font-semibold">
                        {{ $initials }}
                    </div>
                @endif

                <div class="min-w-0">
                    <p class="truncate text-sm font-semibold text-gray-800 leading-5">{{ $userLabel }}</p>
                    <p class="truncate text-xs text-gray-500">{{ $userEmail }}</p>
                </div>

                <div class="flex items-center gap-2 pl-1">
                    <a href="{{ route('profile.show') }}"
                        class="inline-flex items-center rounded-md border border-purple-200 bg-purple-50 px-2 py-1 text-xs font-medium text-purple-700 hover:bg-purple-100 hover:border-purple-300 focus-visible:ring-2 focus-visible:ring-purple-500">
                        Perfil
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="inline-flex items-center rounded-md border border-red-200 bg-red-50 px-2 py-1 text-xs font-medium text-red-700 hover:bg-red-100 hover:border-red-300 focus-visible:ring-2 focus-visible:ring-red-500">
                            Salir
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- ============================ --}}
    {{-- SIDEBAR FIJO IZQUIERDO      --}}
    {{-- ============================ --}}
    <aside class="fixed inset-y-0 left-0 z-40 bg-white border-r border-gray-200 flex flex-col transition-[width] duration-200"
           :style="`width: var(--sbw);`">

        {{-- Header / Logo centrado + Botón hamburguesa a la derecha --}}
        <div class="relative flex items-center justify-center h-20 border-b border-gray-100 px-3">
            <a href="https://vicerrectoriaacademica.udg.mx/" target="_blank"
               class="inline-flex transition-transform duration-200 hover:scale-110">
                <img src="{{ asset('storage/images/logo_cgipv02.png') }}" alt="CGIPV"
                     class="mx-auto w-auto" :class="open ? 'h-14' : 'h-10'">
                <span class="sr-only">Ir al sitio Vicerrectoría Académica</span>
            </a>

            <button type="button"
                    @click="open = !open"
                    class="absolute right-3 inline-flex h-9 w-9 items-center justify-center rounded-lg 
                           border border-green-200 bg-green-50 text-green-700 shadow-sm
                           hover:bg-green-100 hover:border-green-300 hover:text-green-800 
                           focus-visible:ring-2 focus-visible:ring-green-500"
                    :title="open ? 'Colapsar menú' : 'Expandir menú'">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                          d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>

        {{-- NAV --}}
        <nav class="px-2 py-4 text-sm flex-1 overflow-y-auto">
            {{-- Sección: General --}}
            <div class="mb-6">
                <p class="px-2 mb-2 text-[11px] font-semibold uppercase tracking-wide text-gray-800" x-show="open">General</p>
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('dashboard') }}"
                           :title="open ? '' : 'Dashboard'"
                           class="group flex items-center gap-3 rounded-lg px-2 py-2
                                  {{ request()->routeIs('dashboard') || request()->routeIs('dashboard.*')
                                        ? 'bg-blue-50 text-blue-700 ring-1 ring-blue-200'
                                        : 'text-gray-700 hover:bg-gray-50' }}">
                            <svg class="h-5 w-5 {{ request()->routeIs('dashboard') || request()->routeIs('dashboard.*') 
                                                    ? 'text-blue-600' 
                                                    : 'text-slate-400 group-hover:text-blue-600' }}" 
                                 viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 12l9-9 9 9M4.5 10.5V21h15V10.5"/>
                            </svg>
                            <span class="truncate" x-show="open">Inicio</span>
                        </a>
                    </li>
                </ul>
            </div>

            @auth
                @if ($role === 1)
                    {{-- Sección: Usuario --}}
                    <div class="mb-6">
                        <p class="px-2 mb-2 text-[11px] font-semibold uppercase tracking-wide text-gray-800" x-show="open">Módulos</p>
                        <ul class="space-y-1">
                            {{-- Datos Generales --}}
                            <li>
                                <a href="{{ route('usuario.datos-generales.create') }}"
                                   :title="open ? '' : 'Datos Generales'"
                                   class="group flex items-center gap-3 rounded-lg px-2 py-2
                                          {{ request()->routeIs('usuario.datos-generales.*') 
                                                ? 'bg-blue-50 text-blue-700 ring-1 ring-blue-200' 
                                                : 'text-gray-700 hover:bg-gray-50' }}">
                                    <svg class="h-5 w-5 {{ request()->routeIs('usuario.datos-generales.*') 
                                                            ? 'text-blue-600' 
                                                            : 'text-slate-400 group-hover:text-blue-600' }}" 
                                         viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 12a5 5 0 1 0 0-10 5 5 0 0 0 0 10Z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 21a8 8 0 0 1 16 0"/>
                                    </svg>
                                    <span class="truncate" x-show="open">Datos Generales</span>
                                </a>
                            </li>

                            {{-- Solicitud --}}
                            <li>
                                <a href="{{ route('usuario.solicitud.create') }}"
                                   :title="open ? '' : 'Solicitud'"
                                   class="group flex items-center gap-3 rounded-lg px-2 py-2
                                          {{ request()->routeIs('usuario.solicitud.*') 
                                                ? 'bg-blue-50 text-blue-700 ring-1 ring-blue-200' 
                                                : 'text-gray-700 hover:bg-gray-50' }}">
                                    <svg class="h-5 w-5 {{ request()->routeIs('usuario.solicitud.*') 
                                                            ? 'text-blue-600' 
                                                            : 'text-slate-400 group-hover:text-blue-600' }}" 
                                         viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6 4h7l5 5v11a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13 4v5h5"/>
                                    </svg>
                                    <span class="truncate" x-show="open">Solicitud</span>
                                </a>
                            </li>

                            {{-- Rubros Solcitados--}}
                            <li>
                                <a href="{{ route('usuario.rubros-solicitados.create') }}"
                                :title="open ? '' : 'Rubros Solicitados'"
                                class="group flex items-center gap-3 rounded-lg px-2 py-2
                                        {{ request()->routeIs('usuario.rubros-solicitados.*') 
                                                ? 'bg-blue-50 text-blue-700 ring-1 ring-blue-200' 
                                                : 'text-gray-700 hover:bg-gray-50' }}">
                                    <svg class="h-5 w-5 {{ request()->routeIs('usuario.rubros-solicitados.*') 
                                                            ? 'text-blue-600' 
                                                            : 'text-slate-400 group-hover:text-blue-600' }}" 
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M8 6h8M8 10h8M8 14h5M5 4h14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2z"/>
                                    </svg>
                                    <span class="truncate" x-show="open">Rubros Solicitados</span>
                                </a>
                            </li>

                            {{-- Documentación --}}
                            <li>
                                <a href="{{ route('usuario.documentaciones.create') }}"
                                   :title="open ? '' : 'Documentación'"
                                   class="group flex items-center gap-3 rounded-lg px-2 py-2
                                          {{ request()->routeIs('usuario.documentaciones.*') 
                                                ? 'bg-blue-50 text-blue-700 ring-1 ring-blue-200' 
                                                : 'text-gray-700 hover:bg-gray-50' }}">
                                    <svg class="h-5 w-5 {{ request()->routeIs('usuario.documentaciones.*') 
                                                            ? 'text-blue-600' 
                                                            : 'text-slate-400 group-hover:text-blue-600' }}" 
                                         viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 6h8M8 10h8M8 14h5M5 4h14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2z"/>
                                    </svg>
                                    <span class="truncate" x-show="open">Documentación</span>
                                </a>
                            </li>

                            {{-- Informes --}}
                            <li>
                                <a href="{{ route('usuario.informes.index') }}"
                                   :title="open ? '' : 'Informes'"
                                   class="group flex items-center gap-3 rounded-lg px-2 py-2
                                          {{ request()->routeIs('usuario.informes.*') 
                                                ? 'bg-blue-50 text-blue-700 ring-1 ring-blue-200' 
                                                : 'text-gray-700 hover:bg-gray-50' }}">
                                    <svg class="h-5 w-5 {{ request()->routeIs('usuario.informes.*') 
                                                            ? 'text-blue-600' 
                                                            : 'text-slate-400 group-hover:text-blue-600' }}" 
                                         viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 3v18h18M7 13l3 3 7-7"/>
                                    </svg>
                                    <span class="truncate" x-show="open">Informes</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                @endif

                @if ($role === 3)
                    {{-- Sección: Catálogos (Admin) --}}
                    <div class="mb-6">
                        <p class="px-2 mb-2 text-[11px] font-semibold uppercase tracking-wide text-gray-800" x-show="open">Catálogos</p>
                        <ul class="space-y-1">
                            <li>
                                <a href="{{ route('admin.centros.index') }}"
                                   :title="open ? '' : 'Centros Universitarios'"
                                   class="group flex items-center gap-3 rounded-lg px-2 py-2
                                          {{ request()->routeIs('admin.centros.*') 
                                                ? 'bg-blue-50 text-blue-700 ring-1 ring-blue-200' 
                                                : 'text-gray-700 hover:bg-gray-50' }}">
                                    <svg class="h-5 w-5 {{ request()->routeIs('admin.centros.*') 
                                                            ? 'text-blue-600' 
                                                            : 'text-slate-400 group-hover:text-blue-600' }}" 
                                         viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 21h16V8l-8-5-8 5v13Z"/>
                                    </svg>
                                    <span class="truncate" x-show="open">Centros Universitarios</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('admin.posgrados.index') }}"
                                   :title="open ? '' : 'Programas de Posgrado'"
                                   class="group flex items-center gap-3 rounded-lg px-2 py-2
                                          {{ request()->routeIs('admin.posgrados.*') 
                                                ? 'bg-blue-50 text-blue-700 ring-1 ring-blue-200' 
                                                : 'text-gray-700 hover:bg-gray-50' }}">
                                    <svg class="h-5 w-5 {{ request()->routeIs('admin.posgrados.*') 
                                                            ? 'text-blue-600' 
                                                            : 'text-slate-400 group-hover:text-blue-600' }}" 
                                         viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 7h18M6 7v13m12-13v13M3 20h18"/>
                                    </svg>
                                    <span class="truncate" x-show="open">Programas de Posgrado</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('admin.rubros-categorias.index') }}"
                                   :title="open ? '' : 'Rubros'"
                                   class="group flex items-center gap-3 rounded-lg px-2 py-2
                                          {{ request()->routeIs('admin.rubros-categorias.*') 
                                                ? 'bg-blue-50 text-blue-700 ring-1 ring-blue-200' 
                                                : 'text-gray-700 hover:bg-gray-50' }}">
                                    <svg class="h-5 w-5 {{ request()->routeIs('admin.rubros-categorias.*') 
                                                            ? 'text-blue-600' 
                                                            : 'text-slate-400 group-hover:text-blue-600' }}" 
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                                        <rect x="3"  y="3"  width="8" height="8" rx="1.5" stroke-width="1.8"/>
                                        <rect x="13" y="3"  width="8" height="8" rx="1.5" stroke-width="1.8"/>
                                        <rect x="3"  y="13" width="8" height="8" rx="1.5" stroke-width="1.8"/>
                                        <rect x="13" y="13" width="8" height="8" rx="1.5" stroke-width="1.8"/>
                                    </svg>
                                    <span class="truncate" x-show="open">Categorias Rubros</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('admin.rubros.index') }}"
                                   :title="open ? '' : 'Rubros'"
                                   class="group flex items-center gap-3 rounded-lg px-2 py-2
                                          {{ request()->routeIs('admin.rubros.*') 
                                                ? 'bg-blue-50 text-blue-700 ring-1 ring-blue-200' 
                                                : 'text-gray-700 hover:bg-gray-50' }}">
                                    <svg class="h-5 w-5 {{ request()->routeIs('admin.rubros.*') 
                                                            ? 'text-blue-600' 
                                                            : 'text-slate-400 group-hover:text-blue-600' }}" 
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                                        <circle cx="4" cy="6" r="1.5" stroke-width="1.8" />
                                        <line x1="8" y1="6" x2="21" y2="6" stroke-width="1.8" stroke-linecap="round"/>
                                        <circle cx="4" cy="12" r="1.5" stroke-width="1.8" />
                                        <line x1="8" y1="12" x2="21" y2="12" stroke-width="1.8" stroke-linecap="round"/>
                                        <circle cx="4" cy="18" r="1.5" stroke-width="1.8" />
                                        <line x1="8" y1="18" x2="21" y2="18" stroke-width="1.8" stroke-linecap="round"/>
                                    </svg>
                                    <span class="truncate" x-show="open">Rubros</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('admin.coordinadores.index') }}"
                                   :title="open ? '' : 'Coordinadores de Posgrado'"
                                   class="group flex items-center gap-3 rounded-lg px-2 py-2
                                          {{ request()->routeIs('admin.coordinadores.*') 
                                                ? 'bg-blue-50 text-blue-700 ring-1 ring-blue-200' 
                                                : 'text-gray-700 hover:bg-gray-50' }}">
                                    <svg class="h-5 w-5 {{ request()->routeIs('admin.coordinadores.*') 
                                                            ? 'text-blue-600' 
                                                            : 'text-slate-400 group-hover:text-blue-600' }}" 
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                                        <!-- Birrete -->
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M12 3l9 5-9 5-9-5 9-5zM5 10v2l7 3 7-3v-2" />
                                        <!-- Cabeza -->
                                        <circle cx="12" cy="14" r="3" stroke-width="1.8" />
                                        <!-- Hombros -->
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M6 21v-1a6 6 0 0 1 12 0v1" />
                                    </svg>
                                    <span class="truncate" x-show="open">Coordinadores de Posgrado</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.usuarios.index') }}"
                                   :title="open ? '' : 'Usuarios'"
                                   class="group flex items-center gap-3 rounded-lg px-2 py-2
                                          {{ request()->routeIs('admin.usuarios.*') 
                                                ? 'bg-blue-50 text-blue-700 ring-1 ring-blue-200' 
                                                : 'text-gray-700 hover:bg-gray-50' }}">
                                    <svg class="h-5 w-5 {{ request()->routeIs('admin.usuarios.*') 
                                                            ? 'text-blue-600' 
                                                            : 'text-slate-400 group-hover:text-blue-600' }}" 
                                         viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 12a5 5 0 1 0 0-10 5 5 0 0 0 0 10Z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 21a8 8 0 0 1 16 0"/>
                                    </svg>
                                    <span class="truncate" x-show="open">Usuarios</span>
                                </a>
                            </li>
                        </ul>
                    </div>

                    {{-- Sección: Convocatorias --}}
                    <li>
                        <a href="{{ route('admin.convocatorias.index') }}"
                            :title="open ? '' : 'Convocatorias'"
                            class="group flex items-center gap-3 rounded-lg px-2 py-2
                                {{ request()->routeIs('admin.convocatorias.*') 
                                    ? 'bg-blue-50 text-blue-700 ring-1 ring-blue-200' 
                                    : 'text-gray-700 hover:bg-gray-50' }}">

                            {{-- Ícono tipo calendario con estilo institucional --}}
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 {{ request()->routeIs('admin.convocatorias.*') 
                                    ? 'text-blue-600' 
                                    : 'text-slate-400 group-hover:text-blue-600' }}"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" 
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2z"/>
                            </svg>

                            <span class="truncate" x-show="open">Convocatorias</span>
                        </a>
                    </li>

                    {{-- Sección: Administración (Admin) --}}
                    <div class="mb-6">
                        <p class="px-2 mb-2 text-[11px] font-semibold uppercase tracking-wide text-gray-800" x-show="open">
                            Administración
                        </p>
                        <ul class="space-y-1">

                        {{-- Solicitudes --}}
                        <li>
                            <a href="{{ $hasAdminSolicitudes ? route('admin.solicitudes.index') : 'javascript:void(0)' }}"
                            :title="open ? '' : 'Solicitudes'"
                            class="group flex items-center gap-3 rounded-lg px-2 py-2
                                    {{ request()->routeIs('admin.solicitudes.*') 
                                            ? 'bg-blue-50 text-blue-700 ring-1 ring-blue-200' 
                                            : 'text-gray-700 hover:bg-gray-50' }}"
                            @if(!$hasAdminSolicitudes) title="Próximamente" aria-disabled="true" @endif>
                                <svg class="h-5 w-5 {{ request()->routeIs('admin.solicitudes.*') 
                                                        ? 'text-blue-600' 
                                                        : 'text-slate-400 group-hover:text-blue-600' }}"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M4 4h12a2 2 0 0 1 2 2v12l-4-3H6a2 2 0 0 1-2-2V4Z"/>
                                </svg>
                                <span class="truncate" x-show="open">Solicitudes</span>
                                @unless($hasAdminSolicitudes)
                                    <span class="ml-auto text-[10px] rounded bg-slate-100 px-1.5 py-0.5 text-slate-500">Soon</span>
                                @endunless
                            </a>
                        </li>

                        {{-- Informes --}}
                        <li>
                            <a href="{{ $hasAdminInformes ? route('admin.informes.index') : 'javascript:void(0)' }}"
                            :title="open ? '' : 'Informes'"
                            class="group flex items-center gap-3 rounded-lg px-2 py-2
                                    {{ request()->routeIs('admin.informes.*') 
                                            ? 'bg-blue-50 text-blue-700 ring-1 ring-blue-200' 
                                            : 'text-gray-700 hover:bg-gray-50' }}"
                            @if(!$hasAdminInformes) title="Próximamente" aria-disabled="true" @endif>
                                <svg class="h-5 w-5 {{ request()->routeIs('admin.informes.*') 
                                                        ? 'text-blue-600' 
                                                        : 'text-slate-400 group-hover:text-blue-600' }}"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M4 5h16M8 9h12M8 13h12M8 17h8M4 9h2M4 13h2M4 17h2"/>
                                </svg>
                                <span class="truncate" x-show="open">Informes</span>
                                @unless($hasAdminInformes)
                                    <span class="ml-auto text-[10px] rounded bg-slate-100 px-1.5 py-0.5 text-slate-500">Soon</span>
                                @endunless
                            </a>
                        </li>

                        {{-- Estadística --}}
                        <li>
                            <a href="{{ $hasAdminStats ? route('admin.estadistica.index') : 'javascript:void(0)' }}"
                            :title="open ? '' : 'Estadística'"
                            class="group flex items-center gap-3 rounded-lg px-2 py-2
                                    {{ request()->routeIs('admin.estadistica.*') 
                                            ? 'bg-blue-50 text-blue-700 ring-1 ring-blue-200' 
                                            : 'text-gray-700 hover:bg-gray-50' }}"
                            @if(!$hasAdminStats) title="Próximamente" aria-disabled="true" @endif>
                                <svg class="h-5 w-5 {{ request()->routeIs('admin.estadistica.*') 
                                                        ? 'text-blue-600' 
                                                        : 'text-slate-400 group-hover:text-blue-600' }}"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                        d="M4 20V4M20 20H4M7 16v-3m4 3V8m4 8v-5"/>
                                </svg>
                                <span class="truncate" x-show="open">Estadística</span>
                                @unless($hasAdminStats)
                                    <span class="ml-auto text-[10px] rounded bg-slate-100 px-1.5 py-0.5 text-slate-500">Soon</span>
                                @endunless
                            </a>
                        </li>
                        </ul>
                    </div>
                @endif
            @endauth
        </nav>

        {{-- Aviso de Privacidad (mejorado, estilo institucional) --}}
        <div class="mt-auto">
            <a href="https://transparencia.udg.mx/aviso-confidencialidad-integral" target="_blank"
               class="flex flex-col items-center justify-center px-4 py-3 text-[12px] text-gray-500 hover:text-blue-600 hover:bg-gray-50 transition">
                <svg class="h-6 w-6 mb-1 text-gray-400 transition group-hover:text-blue-600" 
                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                          d="M12 3l7 4v5c0 5-3.5 9-7 9s-7-4-7-9V7l7-4z" />
                </svg>
                <span class="font-medium text-center">Aviso de Privacidad</span>
            </a>
        </div>

        {{-- FOOTER --}}
        <div class="shrink-0 border-t border-slate-200 bg-white px-3 py-3 text-[11px] leading-relaxed text-slate-700">
            <div class="text-center">
                <p class="mt-2 text-slate-500">
                    CGIPV © {{ now()->year }} Universidad de Guadalajara.
                </p>
            </div>
        </div>
    </aside>
</nav>
