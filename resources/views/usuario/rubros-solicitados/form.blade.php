{{-- resources/views/usuario/rubros-solicitados/form.blade.php --}}
@php
    /**
     * Espera:
     * - $isEdit (bool)
     * - $rubros: [ { id, rubro, concepto, categoria_id } ]
     * - $categorias: [ { id, categoria, descripcion } ]
     * - $montoAsignado (numeric)
     * - $rubrosMontosPrev: [ idRubro => monto ]
     * - $otrosRubrosPrev:  [ {rubro, descripcion, monto}, ... ]
     * - $registroId (id del registro del usuario autenticado)
     */

    $isEdit = $isEdit ?? false;
    $registroId = $registroId ?? auth()->id();
    $montoAsignado = isset($montoAsignado) ? (float) $montoAsignado : 150000.00;

    $rubrosMontosPrev = $rubrosMontosPrev ?? [];
    $otrosRubrosPrev  = $otrosRubrosPrev ?? [];

    // Totales desde BD para bloqueo de botones
    $totalRubrosBD = $totalRubrosBD ?? (\App\Models\RubroSolicitado::where('user_id', auth()->id())->sum('monto') ?: 0);
    $totalOtrosBD  = $totalOtrosBD  ?? (\App\Models\OtroRubro::where('user_id', auth()->id())->sum('monto') ?: 0);
@endphp

