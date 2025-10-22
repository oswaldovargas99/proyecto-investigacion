<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

// MODELOS
use App\Models\Rubro;                 // pfp_rubros (catálogo)
use App\Models\RubroCategoria;        // pfp_rubros_categorias (catálogo)
use App\Models\RubroSolicitado;       // pfp_rubros_solicitados (snapshot por usuario)
use App\Models\OtroRubro;             // pfp_otros_rubros
use App\Models\DatosGenerales;        // opcional: para monto_asignado

class RubroSolicitadosController extends Controller
{
    /**
     * Mostrar formulario de creación.
     * Si ya existen datos guardados, redirige a edición.
     */
    public function create()
    {
        $userId = Auth::id();

        // Catálogos
        $categorias = RubroCategoria::orderBy('categoria')
            ->get(['id', 'categoria', 'descripcion']);

        $rubros = Rubro::select('id', 'rubro', 'concepto', 'categoria_id')
            ->orderBy('rubro')
            ->get();

        // Monto asignado (por defecto 150,000)
        $datos = DatosGenerales::where('user_id', $userId)->first();
        $montoAsignado = optional($datos)->monto_asignado ?? 150000.00;

        // Montos previos (Rubros solicitados)
        $prev = RubroSolicitado::where('user_id', $userId)->get(['rubro', 'monto']);
        $codes = $prev->pluck('rubro')->unique()->filter()->values();
        $codeToId = Rubro::whereIn('rubro', $codes)->pluck('id', 'rubro');

        $rubrosMontosPrev = [];
        foreach ($prev as $row) {
            $rid = $codeToId[$row->rubro] ?? null;
            if ($rid) {
                $rubrosMontosPrev[$rid] = (float) $row->monto;
            }
        }

        // Otros rubros previos
        $otrosRubrosPrev = OtroRubro::where('user_id', $userId)
            ->select('rubro', 'concepto', 'monto')
            ->get()
            ->toArray();

        // Totales (para validar límites en front)
        $totalRubrosBD = (float) RubroSolicitado::where('user_id', $userId)->sum('monto');
        $totalOtrosBD  = (float) OtroRubro::where('user_id', $userId)->sum('monto');

        return view('usuario.rubros-solicitados.edit', [
            'isEdit'           => true,
            'registroId'       => $userId,
            'categorias'       => $categorias,
            'rubros'           => $rubros,
            'montoAsignado'    => $montoAsignado,
            'rubrosMontosPrev' => $rubrosMontosPrev,
            'otrosRubrosPrev'  => $otrosRubrosPrev,
            'totalRubrosBD'    => $totalRubrosBD,
            'totalOtrosBD'     => $totalOtrosBD,
        ]);
    }

