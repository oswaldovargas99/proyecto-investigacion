<?php

namespace App\Http\Controllers;

use App\Models\Documentacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentacionController extends Controller
{
    /**
     * Formulario de creación (si ya hay registro, se muestra preview/oculta inputs).
     * Ruta: GET /usuario/documentaciones/create  (nombre: usuario.documentaciones.create)
     */
    public function create()
    {
        $documentacion = Documentacion::where('usuario_id', Auth::id())->first();
        return view('usuario.documentaciones.create', compact('documentacion'));
    }

    /**
     * Guardar/actualizar (upsert) PDFs (puede recibir varios campos).
     * Ruta: POST /usuario/documentaciones  (nombre: usuario.documentaciones.store)
     */
    public function store(Request $request)
    {
        $usuarioId = Auth::id();

        $request->validate([
            'acta_junta'        => 'nullable|file|mimes:pdf|max:51200',
            'carta_no_adeudo'   => 'nullable|file|mimes:pdf|max:51200',
            'p3e'               => 'nullable|file|mimes:pdf|max:51200',
            'solicitud_firmado' => 'nullable|file|mimes:pdf|max:51200',
            'informe_firmado'   => 'nullable|file|mimes:pdf|max:51200',
        ]);

        $campos = ['acta_junta','carta_no_adeudo','p3e','solicitud_firmado','informe_firmado'];
        $data   = ['usuario_id' => $usuarioId];

        $existente = Documentacion::where('usuario_id', $usuarioId)->first();

        foreach ($campos as $campo) {
            if ($request->hasFile($campo)) {
                if ($existente && !empty($existente->{$campo}) && Storage::disk('public')->exists($existente->{$campo})) {
                    Storage::disk('public')->delete($existente->{$campo});
                }
                $file     = $request->file($campo);
                $fileName = "{$usuarioId}-{$campo}_convocatoria_2025.pdf";
                $path     = $file->storeAs('documentaciones', $fileName, 'public');
                $data[$campo] = $path; // ruta relativa dentro de storage/app/public
            }
        }

        Documentacion::updateOrCreate(['usuario_id' => $usuarioId], $data);

        return redirect()->route('usuario.documentaciones.create')
                         ->with('success', 'Documentos guardados correctamente.');
    }

    /**
     * Actualiza un ÚNICO campo ({campo}) con un nuevo PDF.
     * Ruta: PUT /usuario/documentaciones/{campo}  (nombre: usuario.documentaciones.update)
     */
    public function update(Request $request, $campo)
    {
        $usuarioId = Auth::id();

        $camposValidos = ['acta_junta','carta_no_adeudo','p3e','solicitud_firmado','informe_firmado'];
        if (!in_array($campo, $camposValidos, true)) {
            return redirect()->route('usuario.documentaciones.create')->with('error', 'Campo no válido.');
        }

        $request->validate([
            $campo => 'required|file|mimes:pdf|max:51200',
        ]);

        $doc = Documentacion::where('usuario_id', $usuarioId)->firstOrFail();

        if (!empty($doc->{$campo}) && Storage::disk('public')->exists($doc->{$campo})) {
            Storage::disk('public')->delete($doc->{$campo});
        }

        $file     = $request->file($campo);
        $fileName = "{$usuarioId}-{$campo}_convocatoria_2025.pdf";
        $path     = $file->storeAs('documentaciones', $fileName, 'public');

        $doc->{$campo} = $path;
        $doc->save();

        return redirect()->route('usuario.documentaciones.create')
                         ->with('success', 'Documento actualizado correctamente.');
    }

    /**
     * Elimina un archivo específico y limpia el campo en BD.
     * Ruta: DELETE /usuario/documentaciones/{field}  (nombre: usuario.documentaciones.deleteFile)
     */
    public function destroyFile($field)
    {
        $usuarioId = Auth::id();
        $doc = Documentacion::where('usuario_id', $usuarioId)->firstOrFail();

        $camposValidos = ['acta_junta','carta_no_adeudo','p3e','solicitud_firmado','informe_firmado'];
        if (!in_array($field, $camposValidos, true)) {
            return redirect()->route('usuario.documentaciones.create')->with('error', 'Campo no válido.');
        }

        if (!empty($doc->{$field}) && Storage::disk('public')->exists($doc->{$field})) {
            Storage::disk('public')->delete($doc->{$field});
        }

        $doc->{$field} = null;
        $doc->save();

        return redirect()->route('usuario.documentaciones.create')->with('success', 'Archivo eliminado correctamente.');
    }
}
