
<x-app-layout>
    <x-slot name="header">
        <h2 class="mt-6 sm:mt-24 text-xl font-semibold text-gray-800 leading-tight">
            Registrar Solicitud
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto px-4">
            @if ($errors->any())
                <div class="mb-4 rounded-md border border-red-300 bg-red-50 p-4 text-sm text-red-700">
                    <strong class="font-semibold">Se encontraron errores:</strong>
                    <ul class="mt-2 list-disc ps-6">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('success'))
                <div x-data="{ show: true }" x-init="setTimeout(()=>show=false, 5000)" x-show="show"
                     class="mb-4 rounded-md border border-green-300 bg-green-50 p-3 text-green-800 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('usuario.solicitud.store') }}">
                @csrf

                @include('usuario.solicitud.form', [
                    'solicitud' => null,
                    'temas' => $temas,
                    'temasSeleccionados' => old('temas', []),
                    'codigo' => $codigo ?? '',
                    'nombre_coordinador' => $nombre_coordinador ?? '',
                    'submitLabel' => 'Guardar'
                ])
            </form>
        </div>
    </div>
</x-app-layout>
