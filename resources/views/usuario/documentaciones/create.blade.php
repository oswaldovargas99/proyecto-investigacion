<!-- resources/views/usuario/documentaciones/create.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="mt-6 sm:mt-24 text-xl font-semibold text-gray-800 leading-tight">
           Adjuntar Documentación (Convocatoria 2025)
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @include('usuario.documentaciones.form', [
                    'documentacion' => $documentacion ?? null
                ])
            </div>
        </div>
    </div>

    <script>
        function toggleInput(field){
            const wrap = document.getElementById('wrap-'+field);
            const preview = document.getElementById('preview-'+field);
            if(wrap && preview){ wrap.classList.toggle('hidden'); preview.classList.toggle('hidden'); }
        }
    </script>
</x-app-layout>
