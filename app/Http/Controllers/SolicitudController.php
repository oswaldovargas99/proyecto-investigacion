<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Solicitud;
use App\Models\Tema;
use App\Models\DatosGenerales;
use Barryvdh\DomPDF\Facade\Pdf;

class SolicitudController extends Controller
{
    /** Form de creación; si ya existe, redirige a edición */
    public function create()
    {
        $usuarioId = Auth::id();

        if ($solicitud = Solicitud::where('usuario_id', $usuarioId)->first()) {
            return redirect()->route('usuario.solicitud.edit', $solicitud->id);
        }

        $datos               = DatosGenerales::where('user_id', $usuarioId)->first();
        $codigo              = $datos->codigo ?? '';
        $nombre_coordinador  = $datos->nombre_coordinador ?? '';
        $temas               = Tema::all();

        return view('usuario.solicitud.create', compact('temas', 'codigo', 'nombre_coordinador'));
    }

    /** Guardar */
    public function store(Request $request)
    {
        $data = $request->validate([
            'fecha_solicitud'       => ['required','date'],
            'modalidad'             => ['required','string'],
            'objetivo'              => ['required','string','max:500'],
            'justificacion'         => ['required','string','max:500'],
            'resultados_esperados'  => ['required','string','max:500'],
            'temas'                 => ['array','nullable'],
        ]);

        $data['usuario_id'] = Auth::id();

        $solicitud = Solicitud::create($data);

        // Relación temas
        $solicitud->temas()->sync($request->input('temas', []));

        return redirect()
            ->route('usuario.solicitud.edit', $solicitud->id)
            ->with('success', 'Solicitud guardada correctamente.');
    }

    /** Editar */
    public function edit($id)
    {
        $solicitud = Solicitud::findOrFail($id);
        abort_unless($solicitud->usuario_id === Auth::id(), 403);

        $temas              = Tema::all();
        $temasSeleccionados = $solicitud->temas()->pluck('tema_id')->map(fn($v)=> (string)$v)->toArray();

        $datos              = DatosGenerales::where('user_id', Auth::id())->first();
        $codigo             = $datos->codigo ?? '';
        $nombre_coordinador = $datos->nombre_coordinador ?? '';

        return view('usuario.solicitud.edit', compact(
            'solicitud', 'temas', 'temasSeleccionados', 'codigo', 'nombre_coordinador'
        ));
    }

    /** Actualizar */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'fecha_solicitud'       => ['required','date'],
            'modalidad'             => ['required','string'],
            'objetivo'              => ['required','string','max:500'],
            'justificacion'         => ['required','string','max:500'],
            'resultados_esperados'  => ['required','string','max:500'],
            'temas'                 => ['array','nullable'],
        ]);

        $solicitud = Solicitud::findOrFail($id);
        abort_unless($solicitud->usuario_id === Auth::id(), 403);

        $solicitud->update($data);
        $solicitud->temas()->sync($request->input('temas', []));

        return back()->with('success', 'Solicitud actualizada correctamente.');
    }

    /** PDF de una solicitud específica */
    public function generarPDF($id)
    {
        $solicitud = Solicitud::with([
            'temas',
            'datosGenerales.centro',
            'datosGenerales.programaPosgrado',
            'datosGenerales.modalidad',
        ])->findOrFail($id);

        abort_unless($solicitud->usuario_id === Auth::id(), 403);

        // Render de la vista PDF
        $pdf = Pdf::loadView('usuario.oficios.solicitud_pdf', [
                'solicitud' => $solicitud,
                // si ocupas membrete en la vista: public/img/membretes/CGIPV.png
                // usa: <img src="{{ public_path('img/membretes/CGIPV.png') }}" ...>
            ])
            ->setPaper('letter');

        // === Numeración estable sin usar Canvas->getFontMetrics() ===
        // Evita el error "Call to undefined method Dompdf\Adapter\CPDF::getFontMetrics()"
        $dompdf      = $pdf->getDomPDF();
        $dompdf->render();
        $canvas      = $dompdf->getCanvas();
        $fontMetrics = $dompdf->getFontMetrics();
        $font        = $fontMetrics->getFont('helvetica', 'normal');

        // Esquina inferior derecha (coordenadas aproximadas para carta)
        // Placeholders {PAGE_NUM} y {PAGE_COUNT} los resuelve Dompdf automáticamente
        $canvas->page_text(520, 770, "Página {PAGE_NUM} de {PAGE_COUNT}", $font, 9, [0,0,0]);

        return $pdf->stream('solicitud-pfp-2025.pdf');
    }

    /** PDF de la solicitud del usuario actual (si existe) */
    public function pdfActual()
    {
        $solicitud = Solicitud::where('usuario_id', Auth::id())->first();

        if (!$solicitud) {
            return redirect()
                ->route('usuario.solicitud.create')
                ->with('warning', 'Aún no registras tu Solicitud.');
        }

        return $this->generarPDF($solicitud->id);
    }
}
