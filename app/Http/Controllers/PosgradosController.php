<?php

namespace App\Http\Controllers;

use App\Models\Posgrados;
use App\Models\CentroUniversitario;
use App\Models\NivelAcademico;
use App\Models\Orientacion;
use App\Models\Modalidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PosgradosController extends Controller
{
    // LISTADO + BÚSQUEDA
    public function index(Request $request)
    {
        $q = trim((string) $request->input('q', ''));

        $posgrados = Posgrados::with(['centroUniversitario','nivelAcademico','orientacionPosgrado','modalidadPosgrado'])
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($qq) use ($q) {
                    $qq->where('nombre_posgrado', 'like', "%{$q}%")
                       ->orWhere('clave_snp', 'like', "%{$q}%")
                       ->orWhereHas('centroUniversitario', function ($cq) use ($q) {
                           $cq->where('centro_universitario', 'like', "%{$q}%");
                       })
                       ->orWhereHas('nivelAcademico', function ($cq) use ($q) {
                           $cq->where('nivel_academico', 'like', "%{$q}%");
                       })
                       ->orWhereHas('orientacionPosgrado', function ($cq) use ($q) {
                           $cq->where('orientacion', 'like', "%{$q}%");
                       })
                       ->orWhereHas('modalidadPosgrado', function ($cq) use ($q) {
                           $cq->where('modalidad', 'like', "%{$q}%");
                       });
                });
            })
            ->orderBy('nombre_posgrado')
            ->paginate(5)
            ->withQueryString();

        return view('administrador.posgrados.index', compact('posgrados', 'q'));
    }

    // CREAR
    public function create()
    {
        $centros = CentroUniversitario::orderBy('centro_universitario')->get(['id','centro_universitario']);
        $niveles = NivelAcademico::select('id','nivel_academico as nombre')->orderBy('nivel_academico')->get();
        $orientaciones = Orientacion::select('id','orientacion as nombre')->orderBy('orientacion')->get();
        $modalidades = Modalidad::select('id','modalidad as nombre')->orderBy('modalidad')->get();

        return view('administrador.posgrados.create', compact('centros', 'niveles', 'orientaciones', 'modalidades'));
    }

    // GUARDAR
    public function store(Request $request)
    {
        $validated = $request->validate([
            'clave_snp'               => 'required|string|max:50|unique:pfp_posgrados,clave_snp',
            'nombre_posgrado'         => 'required|string|max:255',
            'centro_universitario_id' => 'required|integer|exists:pfp_centros_universitarios,id',
            'nivel_academico_id'      => 'required|integer|exists:pfp_niveles_academicos,id',
            'orientacion_posgrado_id' => 'required|integer|exists:pfp_orientaciones,id',
            'modalidad_posgrado_id'   => 'required|integer|exists:pfp_modalidades,id',
        ]);

        Posgrados::create($validated);

        return redirect()->route('admin.posgrados.index')->with('success', 'Posgrado creado correctamente.');
    }

    // VER DETALLE
    public function show(Posgrados $posgrado)
    {
        $posgrado->load(['centroUniversitario','nivelAcademico','orientacionPosgrado','modalidadPosgrado']);
        return view('administrador.posgrados.show', compact('posgrado'));
    }

    // EDITAR
    public function edit(Posgrados $posgrado)
    {
        $centros = CentroUniversitario::orderBy('centro_universitario')->get(['id','centro_universitario']);
        $niveles = NivelAcademico::select('id','nivel_academico as nombre')->orderBy('nivel_academico')->get();
        $orientaciones = Orientacion::select('id','orientacion as nombre')->orderBy('orientacion')->get();
        $modalidades = Modalidad::select('id','modalidad as nombre')->orderBy('modalidad')->get();

        return view('administrador.posgrados.edit', compact('posgrado', 'centros', 'niveles', 'orientaciones', 'modalidades'));
    }

    // ACTUALIZAR
    public function update(Request $request, Posgrados $posgrado)
    {
        $validated = $request->validate([
            'clave_snp'               => 'required|string|max:50|unique:pfp_posgrados,clave_snp,' . $posgrado->id,
            'nombre_posgrado'         => 'required|string|max:255',
            'centro_universitario_id' => 'required|integer|exists:pfp_centros_universitarios,id',
            'nivel_academico_id'      => 'required|integer|exists:pfp_niveles_academicos,id',
            'orientacion_posgrado_id' => 'required|integer|exists:pfp_orientaciones,id',
            'modalidad_posgrado_id'   => 'required|integer|exists:pfp_modalidades,id',
        ]);

        $posgrado->update($validated);

        return redirect()->route('admin.posgrados.index')->with('warning', 'Posgrado actualizado correctamente.');
    }

    // ELIMINAR
    public function destroy(Posgrados $posgrado)
    {
        $posgrado->delete();
        return redirect()->route('admin.posgrados.index')->with('danger', 'Posgrado eliminado correctamente.');
    }

    // IMPORTAR CSV (Upsert por clave_snp)
    public function importCsv(Request $request)
    {
        $request->validate([
            'csv' => ['required','file','mimetypes:text/plain,text/csv,application/vnd.ms-excel','max:5120'],
        ]);

        $file   = $request->file('csv');
        $path   = $file->getRealPath();
        $handle = fopen($path, 'r');

        // Detecta delimitador
        $firstLine  = fgets($handle);
        $candidates = [',' => substr_count($firstLine, ','), ';' => substr_count($firstLine, ';'), "\t" => substr_count($firstLine, "\t")];
        $delim = array_search(max($candidates), $candidates, true);
        rewind($handle);

        // Encabezados
        $header = fgetcsv($handle, 0, $delim);
        if (!$header) return back()->with('danger', 'El CSV está vacío o es inválido.');
        if (isset($header[0])) $header[0] = preg_replace('/^\xEF\xBB\xBF/', '', $header[0]);

        $map  = array_change_key_case(array_flip($header), CASE_LOWER);
        $need = ['clave_snp','nombre_posgrado','centro_universitario_id','nivel_academico_id','orientacion_posgrado_id','modalidad_posgrado_id'];
        foreach ($need as $h) {
            if (!array_key_exists($h, $map)) { fclose($handle); return back()->with('danger', "Falta la columna requerida: {$h}"); }
        }

        $inserted = 0; $updated = 0; $rownum = 1;

        DB::beginTransaction();
        try {
            while (($row = fgetcsv($handle, 0, $delim)) !== false) {
                $rownum++;
                if (count(array_filter($row, fn($v) => trim((string)$v) !== '')) === 0) continue;

                $data = [
                    'clave_snp'               => trim($row[$map['clave_snp']] ?? ''),
                    'nombre_posgrado'         => trim($row[$map['nombre_posgrado']] ?? ''),
                    'centro_universitario_id' => (int)($row[$map['centro_universitario_id']] ?? 0),
                    'nivel_academico_id'      => (int)($row[$map['nivel_academico_id']] ?? 0),
                    'orientacion_posgrado_id' => (int)($row[$map['orientacion_posgrado_id']] ?? 0),
                    'modalidad_posgrado_id'   => (int)($row[$map['modalidad_posgrado_id']] ?? 0),
                ];

                if ($data['clave_snp'] === '' || $data['nombre_posgrado'] === '') {
                    throw new \RuntimeException("Fila {$rownum}: 'clave_snp' y 'nombre_posgrado' son obligatorios.");
                }

                $posgrado = Posgrados::where('clave_snp', $data['clave_snp'])->first();
                if ($posgrado) { $posgrado->update($data); $updated++; }
                else { Posgrados::create($data); $inserted++; }
            }
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            fclose($handle);
            return back()->with('danger', 'Error al importar en la fila '.$rownum.': '.$e->getMessage());
        }

        fclose($handle);
        return back()->with('success', "Importación completada: {$inserted} creados, {$updated} actualizados.");
    }

    // PLANTILLA CSV
    public function plantillaCsv()
    {
        $filename = 'plantilla_posgrados.csv';
        $headers  = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $columns = ['clave_snp','nombre_posgrado','centro_universitario_id','nivel_academico_id','orientacion_posgrado_id','modalidad_posgrado_id'];

        $callback = function () use ($columns) {
            $out = fopen('php://output', 'w');
            fwrite($out, chr(0xEF).chr(0xBB).chr(0xBF)); // BOM UTF-8
            fputcsv($out, $columns);
            fputcsv($out, ['SNP-001','Maestría en Ciencias', 1, 1, 1, 1]); // ejemplo
            fclose($out);
        };

        return response()->stream($callback, 200, $headers);
    }
}
