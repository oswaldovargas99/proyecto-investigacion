{{-- resources/views/usuario/rubros-solicitados/form.blade.php --}}
@php
    // Detectar modo (create/edit) y definir acción con las rutas correctas
    $isEdit     = $isEdit     ?? false;
    $registroId = $registroId ?? auth()->id();
    $action     = $isEdit
        ? route('usuario.rubros-solicitados.update', $registroId)
        : route('usuario.rubros-solicitados.store');

    // Helpers para old() en edición/creación
    $rubrosMontosPrev = $rubrosMontosPrev ?? [];
    $otrosRubrosPrev  = $otrosRubrosPrev ?? [];

    // Reconstruir otros_rubros desde old()
    $otrosOld = old('otros_rubros', $otrosRubrosPrev);
@endphp

<div class="mx-auto max-w-6xl px-4 py-8">
    {{-- Alertas --}}
    @if ($errors->any())
        <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4 text-red-700">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
            </ul>
        </div>
    @endif
    @if (session('success'))
        <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ $action }}" method="POST"
          x-data="rubrosSolicitadosForm({
              rubros: @js($rubros),
              categorias: @js($categorias),
              montoAsignado: {{ (float) $montoAsignado }},
              prevRubros: @js(old('rubros_solicitados', $rubrosMontosPrev)),
              prevOtros: @js($otrosOld),
          })"
          x-init="init()"
          class="space-y-8"
    >
        @csrf
        @if ($isEdit)
            @method('PUT')
        @endif

        {{-- ===== Bloque: Buscador y filtro ===== --}}
        <div class="rounded-2xl border bg-white shadow-sm p-5">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Buscar rubro</label>
                    <input type="text" x-model="q"
                           class="mt-1 w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-600"
                           placeholder="Escribe una palabra clave...">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Filtrar por categoría</label>
                    <select x-model.number="cat"
                            class="mt-1 w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-600">
                        <option value="">-- Todas --</option>
                        <template x-for="c in categorias" :key="c.id">
                            <option :value="c.id" x-text="c.nombre"></option>
                        </template>
                    </select>
                </div>
            </div>

            <div class="mt-4 overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="text-gray-600">
                        <tr class="border-b">
                            <th class="px-3 py-2 text-left">Clave</th>
                            <th class="px-3 py-2 text-left">Nombre del Rubro</th>
                            <th class="px-3 py-2 text-left">Categoría</th>
                            <th class="px-3 py-2 text-right">Monto</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="r in filtrados()" :key="r.id">
                            <tr class="border-b last:border-0">
                                <td class="px-3 py-2 whitespace-nowrap text-gray-700" x-text="r.clave"></td>
                                <td class="px-3 py-2 text-gray-800" x-text="r.nombre"></td>
                                <td class="px-3 py-2 text-gray-600" x-text="r.categoria_nombre"></td>
                                <td class="px-3 py-2">
                                    <div class="flex items-center justify-end gap-2">
                                        <span class="text-gray-500">$</span>
                                        <input
                                            class="w-36 rounded-lg border-gray-300 text-right focus:ring-2 focus:ring-blue-600"
                                            type="number" step="0.01" min="0"
                                            :name="`rubros_solicitados[${r.id}]`"
                                            x-model.number="montos[r.id]"
                                            x-on:input="calc()"
                                            placeholder="0.00">
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ===== Resumen montos ===== --}}
        <div class="rounded-2xl border bg-white shadow-sm p-5">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="text-sm space-y-1">
                    <p class="text-gray-600">
                        <span class="font-medium">Monto Asignado:</span>
                        <span class="text-blue-700 font-semibold" x-text="money(montoAsignado)">$0.00</span>
                    </p>
                    <p class="text-gray-600">
                        <span class="font-medium">Total capturado:</span>
                        <span class="font-semibold"
                              :class="totalCapturado > montoAsignado ? 'text-red-700' : 'text-emerald-700'"
                              x-text="money(totalCapturado)">$0.00</span>
                    </p>
                </div>

                <div class="text-sm text-red-700" x-show="totalCapturado > montoAsignado">
                    El total capturado excede el monto asignado.
                </div>
            </div>
        </div>

        {{-- ===== Bloque: Otros Rubros ===== --}}
        <div class="rounded-2xl border bg-white shadow-sm">
            <div class="p-5">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-base font-semibold text-gray-800">Lista de Otros Rubros</h3>
                    <button type="button" x-on:click="addOtro()"
                            class="inline-flex items-center rounded-xl bg-blue-600 px-3 py-2 text-sm font-semibold text-white hover:bg-blue-700">
                        + Agregar Rubro
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="text-gray-600">
                            <tr class="border-b">
                                <th class="px-3 py-2 text-left w-12">#</th>
                                <th class="px-3 py-2 text-left">Rubro</th>
                                <th class="px-3 py-2 text-left">Descripción</th>
                                <th class="px-3 py-2 text-right w-40">Monto</th>
                                <th class="px-3 py-2 text-center w-24">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-if="otros.length === 0">
                                <tr>
                                    <td colspan="5" class="px-3 py-6 text-center text-gray-500">
                                        No hay rubros registrados.
                                    </td>
                                </tr>
                            </template>

                            <template x-for="(o, i) in otros" :key="i">
                                <tr class="border-b last:border-0">
                                    <td class="px-3 py-2" x-text="i+1"></td>
                                    <td class="px-3 py-2">
                                        <input type="text" class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-600"
                                               :name="`otros_rubros[${i}][rubro]`" x-model="o.rubro" placeholder="Nombre del rubro">
                                    </td>
                                    <td class="px-3 py-2">
                                        <input type="text" class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-600"
                                               :name="`otros_rubros[${i}][descripcion]`" x-model="o.descripcion" placeholder="Descripción">
                                    </td>
                                    <td class="px-3 py-2">
                                        <div class="flex items-center justify-end gap-2">
                                            <span class="text-gray-500">$</span>
                                            <input type="number" step="0.01" min="0"
                                                   class="w-32 rounded-lg border-gray-300 text-right focus:ring-2 focus:ring-blue-600"
                                                   :name="`otros_rubros[${i}][monto]`"
                                                   x-model.number="o.monto"
                                                   x-on:input="calc()"
                                                   placeholder="0.00">
                                        </div>
                                    </td>
                                    <td class="px-3 py-2 text-center">
                                        <button type="button" x-on:click="removeOtro(i)"
                                                class="inline-flex items-center rounded-lg border px-2 py-1 text-xs font-medium text-gray-600 hover:bg-gray-50">
                                            Eliminar
                                        </button>
                                    </td>
                                </tr>
                            </template>
                        </tbody>

                        <tfoot>
                            <tr>
                                <td colspan="3" class="px-3 py-3 text-right font-medium text-gray-700">Total:</td>
                                <td class="px-3 py-3 text-right font-semibold" x-text="money(totalOtros)">$0.00</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        {{-- ===== Acciones ===== --}}
        <div class="pt-2">
            <button type="submit"
                    :class="isEdit ? 'bg-emerald-600 hover:bg-emerald-700' : 'bg-blue-600 hover:bg-blue-700'"
                    class="inline-flex items-center rounded-xl px-5 py-2.5 font-semibold text-white focus:outline-none focus:ring-2"
                    x-bind="{}"
            >
                <template x-if="!isEdit">Guardar</template>
                <template x-if="isEdit">Actualizar</template>
            </button>
        </div>
    </form>