    /**
     * Guardado integral (modo compatibilidad).
     * Se puede seguir usando, aunque ya existen métodos por sección.
     */
    public function store(Request $request)
    {
        $userId = Auth::id();

        $validated = $request->validate([
            'rubros'                   => ['nullable', 'array'],
            'rubros.*.id'              => ['required_with:rubros.*.monto', 'integer', 'exists:pfp_rubros,id'],
            'rubros.*.monto'           => ['nullable', 'numeric', 'min:0'],
            'otros'                    => ['nullable', 'array'],
            'otros.*.rubro'            => ['required_with:otros.*.monto', 'string', 'max:100'],
            'otros.*.concepto'         => ['required_with:otros.*.monto', 'string', 'max:255'],
            'otros.*.monto'            => ['nullable', 'numeric', 'min:0'],
            'monto_asignado'           => ['nullable', 'numeric', 'min:0'],
        ]);

        $rubrosInput = collect($validated['rubros'] ?? [])
            ->filter(fn ($r) => $r['monto'] !== null && $r['monto'] !== '')
            ->map(fn ($r) => ['id' => (int) $r['id'], 'monto' => (float) $r['monto']])
            ->values();

        $otrosInput = collect($validated['otros'] ?? [])
            ->filter(fn ($o) => $o['monto'] !== null && $o['monto'] !== '')
            ->map(fn ($o) => [
                'rubro'    => trim($o['rubro']),
                'concepto' => $o['concepto'] ?? '',
                'monto'    => (float) $o['monto'],
            ])
            ->values();

        $sumaTotal = $rubrosInput->sum('monto') + $otrosInput->sum('monto');
        $cap = (float) ($validated['monto_asignado'] ??
            (DatosGenerales::where('user_id', $userId)->value('monto_asignado') ?? 150000.00));

        if ($sumaTotal > $cap) {
            return back()->withInput()->withErrors(['monto_asignado' => 'La suma total excede el monto asignado.']);
        }

        $catalog = Rubro::whereIn('id', $rubrosInput->pluck('id'))
            ->get(['id', 'rubro', 'concepto'])
            ->keyBy('id');

        DB::transaction(function () use ($userId, $rubrosInput, $otrosInput, $catalog) {
            RubroSolicitado::where('user_id', $userId)->delete();
            OtroRubro::where('user_id', $userId)->delete();

            foreach ($rubrosInput as $r) {
                if ($cat = $catalog->get($r['id'])) {
                    RubroSolicitado::create([
                        'user_id'  => $userId,
                        'rubro'    => $cat->rubro,
                        'concepto' => $cat->concepto,
                        'monto'    => $r['monto'],
                    ]);
                }
            }

            foreach ($otrosInput as $o) {
                OtroRubro::create([
                    'user_id'  => $userId,
                    'rubro'    => $o['rubro'],
                    'concepto' => $o['concepto'],
                    'monto'    => $o['monto'],
                ]);
            }
        });

        return redirect()->route('usuario.rubros-solicitados.edit', ['rubros_solicitado' => $userId])
            ->with('success', 'Rubros guardados correctamente.');
    }

    /** Mostrar formulario de edición */
    public function edit($rubros_solicitado)
    {
        $userId = Auth::id();

        $categorias = RubroCategoria::orderBy('categoria')
            ->get(['id', 'categoria', 'descripcion']);

        $rubros = Rubro::select('id', 'rubro', 'concepto', 'categoria_id')
            ->orderBy('rubro')
            ->get();

        $datos = DatosGenerales::where('user_id', $userId)->first();
        $montoAsignado = optional($datos)->monto_asignado ?? 150000.00;

        // Rubros guardados
        $prev = RubroSolicitado::where('user_id', $userId)->get(['rubro', 'monto']);
        $codes = $prev->pluck('rubro')->unique()->filter()->values();
        $codeToId = Rubro::whereIn('rubro', $codes)->pluck('id', 'rubro');

        $rubrosMontosPrev = [];
        foreach ($prev as $row) {
            $rid = $codeToId[$row->rubro] ?? null;
            if ($rid) {
                $rubrosMontosPrev[$rid] = (float) $row->monto;
            }
        }

        $otrosRubrosPrev = OtroRubro::where('user_id', $userId)
            ->select('rubro', 'concepto', 'monto')
            ->get()
            ->toArray();

        $totalRubrosBD = (float) RubroSolicitado::where('user_id', $userId)->sum('monto');
        $totalOtrosBD  = (float) OtroRubro::where('user_id', $userId)->sum('monto');

        return view('usuario.rubros-solicitados.edit', [
            'isEdit'           => true,
            'registroId'       => $rubros_solicitado ?: $userId,
            'categorias'       => $categorias,
            'rubros'           => $rubros,
            'montoAsignado'    => $montoAsignado,
            'rubrosMontosPrev' => $rubrosMontosPrev,
            'otrosRubrosPrev'  => $otrosRubrosPrev,
            'totalRubrosBD'    => $totalRubrosBD,
            'totalOtrosBD'     => $totalOtrosBD,
        ]);
    }

    /** Actualización integral (modo compatibilidad) */
    public function update(Request $request, $rubros_solicitado)
    {
        return $this->store($request);
    }

