{{-- resources/views/admin/rubros/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="mt-6 sm:mt-24 text-xl font-semibold text-gray-800 leading-tight">
            Nuevo Rubro
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto px-4">
            {{-- Alertas --}}
            @if ($errors->any())
                <div class="mb-4 rounded-xl border border-red-200 bg-red-50 text-red-800 px-4 py-3">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white shadow-sm rounded-2xl border p-6">
                <form action="{{ route('admin.rubros.store') }}" method="POST" class="space-y-6">
                    @csrf
                    @include('administrador.rubros.form', ['modo' => 'crear'])
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
