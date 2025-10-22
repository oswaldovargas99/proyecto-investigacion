<?php

namespace App\Http\Controllers\Catalogos;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CascadaController extends Controller
{
    protected function firstExistingColumn(string $table, array $candidates): ?string
    {
        foreach ($candidates as $c) {
            if (Schema::hasColumn($table, $c)) return $c;
        }
        return null;
    }

    public function criteriosPorCategoria($categoriaId)
    {
        $table = 'pfp_criterios_snp';

        // Columna para "nombre" visible
        $nameCol = $this->firstExistingColumn($table, ['nombre','nombre_criterio','criterio','titulo','descripcion','label','name']);
        // Columna para "clave" opcional
        $codeCol = $this->firstExistingColumn($table, ['clave','codigo','abreviatura','sigla','key']);

        $q = DB::table($table)->where('categoria_mejora_id', $categoriaId)->select('id');

        if ($nameCol) {
            $q->addSelect(DB::raw("$nameCol as nombre"))->orderBy($nameCol);
        } else {
            $q->addSelect(DB::raw("CAST(id AS CHAR) as nombre"))->orderBy('id');
        }

        if ($codeCol) {
            $q->addSelect(DB::raw("$codeCol as clave"));
        } else {
            $q->addSelect(DB::raw("NULL as clave"));
        }

        $criterios = $q->get();

        return response()->json($criterios);
    }
}
