<?php

namespace App\Http\Controllers;

use App\Models\CentroUniversitario;
use Illuminate\Http\Request;

// 👇 IMPORTS ADITIVOS (requeridos para CSV) — No afectan tu lógica previa
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CentroUniversitarioController extends Controller
{
    // ====================== ADITIVO: Encabezados esperados CSV ======================
    /**
     * Encabezados estándar de la plantilla/importación CSV.
     * Mantén el mismo orden para evitar confusiones.
     */
    private array $csvHeaders = [
        'nombre_rector',
        'tipo_centro_universitario',
        'centro_universitario',
        'siglas',
        'direccion',
        'telefonos',
        'sitio_web',
        'colonia',
        'codigo_postal',
        'municipio',
        'estado',
        'pais',
        'vigente', // 1/0, sí/no, true/false
    ];
    // ===============================================================================

    // ====================== ADITIVO: Normalización UTF-8 (compat Excel/Windows) ======================
    /**
     * Convierte un valor a UTF-8 y limpia BOM/caracteres de control.
     * (Aditivo, no altera tu lógica; solo sanea entradas del CSV).
     */
    private function toUtf8($value): ?string
    {
        if ($value === null) return null;
        if (!is_string($value)) $value = (string) $value;

        // Detecta ISO-8859-1 / Windows-1252 y convierte a UTF-8 si es necesario
        $enc = mb_detect_encoding($value, ['UTF-8', 'ISO-8859-1', 'Windows-1252'], true);
        if ($enc && $enc !== 'UTF-8') {
            $value = mb_convert_encoding($value, 'UTF-8', $enc);
        }

        // Quita BOM y caracteres de control no imprimibles
        $value = preg_replace('/^\xEF\xBB\xBF/u', '', $value); // BOM al inicio
        $value = preg_replace('/\x{FEFF}/u', '', $value);      // BOM incrustado
        $value = preg_replace('/[\x00-\x1F\x7F]/u', '', $value);

        return trim($value);
    }
    // ===============================================================================

    // ===== INDEX (con filtro y ordenamiento) =====
    public function index(Request $request)
    {
        $q    = trim((string) $request->input('q', ''));
        $sort = $request->input('sort', 'siglas');
        $dir  = $request->input('dir', 'asc');

        // columnas permitidas para ordenar
        $allowedSort = [
            'siglas', 'centro_universitario', 'nombre_rector',
            'tipo_centro_universitario', 'telefonos', 'municipio', 'estado', 'pais'
        ];
        if (!in_array($sort, $allowedSort, true)) {
            $sort = 'siglas';
        }
        $dir = $dir === 'desc' ? 'desc' : 'asc';

        $centros = CentroUniversitario::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($w) use ($q) {
                    $w->where('siglas', 'like', "%{$q}%")
                      ->orWhere('centro_universitario', 'like', "%{$q}%")
                      ->orWhere('nombre_rector', 'like', "%{$q}%")
                      ->orWhere('tipo_centro_universitario', 'like', "%{$q}%")
                      ->orWhere('telefonos', 'like', "%{$q}%")
                      ->orWhere('municipio', 'like', "%{$q}%")
                      ->orWhere('estado', 'like', "%{$q}%")
                      ->orWhere('pais', 'like', "%{$q}%");
                });
            })
            // filtro opcional por vigencia (?vigente=0|1)
            ->when($request->filled('vigente'), function ($query) use ($request) {
                $query->where('vigente', (int) $request->input('vigente'));
            })
            ->orderBy($sort, $dir)
            ->paginate(10)
            ->withQueryString(); // conserva q, sort, dir, vigente

        return view('administrador.centros.index', compact('centros', 'q', 'sort', 'dir'));
    }

    // ===== CREATE =====
    public function create()
    {
        return view('administrador.centros.create');
    }

    // ===== STORE =====
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_rector'             => 'required|string|max:255',
            'tipo_centro_universitario' => 'required|in:Centro Universitario Metropolitano,Centro Universitario Regional',
            'centro_universitario'      => 'required|string|max:255',
            'siglas'                    => 'required|string|max:50',
            'direccion'                 => 'required|string|max:255',
            'telefonos'                 => 'required|string|max:50',
            'sitio_web'                 => 'nullable|url',
            'colonia'                   => 'nullable|string|max:100',
            'codigo_postal'             => 'nullable|string|max:10',
            'municipio'                 => 'required|string|max:100',
            'estado'                    => 'required|string|max:100',
            'pais'                      => 'required|string|max:100',
            'vigente'                   => 'required|in:0,1',
        ]);

        CentroUniversitario::create($validated);

        return redirect()
            ->route('admin.centros.index')
            ->with('success', 'Centro Universitario creado correctamente.');
    }

    // ===== EDIT =====
    public function edit(CentroUniversitario $centro)
    {
        return view('administrador.centros.edit', compact('centro'));
    }

    // ===== UPDATE =====
    public function update(Request $request, CentroUniversitario $centro)
    {
        $validated = $request->validate([
            'nombre_rector'             => 'required|string|max:255',
            'tipo_centro_universitario' => 'required|in:Centro Universitario Metropolitano,Centro Universitario Regional',
            'centro_universitario'      => 'required|string|max:255',
            'siglas'                    => 'required|string|max:50',
            'direccion'                 => 'required|string|max:255',
            'telefonos'                 => 'required|string|max:50',
            'sitio_web'                 => 'nullable|url',
            'colonia'                   => 'nullable|string|max:100',
            'codigo_postal'             => 'nullable|string|max:10',
            'municipio'                 => 'required|string|max:100',
            'estado'                    => 'required|string|max:100',
            'pais'                      => 'required|string|max:100',
            'vigente'                   => 'required|in:0,1',
        ]);

        $centro->update($validated);

        return redirect()
            ->route('admin.centros.index')
            ->with('warning', 'Centro Universitario actualizado correctamente.');
    }

    // ===== DESTROY =====
    public function destroy(CentroUniversitario $centro)
    {
        $centro->delete();

        return redirect()
            ->route('admin.centros.index')
            ->with('danger', 'Centro Universitario eliminado correctamente.');
    }

    // ===== SHOW =====
    public function show(CentroUniversitario $centro)
    {
        return view('administrador.centros.show', compact('centro'));
    }

    // ====================== ADITIVO: DESCARGAR PLANTILLA CSV ======================
    /**
     * Descarga la plantilla CSV con encabezados correctos y una fila de ejemplo.
     * No altera ninguna parte de tu lógica CRUD.
     */
    public function templateCsv(): StreamedResponse
    {
        $filename = 'plantilla_centros_' . now()->format('Ymd_His') . '.csv';

        $response = new StreamedResponse(function () {
            $handle = fopen('php://output', 'w');

            // Encabezados
            fputcsv($handle, $this->csvHeaders);

            // Fila de ejemplo (opcional)
            fputcsv($handle, [
                'Dra. Nombre Apellido',
                'Centro Universitario Regional',
                'Centro Universitario de Ejemplo',
                'CUEX',
                'Av. Universidad #123, Col. Centro',
                '33-1234-5678',
                'https://www.ejemplo.udg.mx',
                'Centro',
                '44100',
                'Guadalajara',
                'Jalisco',
                'México',
                '1',
            ]);

            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv; charset=UTF-8');
        $response->headers->set('Content-Disposition', "attachment; filename=\"{$filename}\"");

        return $response;
    }

    /**
     * 🔁 Alias para compatibilidad con rutas que llaman a 'plantillaCsv'.
     * Mantiene intacta tu lógica: delega en templateCsv().
     */
    public function plantillaCsv(): StreamedResponse
    {
        return $this->templateCsv();
    }

    // =========================== ADITIVO: IMPORTAR CSV ===========================
    /**
     * Importa un archivo CSV y realiza UPSERT por 'siglas' para evitar duplicados.
     * - Valida el archivo y encabezados.
     * - Inserta/actualiza en la tabla de centros.
     * - Devuelve mensajes de sesión (success/warning/error).
     * - No toca tu lógica previa.
     */
    public function importCsv(Request $request)
    {
        $request->validate([
            'csv_file' => ['required','file','mimetypes:text/plain,text/csv,application/csv,application/vnd.ms-excel','max:5120'],
        ], [
            'csv_file.required' => 'Selecciona un archivo .csv.',
            'csv_file.mimetypes' => 'El archivo debe ser un CSV válido.',
            'csv_file.max' => 'El CSV no debe exceder 5 MB.',
        ]);

        // (Aditivo) Refuerza la conexión en utf8mb4 por si MySQL está en latin1
        try {
            DB::statement("SET NAMES 'utf8mb4' COLLATE 'utf8mb4_unicode_ci'");
        } catch (\Throwable $e) {
            // silencioso: no altera flujo
        }

        $path = $request->file('csv_file')->getRealPath();

        $insertados = 0;
        $actualizados = 0;
        $errores = [];

        if (($handle = fopen($path, 'r')) === false) {
            return back()->with('error', 'No fue posible abrir el archivo CSV.');
        }

        // Encabezados
        $headers = fgetcsv($handle);
        if (!$headers) {
            fclose($handle);
            return back()->with('error', 'El CSV no contiene encabezados.');
        }

        // Quitar posible BOM del primer encabezado y normalizar -> lower
        if (isset($headers[0])) {
            $headers[0] = preg_replace('/^\xEF\xBB\xBF/', '', (string) $headers[0]);
        }
        $headers = array_map(fn($h) => strtolower($this->toUtf8((string) $h)), $headers);

        // Validar encabezados
        $faltantes = array_diff($this->csvHeaders, $headers);
        if (!empty($faltantes)) {
            fclose($handle);
            return back()->with('error',
                'Encabezados inválidos. Faltan: '.implode(', ', $faltantes)
                .' | Esperados: '.implode(', ', $this->csvHeaders)
            );
        }

        $idx = array_flip($headers); // nombre_columna => índice

        DB::beginTransaction();
        try {
            $linea = 1; // ya se leyó encabezado
            while (($row = fgetcsv($handle)) !== false) {
                $linea++;

                // Fila vacía -> continuar
                if (count(array_filter($row, fn($v) => trim((string)$v) !== '')) === 0) {
                    continue;
                }

                // Mapear columnas esperadas + normalización UTF-8 (aditivo)
                $data = [];
                foreach ($this->csvHeaders as $col) {
                    $value = $row[$idx[$col]] ?? null;
                    $data[$col] = $this->toUtf8($value);
                }

                // Normalizar 'vigente' (misma lógica)
                $vigenteRaw = strtolower((string)($data['vigente'] ?? ''));
                $data['vigente'] = in_array($vigenteRaw, ['1','si','sí','true','activo','activa'], true) ? 1 : 0;

                // Validaciones mínimas (misma lógica)
                if (empty($data['centro_universitario']) || empty($data['siglas'])) {
                    $errores[] = "Línea {$linea}: 'centro_universitario' y 'siglas' son obligatorios.";
                    continue;
                }

                // Timestamps si tu tabla los maneja (misma lógica)
                $ahora = now();
                $data['updated_at'] = $ahora;
                if (!array_key_exists('created_at', $data)) {
                    $data['created_at'] = $ahora;
                }

                // UPSERT por 'siglas' (misma lógica)
                $exists = CentroUniversitario::where('siglas', $data['siglas'])->exists();

                if ($exists) {
                    // Evitar sobreescribir created_at
                    $toUpdate = $data;
                    unset($toUpdate['created_at']);

                    CentroUniversitario::where('siglas', $data['siglas'])->update($toUpdate);
                    $actualizados++;
                } else {
                    CentroUniversitario::create($data);
                    $insertados++;
                }
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Error importando Centros CSV: '.$e->getMessage(), ['trace' => $e->getTraceAsString()]);
            fclose($handle);
            return back()->with('error', 'Ocurrió un error durante la importación: '.$e->getMessage());
        }

        fclose($handle);

        $mensaje = "Importación finalizada: {$insertados} registro(s) insertado(s), {$actualizados} actualizado(s).";
        if (!empty($errores)) {
            $resumen = implode(' | ', array_slice($errores, 0, 5));
            $mensaje .= " Con observaciones: {$resumen}".(count($errores) > 5 ? ' ...' : '');
            return back()->with(['warning' => $mensaje]);
        }

        return back()->with('success', $mensaje);
    }
}