    /** Guardar SOLO la sección "Rubros" */
    public function saveRubros(Request $request, $rubros_solicitado)
    {
        $userId = Auth::id();

        $validated = $request->validate([
            'rubros'         => ['nullable', 'array'],
            'rubros.*.id'    => ['required_with:rubros.*.monto', 'integer', 'exists:pfp_rubros,id'],
            'rubros.*.monto' => ['nullable', 'numeric', 'min:0'],
        ]);

        $cap = (float) (DatosGenerales::where('user_id', $userId)->value('monto_asignado') ?? 150000.00);

        $rubrosInput = collect($validated['rubros'] ?? [])
            ->filter(fn ($r) => $r['monto'] !== null && $r['monto'] !== '')
            ->map(fn ($r) => ['id' => (int) $r['id'], 'monto' => (float) $r['monto']])
            ->values();

        $sumaRubrosNueva = $rubrosInput->sum('monto');
        $sumaOtrosActual = (float) OtroRubro::where('user_id', $userId)->sum('monto');

        if (($sumaRubrosNueva + $sumaOtrosActual) > $cap) {
            return back()->withInput()->withErrors([
                'monto_asignado' => 'El total combinado de Rubros + Otros excede el monto asignado.',
            ]);
        }

        $catalog = Rubro::whereIn('id', $rubrosInput->pluck('id'))
            ->get(['id', 'rubro', 'concepto'])
            ->keyBy('id');

        DB::transaction(function () use ($userId, $rubrosInput, $catalog) {
            RubroSolicitado::where('user_id', $userId)->delete();
            foreach ($rubrosInput as $r) {
                if ($cat = $catalog->get($r['id'])) {
                    RubroSolicitado::create([
                        'user_id'  => $userId,
                        'rubro'    => $cat->rubro,
                        'concepto' => $cat->concepto,
                        'monto'    => $r['monto'],
                    ]);
                }
            }
        });

        return back()->with('success', 'Rubros guardados correctamente.');
    }

    /** Guardar SOLO la sección "Otros Rubros" */
    public function saveOtros(Request $request, $rubros_solicitado)
    {
        $userId = Auth::id();

        $validated = $request->validate([
            'otros'            => ['nullable', 'array'],
            'otros.*.rubro'    => ['required_with:otros.*.monto', 'string', 'max:100'],
            'otros.*.concepto' => ['required_with:otros.*.monto', 'string', 'max:255'],
            'otros.*.monto'    => ['nullable', 'numeric', 'min:0'],
        ]);

        $cap = (float) (DatosGenerales::where('user_id', $userId)->value('monto_asignado') ?? 150000.00);

        $otrosInput = collect($validated['otros'] ?? [])
            ->filter(fn ($o) => $o['monto'] !== null && $o['monto'] !== '')
            ->map(fn ($o) => [
                'rubro'    => trim($o['rubro']),
                'concepto' => $o['concepto'] ?? '',
                'monto'    => (float) $o['monto'],
            ])
            ->values();

        $sumaOtrosNueva = $otrosInput->sum('monto');
        $sumaRubrosActual = (float) RubroSolicitado::where('user_id', $userId)->sum('monto');

        if (($sumaRubrosActual + $sumaOtrosNueva) > $cap) {
            return back()->withInput()->withErrors([
                'monto_asignado' => 'El total combinado de Rubros + Otros excede el monto asignado.',
            ]);
        }

        DB::transaction(function () use ($userId, $otrosInput) {
            OtroRubro::where('user_id', $userId)->delete();
            foreach ($otrosInput as $o) {
                OtroRubro::create([
                    'user_id'  => $userId,
                    'rubro'    => $o['rubro'],
                    'concepto' => $o['concepto'],
                    'monto'    => $o['monto'],
                ]);
            }
        });

        return back()->with('success', 'Otros rubros guardados correctamente.');
    }
}