<div class="mx-auto max-w-6xl px-4 py-8">
    {{-- Alerts --}}
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

    {{-- =================== FORMULARIO DE RUBROS =================== --}}
    <form method="POST"
          action="{{ route('usuario.rubros-solicitados.rubros.save', $registroId) }}"
          x-data="rubrosForm({
              rubros: @js($rubros),
              categorias: @js($categorias),
              montoAsignado: {{ number_format($montoAsignado, 2, '.', '') }},
              prevRubros: @js($rubrosMontosPrev),
              totalOtrosBD: {{ (float) $totalOtrosBD }}
          })"
          x-init="init()"
          class="space-y-6 rounded-2xl border bg-white shadow-sm p-5 mb-6"
    >
        @csrf

        {{-- Buscador y Filtro --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Buscar rubro</label>
                <input type="text" x-model="q"
                       class="mt-1 w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-600"
                       placeholder="Escribe rubro, concepto o categoría...">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Filtrar por categoría</label>
                <select x-model.number="cat"
                        class="mt-1 w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-600">
                    <option value="">-- Todas --</option>
                    <template x-for="c in categoriasOpts" :key="c.id">
                        <option :value="c.id" x-text="`${c.categoria} - ${c.descripcion ?? ''}`"></option>
                    </template>
                </select>
            </div>
        </div>

        {{-- Tabla Rubros --}}
        <div class="mt-4 overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="text-gray-600">
                    <tr class="border-b">
                        <th class="px-3 py-2 text-left">Rubro</th>
                        <th class="px-3 py-2 text-left">Concepto</th>
                        <th class="px-3 py-2 text-left">Categoría</th>
                        <th class="px-3 py-2 text-right">Monto</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="r in filtrados()" :key="r.id">
                        <tr class="border-b last:border-0">
                            <td class="px-3 py-2" x-text="r.rubro"></td>
                            <td class="px-3 py-2" x-text="r.concepto"></td>
                            <td class="px-3 py-2" x-text="catLabel(r.categoria_id)"></td>
                            <td class="px-3 py-2 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <input type="hidden" :name="inputNameId(r.id)" :value="r.id">
                                    <input type="number" step="0.01" min="0"
                                           :name="inputNameMonto(r.id)"
                                           x-model.number="montos[r.id]"
                                           x-on:input="calc()"
                                           class="w-36 rounded-lg border-gray-300 text-right focus:ring-2 focus:ring-blue-600"
                                           placeholder="0.00">
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>

        {{-- Resumen y botón de guardar --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="text-sm space-y-1">
                <p class="text-gray-600"><strong>Monto Asignado:</strong>
                    <span class="text-blue-700" x-text="money(montoAsignado)"></span>
                </p>
                <p class="text-gray-600"><strong>Total Rubros:</strong>
                    <span class="font-semibold" x-text="money(totalRubros)"></span>
                </p>
                <p class="text-gray-600"><strong>Otros guardados:</strong>
                    <span class="font-semibold" x-text="money(totalOtrosBD)"></span>
                </p>
                <p class="text-gray-600"><strong>Total combinado:</strong>
                    <span :class="(totalRubros + totalOtrosBD) > montoAsignado ? 'text-red-700' : 'text-emerald-700'"
                          x-text="money(totalRubros + totalOtrosBD)"></span>
                </p>
            </div>

            <div class="pt-2 text-right">
                <button type="submit"
                        :disabled="(totalRubros + totalOtrosBD) > montoAsignado"
                        :class="(totalRubros + totalOtrosBD) > montoAsignado
                            ? 'bg-gray-300 cursor-not-allowed'
                            : 'bg-blue-600 hover:bg-blue-700'"
                        class="inline-flex items-center rounded-xl px-5 py-2.5 font-semibold text-white">
                    Guardar Rubros
                </button>
            </div>
        </div>
    </form>

    {{-- =================== FORMULARIO DE OTROS RUBROS =================== --}}
    <form method="POST"
          action="{{ route('usuario.rubros-solicitados.otros.save', $registroId) }}"
          x-data="otrosForm({
              montoAsignado: {{ number_format($montoAsignado, 2, '.', '') }},
              prevOtros: @js($otrosRubrosPrev),
              totalRubrosBD: {{ (float) $totalRubrosBD }}
          })"
          x-init="init()"
          class="space-y-6 rounded-2xl border bg-white shadow-sm p-5"
    >
        @csrf

        <div class="flex items-center justify-between mb-2">
            <h3 class="text-base font-semibold text-gray-800">Otros Rubros</h3>
            <button type="button" x-on:click="add()"
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
                        <tr><td colspan="5" class="px-3 py-6 text-center text-gray-500">No hay rubros registrados.</td></tr>
                    </template>

                    <template x-for="(o, i) in otros" :key="i">
                        <tr class="border-b last:border-0">
                            <td class="px-3 py-2" x-text="i+1"></td>
                            <td class="px-3 py-2">
                                <input type="text" class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-600"
                                       :name="`otros[${i}][rubro]`" x-model="o.rubro" placeholder="Nombre del rubro">
                            </td>
                            <td class="px-3 py-2">
                                <input type="text" class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-blue-600"
                                       :name="`otros[${i}][descripcion]`" x-model="o.descripcion" placeholder="Descripción">
                            </td>
                            <td class="px-3 py-2">
                                <input type="number" step="0.01" min="0"
                                       class="w-32 rounded-lg border-gray-300 text-right focus:ring-2 focus:ring-blue-600"
                                       :name="`otros[${i}][monto]`"
                                       x-model.number="o.monto"
                                       x-on:input="calc()"
                                       placeholder="0.00">
                            </td>
                            <td class="px-3 py-2 text-center">
                                <button type="button" x-on:click="remove(i)"
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

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="text-sm space-y-1">
                <p class="text-gray-600"><strong>Monto Asignado:</strong>
                    <span class="text-blue-700" x-text="money(montoAsignado)"></span>
                </p>
                <p class="text-gray-600"><strong>Total Otros:</strong>
                    <span class="font-semibold" x-text="money(totalOtros)"></span>
                </p>
                <p class="text-gray-600"><strong>Rubros guardados:</strong>
                    <span class="font-semibold" x-text="money(totalRubrosBD)"></span>
                </p>
                <p class="text-gray-600"><strong>Total combinado:</strong>
                    <span :class="(totalOtros + totalRubrosBD) > montoAsignado ? 'text-red-700' : 'text-emerald-700'"
                          x-text="money(totalOtros + totalRubrosBD)"></span>
                </p>
            </div>

            <div class="pt-2 text-right">
                <button type="submit"
                        :disabled="(totalOtros + totalRubrosBD) > montoAsignado"
                        :class="(totalOtros + totalRubrosBD) > montoAsignado
                            ? 'bg-gray-300 cursor-not-allowed'
                            : 'bg-emerald-600 hover:bg-emerald-700'"
                        class="inline-flex items-center rounded-xl px-5 py-2.5 font-semibold text-white">
                    Guardar Otros Rubros
                </button>
            </div>
        </div>
    </form>
</div>

{{-- =================== Alpine.js =================== --}}
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('rubrosForm', (props) => ({
        rubros: props.rubros || [],
        categorias: props.categorias || [],
        categoriasOpts: [],
        montoAsignado: Number(props.montoAsignado || 0),
        q: '', cat: '',
        montos: {}, totalRubros: 0,
        totalOtrosBD: Number(props.totalOtrosBD || 0),
        catLabelMap: {},

        init(){
            const catById = {};
            for (const c of (this.categorias || [])) catById[String(c.id)] = c;
            const idsPresent = [...new Set((this.rubros || []).map(r => String(r.categoria_id)))];
            this.categoriasOpts = idsPresent.map(id => catById[id]).filter(Boolean)
                .sort((a,b)=> String(a.categoria).localeCompare(String(b.categoria)));
            this.catLabelMap = Object.fromEntries(
                this.categoriasOpts.map(c => [ String(c.id), `${c.categoria}${c.descripcion ? ' - ' + c.descripcion : ''}` ])
            );
            this.montos = Object.assign({}, props.prevRubros || {});
            this.calc();
        },

        catLabel(id){ return this.catLabelMap[String(id)] ?? ''; },

        filtrados(){
            const q = this.q.toLowerCase();
            return (this.rubros || []).filter(r => {
                const byCat = this.cat ? Number(r.categoria_id) === Number(this.cat) : true;
                const labelCat = this.catLabel(r.categoria_id).toLowerCase();
                const text = `${r.rubro} ${r.concepto} ${labelCat}`.toLowerCase();
                const byTxt = !q || text.includes(q);
                return byCat && byTxt;
            });
        },

        inputNameMonto(id){ return `rubros[${id}][monto]`; },
        inputNameId(id){ return `rubros[${id}][id]`; },

        calc(){
            this.totalRubros = Object.values(this.montos).map(v => Number(v || 0)).reduce((a,b)=>a+b,0);
        },

        money(v){ return new Intl.NumberFormat('es-MX',{style:'currency',currency:'MXN'}).format(Number(v||0)); },
    }));

    Alpine.data('otrosForm', (props) => ({
        montoAsignado: Number(props.montoAsignado || 0),
        otros: [],
        totalOtros: 0,
        totalRubrosBD: Number(props.totalRubrosBD || 0),

        init(){
            this.otros = (props.prevOtros || []).map(o => ({
                rubro: o.rubro ?? '',
                descripcion: o.descripcion ?? '',
                monto: Number(o.monto ?? 0),
            }));
            this.calc();
        },

        add(){ this.otros.push({rubro:'', descripcion:'', monto:0}); this.calc(); },
        remove(i){ this.otros.splice(i,1); this.calc(); },

        calc(){ this.totalOtros = this.otros.map(o => Number(o.monto||0)).reduce((a,b)=>a+b,0); },
        money(v){ return new Intl.NumberFormat('es-MX',{style:'currency',currency:'MXN'}).format(Number(v||0)); },
    }));
});
</script>
