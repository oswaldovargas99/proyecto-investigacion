<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SolicitudAdminController extends Controller
{
    /**
     * Listado consolidado (Datos Generales + Solicitud + Rubros + Catálogos)
     */
    public function index(Request $request)
    {
        $q = trim($request->get('q', ''));

        $base = DB::table('pfp_datos_generales as dg')
            ->join('pfp_solicitudes as s', 'dg.user_id', '=', 's.usuario_id')
            // 🔑 Los rubros solicitados se ligan por user_id
            ->leftJoin('pfp_rubros_solicitados as rs', 'rs.user_id', '=', 's.usuario_id')
            ->leftJoin('pfp_centros_universitarios as cu', 'dg.centro_universitario_id', '=', 'cu.id')
            ->leftJoin('pfp_niveles_academicos as na', 'dg.nivel_academico_id', '=', 'na.id')
            ->leftJoin('pfp_posgrados as pp', 'dg.posgrado_id', '=', 'pp.id')
            ->select(
                's.id',
                'cu.centro_universitario',
                'dg.codigo',
                'dg.nombre_coordinador',
                DB::raw('COALESCE(na.nivel_academico, "") as nivel_estudios'),
                // Clave SNP: prioriza catálogo de posgrados; fallback a DG si existiera
                DB::raw('COALESCE(pp.clave_snp, dg.clave_snp, "") as clave_snp'),
                DB::raw('COALESCE(pp.nombre_posgrado, "") as nombre_posgrado'),
                // Suma por usuario (no por solicitud_id)
                DB::raw('COALESCE(SUM(rs.monto), 0) as total_asignado')
            )
            ->groupBy(
                's.id',
                'cu.centro_universitario',
                'dg.codigo',
                'dg.nombre_coordinador',
                'na.nivel_academico',
                'pp.clave_snp',
                'dg.clave_snp',
                'pp.nombre_posgrado'
            )
            ->orderBy('cu.centro_universitario', 'asc');

        // Búsqueda
        if ($q !== '') {
            $base->where(function ($w) use ($q) {
                $w->where('cu.centro_universitario', 'like', "%{$q}%")
                  ->orWhere('dg.nombre_coordinador', 'like', "%{$q}%")
                  ->orWhere('dg.codigo', 'like', "%{$q}%")
                  ->orWhere('na.nivel_academico', 'like', "%{$q}%")
                  ->orWhere('pp.nombre_posgrado', 'like', "%{$q}%")
                  ->orWhere('pp.clave_snp', 'like', "%{$q}%");
            });
        }

        $solicitudes = $base->paginate(10)->withQueryString();

        // Vista de solicitudes (admin)
        return view('administrador.solicitudes.index', compact('solicitudes', 'q'));
    }

    /**
     * Detalle de una solicitud
     */
    public function show($id)
    {
        $solicitud = DB::table('pfp_solicitudes as s')
            ->join('pfp_datos_generales as dg', 'dg.user_id', '=', 's.usuario_id')
            ->leftJoin('pfp_centros_universitarios as cu', 'dg.centro_universitario_id', '=', 'cu.id')
            ->leftJoin('pfp_niveles_academicos as na', 'dg.nivel_academico_id', '=', 'na.id')
            ->leftJoin('pfp_posgrados as pp', 'dg.posgrado_id', '=', 'pp.id')
            ->select(
                's.*', // fecha, modalidad, objetivo, justificacion, resultados, usuario_id, etc.
                'cu.centro_universitario',
                'dg.codigo',
                'dg.nombre_coordinador',
                DB::raw('COALESCE(na.nivel_academico, "") as nivel_estudios'),
                DB::raw('COALESCE(pp.clave_snp, dg.clave_snp, "") as clave_snp'),
                DB::raw('COALESCE(pp.nombre_posgrado, "") as nombre_posgrado')
            )
            ->where('s.id', $id)
            ->first();

        if (!$solicitud) {
            return redirect()->route('admin.solicitudes.index')
                ->with('danger', 'No se encontró la solicitud solicitada.');
        }

        $documentacion = DB::table('pfp_documentaciones')
            ->where('usuario_id', $solicitud->usuario_id)
            ->first();

        // Rubros del usuario (no existe solicitud_id en pfp_rubros_solicitados)
        $rubros = DB::table('pfp_rubros_solicitados as rs')
            ->select(
                DB::raw('rs.rubro as rubro_nombre'),
                DB::raw('rs.concepto as descripcion'),
                DB::raw('rs.monto as monto_solicitado')
            )
            ->where('rs.user_id', $solicitud->usuario_id)
            ->get();

        return view('administrador.solicitudes.show', compact('solicitud', 'documentacion', 'rubros'));
    }

    /**
     * Mostrar el PDF institucional usando tu vista existente
     */
    public function pdf($id)
    {
        $solicitud = DB::table('pfp_solicitudes as s')
            ->join('pfp_datos_generales as dg', 'dg.user_id', '=', 's.usuario_id')
            ->leftJoin('pfp_centros_universitarios as cu', 'dg.centro_universitario_id', '=', 'cu.id')
            ->leftJoin('pfp_niveles_academicos as na', 'dg.nivel_academico_id', '=', 'na.id')
            ->leftJoin('pfp_posgrados as pp', 'dg.posgrado_id', '=', 'pp.id')
            ->select(
                's.*',
                'cu.centro_universitario',
                'dg.codigo',
                'dg.nombre_coordinador',
                DB::raw('COALESCE(na.nivel_academico, "") as nivel_estudios'),
                DB::raw('COALESCE(pp.clave_snp, dg.clave_snp, "") as clave_snp'),
                DB::raw('COALESCE(pp.nombre_posgrado, "") as nombre_posgrado')
            )
            ->where('s.id', $id)
            ->first();

        if (!$solicitud) {
            return redirect()->route('admin.solicitudes.index')
                ->with('danger', 'No se encontró la solicitud solicitada.');
        }

        $documentacion = DB::table('pfp_documentaciones')
            ->where('usuario_id', $solicitud->usuario_id)
            ->first();

        $rubros = DB::table('pfp_rubros_solicitados as rs')
            ->select(
                DB::raw('rs.rubro as rubro_nombre'),
                DB::raw('rs.concepto as descripcion'),
                DB::raw('rs.monto as monto_solicitado')
            )
            ->where('rs.user_id', $solicitud->usuario_id)
            ->get();

        // Renderiza tu plantilla existente del PDF
        return view('usuario.solicitud.pdf', compact('solicitud', 'documentacion', 'rubros'));
    }
}
