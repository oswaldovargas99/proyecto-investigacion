<?php

namespace App\Http\Controllers;

use App\Models\Convocatoria;
use Illuminate\Http\Request;

class ConvocatoriaController extends Controller
{
    /**
     * Mostrar listado de convocatorias (paginado + búsqueda opcional).
     */
    public function index(Request $request)
    {
        $q = trim($request->get('q', ''));

        $convocatorias = Convocatoria::query()
            ->where('user_id', auth()->id()) // solo las del usuario autenticado
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($sub) use ($q) {
                    $sub->where('nombre_convocatoria', 'like', "%{$q}%")
                        ->orWhere('lema', 'like', "%{$q}%")
                        ->orWhere('responsable', 'like', "%{$q}%")
                        ->orWhere('cargo', 'like', "%{$q}%")
                        ->orWhere('anio', 'like', "%{$q}%");
                });
            })
            ->orderByDesc('anio')
            ->orderByDesc('fecha_inicio')
            ->paginate(10)
            ->withQueryString();

        return view('administrador.convocatorias.index', compact('convocatorias', 'q'));
    }

    /**
     * Formulario para crear nueva convocatoria.
     */
    public function create()
    {
        return view('administrador.convocatorias.create');
    }

    /**
     * Guardar nueva convocatoria.
     */
    public function store(Request $request)
    {
        $data = $this->validateData($request);

        $data['user_id']   = auth()->id();
        $data['id_status'] = $request->boolean('id_status');

        Convocatoria::create($data);

        return redirect()
            ->route('admin.convocatorias.index')
            ->with('success', 'Convocatoria creada correctamente.');
    }

    /**
     * Mostrar detalles de una convocatoria.
     */
    public function show(Convocatoria $convocatoria)
    {
        $this->authorizeOwner($convocatoria);

        return view('administrador.convocatorias.show', compact('convocatoria'));
    }

    /**
     * Formulario de edición.
     */
    public function edit(Convocatoria $convocatoria)
    {
        $this->authorizeOwner($convocatoria);

        return view('administrador.convocatorias.edit', compact('convocatoria'));
    }

    /**
     * Actualizar convocatoria.
     */
    public function update(Request $request, Convocatoria $convocatoria)
    {
        $this->authorizeOwner($convocatoria);

        $data = $this->validateData($request);
        $data['id_status'] = $request->boolean('id_status');

        $convocatoria->update($data);

        return redirect()
            ->route('admin.convocatorias.index')
            ->with('success', 'Convocatoria actualizada correctamente.');
    }

    /**
     * Eliminar convocatoria.
     */
    public function destroy(Convocatoria $convocatoria)
    {
        $this->authorizeOwner($convocatoria);

        $convocatoria->delete();

        return redirect()
            ->route('admin.convocatorias.index')
            ->with('success', 'Convocatoria eliminada correctamente.');
    }

    /**
     * Validación centralizada.
     */
    protected function validateData(Request $request): array
    {
        return $request->validate([
            'nombre_convocatoria' => ['required', 'string', 'max:255'],
            'lema'                => ['nullable', 'string', 'max:255'],
            'responsable'         => ['nullable', 'string', 'max:255'],
            'cargo'               => ['nullable', 'string', 'max:255'],
            'fecha_inicio'        => ['nullable', 'date'],
            'fecha_fin'           => ['nullable', 'date', 'after_or_equal:fecha_inicio'],
            'anio'                => ['required', 'digits:4'],
            'id_status'           => ['nullable'], // se procesa como boolean en el controlador
        ]);
    }

    /**
     * Solo el dueño puede modificar/ver su convocatoria.
     */
    protected function authorizeOwner(Convocatoria $convocatoria): void
    {
        if ($convocatoria->user_id !== auth()->id()) {
            abort(403, 'No autorizado.');
        }
    }
}