</div>

{{-- ===== Alpine.js ===== --}}
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('rubrosSolicitadosForm', (props) => ({
        // props: rubros, categorias, montoAsignado, prevRubros, prevOtros
        rubros: props.rubros || [],
        categorias: props.categorias || [],
        montoAsignado: Number(props.montoAsignado || 0),
        q: '',
        cat: '',
        montos: {},       // { idRubro: monto }
        otros: [],        // [{rubro, descripcion, monto}]
        totalRubros: 0,
        totalOtros: 0,
        totalCapturado: 0,
        isEdit: {{ $isEdit ? 'true':'false' }},

        init(){
            // Cargar montos previos (edición/old)
            this.montos = Object.assign({}, props.prevRubros || {});
            // Cargar otros rubros previos
            this.otros = (props.prevOtros || []).map(o => ({
                rubro: o.rubro ?? '', descripcion: o.descripcion ?? '', monto: Number(o.monto ?? 0)
            }));
            this.calc();
        },

        filtrados(){
            const q = this.q.toLowerCase();
            return this.rubros.filter(r => {
                const byCat = this.cat ? Number(r.categoria_id) === Number(this.cat) : true;
                const text = `${r.clave} ${r.nombre} ${r.categoria_nombre}`.toLowerCase();
                const byTxt = !q || text.includes(q);
                return byCat && byTxt;
            });
        },

        addOtro(){
            this.otros.push({ rubro: '', descripcion: '', monto: 0 });
            this.calc();
        },
        removeOtro(i){
            this.otros.splice(i,1);
            this.calc();
        },

        calc(){
            // Suma rubros
            this.totalRubros = Object.values(this.montos)
                .map(v => Number(v || 0)).reduce((a,b)=>a+b,0);
            // Suma otros
            this.totalOtros = this.otros
                .map(o => Number(o.monto || 0)).reduce((a,b)=>a+b,0);
            this.totalCapturado = this.totalRubros + this.totalOtros;
        },

        money(v){
            return new Intl.NumberFormat('es-MX', { style:'currency', currency:'MXN' }).format(Number(v||0));
        },
    }));
});
</script>
