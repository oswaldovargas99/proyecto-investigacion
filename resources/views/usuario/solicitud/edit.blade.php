<x-app-layout>
    <x-slot name="header">
        <h2 class="mt-6 sm:mt-24 text-xl font-semibold text-gray-800 leading-tight">
            Actualizar Solicitud
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
                    class="mb-4 rounded-md border border-yellow-300 bg-yellow-50 p-3 text-yellow-800 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('usuario.solicitud.update', $solicitud->id) }}">
                @csrf
                @method('PUT')

                @include('usuario.solicitud.form', [
                    'solicitud' => $solicitud,
                    'temas' => $temas,
                    'temasSeleccionados' => old('temas', $temasSeleccionados ?? []),
                    'codigo' => $codigo ?? '',
                    'nombre_coordinador' => $nombre_coordinador ?? '',
                    'submitLabel' => 'Actualizar'
                ])
            </form>
        </div>
    </div>
</x-app-layout>
