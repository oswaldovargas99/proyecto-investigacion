<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\Informe;

class InformeController extends Controller
{
    /** Devuelve el primer nombre de columna existente en la tabla; si no hay, null */
    protected function firstExistingColumn(string $table, array $candidates): ?string
    {
        foreach ($candidates as $c) {
            if (Schema::hasColumn($table, $c)) return $c;
        }
        return null;
    }

    public function index()
    {
        // No filtres por user_id si tu tabla no lo tiene
        $informes = Informe::when(Schema::hasColumn((new Informe)->getTable(), 'user_id'), function($q) {
                $q->where('user_id', auth()->id());
            })
            ->latest('fecha')
            ->paginate(5);

        return view('usuario.informes.index', compact('informes'));
    }

    public function create()
    {
        $informe = new Informe();

        // ---- Categorías de Mejora ----
        $catTable = 'pfp_categorias_mejoras';
        $catName  = $this->firstExistingColumn($catTable, ['nombre','nombre_categoria','categoria','titulo','descripcion','label','name']);
        $categoriasMejora = DB::table($catTable)
            ->select('id', DB::raw(($catName ?: 'id')." as nombre"))
            ->orderBy($catName ?: 'id')
            ->get();

        // ---- Tipos de Beneficiario (opcional) ----
        $tbTable = 'pfp_tipos_beneficiarios';
        $tiposBeneficiario = collect();
        if (Schema::hasTable($tbTable)) {
            $tbName = $this->firstExistingColumn($tbTable, ['nombre','tipo','titulo','descripcion','label','name']);
            $tiposBeneficiario = DB::table($tbTable)
                ->select('id', DB::raw(($tbName ?: 'id')." as nombre"))
                ->orderBy($tbName ?: 'id')
                ->get();
        }

        return view('usuario.informes.create', compact(
            'informe','categoriasMejora','tiposBeneficiario'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'fecha'                => ['required','date'],
            'categoria_mejora_id'  => ['required','integer','exists:pfp_categorias_mejoras,id'],
            'criterio_snp_id'      => ['required','integer','exists:pfp_criterios_snp,id'],
            'tipo_beneficiario_id' => ['required','integer','exists:pfp_tipos_beneficiarios,id'],
            'impacto_academico'    => ['required','string'],
            'concepto_gasto'       => ['required','string'],
            'actividad_realizada'  => ['required','string'],
            'numero_beneficiario'  => ['required','integer'],
            'monto_destinado'      => ['required','numeric'],
            'comentarios'          => ['nullable','string'],
        ]);

        // Manteniendo tu misma lógica: asignar siempre el usuario autenticado
        $data['user_id'] = auth()->id();

        $informe = Informe::create($data);

        return redirect()->route('usuario.informes.index', $informe)
            ->with('success', 'Informe creado correctamente.');

    }

    public function edit(Informe $informe)
    {
        $catTable = 'pfp_categorias_mejoras';
        $catName  = $this->firstExistingColumn($catTable, ['nombre','nombre_categoria','categoria','titulo','descripcion','label','name']);
        $categoriasMejora = DB::table($catTable)
            ->select('id', DB::raw(($catName ?: 'id')." as nombre"))
            ->orderBy($catName ?: 'id')
            ->get();

        $tbTable = 'pfp_tipos_beneficiarios';
        $tiposBeneficiario = collect();
        if (Schema::hasTable($tbTable)) {
            $tbName = $this->firstExistingColumn($tbTable, ['nombre','tipo','titulo','descripcion','label','name']);
            $tiposBeneficiario = DB::table($tbTable)
                ->select('id', DB::raw(($tbName ?: 'id')." as nombre"))
                ->orderBy($tbName ?: 'id')
                ->get();
        }

        return view('usuario.informes.edit', compact(
            'informe','categoriasMejora','tiposBeneficiario'
        ));
    }

    public function update(Request $request, Informe $informe)
    {
        $data = $request->validate([
            'fecha'                => ['required','date'],
            'categoria_mejora_id'  => ['required','integer','exists:pfp_categorias_mejoras,id'],
            'criterio_snp_id'      => ['required','integer','exists:pfp_criterios_snp,id'],
            'tipo_beneficiario_id' => ['required','integer','exists:pfp_tipos_beneficiarios,id'],
            'impacto_academico'    => ['required','string'],
            'concepto_gasto'       => ['required','string'],
            'actividad_realizada'  => ['required','string'],
            'numero_beneficiario'  => ['required','integer'],
            'monto_destinado'      => ['required','numeric'],
            'comentarios'          => ['nullable','string'], // único opcional
        ]);

        // Actualizar el registro
        $informe->update($data);

        // Redirigir a index con mensaje de éxito
        return redirect()
            ->route('usuario.informes.index')
            ->with('warning', 'Informe actualizado correctamente.');
    }

    //METODO SHOW
    public function show(Informe $informe)
    {
        $informe->load(['categoriaMejora', 'criterioSnp', 'tipoBeneficiario']); // 👈 importante
        return view('usuario.informes.show', compact('informe'));
    }


    //METODO DESTROY
    public function destroy(Informe $informe)
    {
        $informe->delete();

        return redirect()->route('usuario.informes.index')
            ->with('danger', 'Informe eliminado correctamente.');
    }


    /** ENDPOINT: criterios por categoría (para el select dependiente) */
    public function criteriosPorCategoria($categoriaId)
    {
        $table = 'pfp_criterios_snp';

        // FK real (probamos varias)
        $fk = $this->firstExistingColumn($table, [
            'categoria_mejora_id','categoria_id','id_categoria_mejora','id_categoria','cat_mejora_id'
        ]);

        // Columna visible
        $nameCol = $this->firstExistingColumn($table, [
            'nombre','nombre_criterio','criterio','titulo','descripcion','label','name'
        ]);

        // Columna clave opcional
        $codeCol = $this->firstExistingColumn($table, [
            'clave','codigo','abreviatura','sigla','key'
        ]);

        $q = DB::table($table)->select('id');
        if ($fk) { $q->where($fk, $categoriaId); } // si no hay FK, devolverá todo

        $q->addSelect(DB::raw(($nameCol ?: 'id')." as nombre"));
        $q->addSelect(DB::raw($codeCol ? "$codeCol as clave" : "NULL as clave"));

        $criterios = $q->orderBy($nameCol ?: 'id')->get();

        return response()->json($criterios);
    }
}
