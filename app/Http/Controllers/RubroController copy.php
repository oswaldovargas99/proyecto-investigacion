<?php

namespace App\Http\Controllers;

use App\Models\Rubro;
use App\Models\RubroSolicitado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RubroController extends Controller
{
    /** ===== Redirige al formulario principal ===== */
    public function index()
    {
        return redirect()->route('usuario.rubros.create');
    }

    /** ===== Formulario principal ===== */
    public function create()
    {
        // Detectar columnas reales en pfp_rubros
        $hasCatId    = Schema::hasColumn('pfp_rubros', 'categoria_id');
        $hasCatName  = Schema::hasColumn('pfp_rubros', 'categoria_nombre');
        $hasCatText  = Schema::hasColumn('pfp_rubros', 'categoria'); // ej. texto simple

        // Selección dinámica de columnas
        $select = ['id', 'clave', 'nombre'];
        if ($hasCatId)   $select[] = 'categoria_id';
        if ($hasCatName) $select[] = 'categoria_nombre';
        if ($hasCatText) $select[] = 'categoria';

        $rows = Rubro::query()->select($select)->orderBy('clave')->get();

        $categorias = [];
        $rubros     = [];
        $mapCat     = [];

        if ($hasCatId) {
            // Con id y opcionalmente nombre
            $categorias = $rows->map(function ($r) use ($hasCatName) {
                return [
                    'id'     => $r->categoria_id,
                    'nombre' => $hasCatName ? $r->categoria_nombre : '',
                ];
            })
            ->unique(fn ($c) => $c['id'])
            ->values()
            ->map(fn ($c) => ['id' => $c['id'], 'nombre' => $c['nombre'] ?? ''])
            ->toArray();

            $rubros = $rows->map(function ($r) use ($hasCatName) {
                return [
                    'id'               => $r->id,
                    'clave'            => (string) $r->clave,
                    'nombre'           => $r->nombre,
                    'categoria_id'     => $r->categoria_id,
                    'categoria_nombre' => $hasCatName ? $r->categoria_nombre : '',
                ];
            })->toArray();
        } elseif ($hasCatText) {
            // Sólo texto de categoría
            $nomes = $rows->pluck('categoria')->filter()->unique()->values();
            foreach ($nomes as $i => $n) {
                $mapCat[$n] = $i + 1; // id artificial
            }
            $categorias = $nomes->map(fn ($n) => ['id' => $mapCat[$n], 'nombre' => $n])->toArray();

            $rubros = $rows->map(function ($r) use ($mapCat) {
                $nombreCat = (string) ($r->categoria ?? '');
                return [
                    'id'               => $r->id,
                    'clave'            => (string) $r->clave,
                    'nombre'           => $r->nombre,
                    'categoria_id'     => $nombreCat !== '' ? $mapCat[$nombreCat] : null,
                    'categoria_nombre' => $nombreCat,
                ];
            })->toArray();
        } else {
            // Sin columnas de categoría
            $rubros = $rows->map(function ($r) {
                return [
                    'id'               => $r->id,
                    'clave'            => (string) $r->clave,
                    'nombre'           => $r->nombre,
                    'categoria_id'     => null,
                    'categoria_nombre' => '',
                ];
            })->toArray();
            $categorias = [];
        }

        // Montos guardados previamente por el usuario
        $rubrosMontosPrev = RubroSolicitado::where('user_id', Auth::id())
            ->get()
            ->mapWithKeys(fn ($rs) => [(string) $rs->clave_rubro => (float) $rs->monto])
            ->toArray();

        $otrosRubrosPrev = [];      // si aún no los persistes
        $montoAsignado   = 105000;  // <-- reemplaza con tu fuente real

        return view('usuario.rubros.form', compact(
            'rubros', 'categorias', 'rubrosMontosPrev', 'otrosRubrosPrev', 'montoAsignado'
        ));
    }

    /** ===== Guardar selección masiva ===== */
    public function store(Request $request)
    {
        $entradaRubros = $request->input('rubros', []);
        $otros         = $request->input('otros', []);

        if (!is_array($entradaRubros)) {
            return back()->with('danger', 'Formato de datos inválido para rubros.');
        }

        $rubrosNormalizados = [];
        foreach ($entradaRubros as $key => $monto) {
            if ($monto === null || $monto === '') continue;
            if (!is_numeric($monto) || $monto < 0) {
                return back()->with('danger', "Monto inválido para el rubro {$key}.");
            }

            $clave = (string) $key;

            // Si la llave parece ser un ID, obtener la clave
            if (ctype_digit((string) $key)) {
                $rubro = Rubro::find($key);
                if (!$rubro) {
                    return back()->with('danger', "Rubro con ID {$key} no existe.");
                }
                $clave = (string) $rubro->clave;
            }

            $rubrosNormalizados[$clave] = (float) $monto;
        }

        $userId = Auth::id();

        DB::transaction(function () use ($userId, $rubrosNormalizados) {
            RubroSolicitado::where('user_id', $userId)->delete();
            foreach ($rubrosNormalizados as $clave => $monto) {
                if ($monto > 0) {
                    RubroSolicitado::create([
                        'user_id'     => $userId,
                        'clave_rubro' => $clave,
                        'monto'       => $monto,
                    ]);
                }
            }
        });

        // Aquí podrías guardar $otros si deseas persistirlos

        return back()->with('success', 'Rubros guardados correctamente.');
    }

    /** ===== Formulario de edición individual ===== */
    public function edit(string $clave)
    {
        $rubro = Rubro::where('clave', $clave)->firstOrFail();

        $rubroSolicitado = RubroSolicitado::where('user_id', Auth::id())
            ->where('clave_rubro', $clave)
            ->first();

        return view('usuario.rubros.edit', compact('rubro', 'rubroSolicitado'));
    }

    /** ===== Actualizar rubro individual ===== */
    public function update(Request $request, string $clave)
    {
        $request->validate([
            'monto' => ['required', 'numeric', 'min:0'],
        ]);

        RubroSolicitado::updateOrCreate(
            ['user_id' => Auth::id(), 'clave_rubro' => $clave],
            ['monto'   => (float) $request->monto]
        );

        return $request->wantsJson()
            ? response()->json(['success' => true])
            : back()->with('success', 'Rubro actualizado correctamente.');
    }

    /** ===== Eliminar un rubro ===== */
    public function destroy(string $clave)
    {
        RubroSolicitado::where('user_id', Auth::id())
            ->where('clave_rubro', $clave)
            ->delete();

        return back()->with('success', 'Rubro eliminado correctamente.');
    }
}
