<!-- resources/views/administrador/dashboard.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="mt-6 sm:mt-24 text-xl font-semibold text-gray-800 leading-tight">
            Panel del Administrador
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto p-6">
        <p class="text-gray-600">Gestión global del sistema.</p>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
            <a href="{{ route('admin.usuarios.index') }}" class="block rounded-2xl border p-5 hover:shadow">
                <h3 class="font-semibold text-lg">Usuarios y Roles</h3>
                <p class="text-sm text-gray-600">CRUD y permisos.</p>
            </a>

            <!-- Catálogos con link simple a Centros -->
            <div class="block rounded-2xl border p-5 hover:shadow">
                <h3 class="font-semibold text-lg">Catálogos</h3>

                <a href="{{ route('admin.centros.index') }}"
                class="text-blue-600 hover:text-blue-700 inline-flex items-center gap-2 no-underline">
                <span aria-hidden="true">🏛️</span> Centros Universitarios
                </a>
                </br>
                <a href="{{ route('admin.posgrados.index') }}"
                class="text-blue-600 hover:text-blue-700 inline-flex items-center gap-2 no-underline">
                <span aria-hidden="true">🎓</span> Programas de Posgrados
                </a>
                </br>
                <a href="{{ route('admin.coordinadores.index') }}"
                class="text-blue-600 hover:text-blue-700 inline-flex items-center gap-2 no-underline">
                <span aria-hidden="true">👥</span> Coordinadores de Posgrados
                </a>
                </br>
                <a href="{{ route('admin.usuarios.index') }}"
                class="text-blue-600 hover:text-blue-700 inline-flex items-center gap-2 no-underline">
                <span aria-hidden="true">👤</span> Usuarios
                </a>
            </div>

            <a href="#" class="block rounded-2xl border p-5 hover:shadow">
                <h3 class="font-semibold text-lg">Reportes</h3>
                <p class="text-sm text-gray-600">Excel/PDF, métricas.</p>
            </a>
        </div>
    </div>
</x-app-layout>

{{-- Gráfica: Programas de Posgrado por Centro Universitario --}}
<div class="mt-10 bg-white rounded-2xl border p-5">
    <h3 class="font-semibold text-lg mb-4">Programas de Posgrado por Centro Universitario</h3>

    <div class="relative" style="height: 320px;">
        <canvas id="posgradosPorCentroChart"></canvas>
    </div>
</div>

{{-- CDN de Chart.js (solo una vez en la página) --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    (function () {
        const labels = @json($chartLabels ?? []);
        const data    = @json($chartData ?? []);

        const ctx = document.getElementById('posgradosPorCentroChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels,
                datasets: [{
                    label: 'Programas',
                    data,
                    backgroundColor: 'rgba(37, 99, 235, 0.5)',   // azul Tailwind 600 con alpha
                    borderColor: 'rgb(37, 99, 235)',
                    borderWidth: 1,
                    borderRadius: 6,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true, ticks: { precision: 0 } }
                },
                plugins: {
                    legend: { display: false },
                    tooltip: { callbacks: {
                        label: (ctx) => ` ${ctx.parsed.y} programa${ctx.parsed.y === 1 ? '' : 's'}`
                    }}
                }
            }
        });
    })();
</script>
