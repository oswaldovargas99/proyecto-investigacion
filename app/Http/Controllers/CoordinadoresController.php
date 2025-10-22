<?php

namespace App\Http\Controllers;

use App\Models\Coordinadores;
use App\Models\CentroUniversitario;
use App\Models\Posgrados;
use App\Models\Genero;
use App\Models\NivelesEstudios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CoordinadoresController extends Controller
{
    /**
     * Listado (con búsqueda opcional) -> vista Blade.
     */
    public function index(Request $request)
    {
        $q = $request->input('q');

        $coordinadores = Coordinadores::with([
                'centro:id,centro_universitario',
                'posgrado:id,nombre_posgrado',
                'genero:id,genero',
                'nivelEstudios:id,nivel_estudios',
            ])
            ->when($q, function ($query) use ($q) {
                $query->where(function ($w) use ($q) {
                        $w->where('nombre_coordinador', 'like', "%{$q}%")
                          ->orWhere('codigo', 'like', "%{$q}%")
                          ->orWhere('correo_institucional', 'like', "%{$q}%");
                    })
                    ->orWhereHas('centro', function ($c) use ($q) {
                        $c->where('centro_universitario', 'like', "%{$q}%");
                    })
                    ->orWhereHas('posgrado', function ($p) use ($q) {
                        $p->where('nombre_posgrado', 'like', "%{$q}%");
                    })
                    ->orWhereHas('genero', function ($g) use ($q) {
                        $g->where('genero', 'like', "%{$q}%");
                    })
                    ->orWhereHas('nivelEstudios', function ($n) use ($q) {
                        $n->where('nivel_estudios', 'like', "%{$q}%");
                    });
            })
            ->orderBy('nombre_coordinador')
            ->paginate(2)
            ->withQueryString();

        return view('administrador.coordinadores.index', compact('coordinadores', 'q'));
    }

    /**
     * Formulario de creación -> vista Blade.
     */
    public function create()
    {
        $centros          = CentroUniversitario::orderBy('centro_universitario')->get();
        $posgrados        = Posgrados::orderBy('nombre_posgrado')->get();
        $generos          = Genero::orderBy('genero')->get();
        $nivelesEstudios  = NivelesEstudios::orderBy('nivel_estudios')->get();

        return view('administrador.coordinadores.create', compact(
            'centros','posgrados','generos','nivelesEstudios'
        ));
    }

    /**
     * Guardar -> redirect con mensaje.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'codigo'                  => ['required','string','max:50','unique:pfp_coordinadores,codigo'],
            'nombre_coordinador'      => ['required','string','max:255'],
            'centro_universitario_id' => ['required','exists:pfp_centros_universitarios,id'],
            'posgrado_id'             => ['required','exists:pfp_posgrados,id'],
            'genero_id'               => ['required','exists:pfp_generos,id'],
            'nivel_estudios_id'       => ['required','exists:pfp_niveles_estudios,id'],
            'fecha_nacimiento'        => ['required','date','before:today'],
            'correo_institucional'    => ['required','email','max:255','unique:pfp_coordinadores,correo_institucional'],
            'correo_alternativo'      => ['nullable','email','max:255'],
            'telefono'                => ['nullable','string','max:20'],
            'extension'               => ['nullable','string','max:10'],
            'celular'                 => ['nullable','string','max:20'],
        ]);

        // Vincular al usuario autenticado
        $data = $validated + ['user_id' => Auth::id()];

        Coordinadores::create($data);

        return redirect()
            ->route('admin.coordinadores.index')
            ->with('success', 'Coordinador creado correctamente.');
    }

    /**
     * Detalle -> vista Blade.
     */
    public function show(Coordinadores $coordinador)
    {
        $coordinador->load([
            'centro:id,centro_universitario',
            'posgrado:id,nombre_posgrado',
            'genero:id,genero',
            'nivelEstudios:id,nivel_estudios',
        ]);

        return view('administrador.coordinadores.show', compact('coordinador'));
    }

    /**
     * Formulario de edición -> vista Blade.
     */
    public function edit(Coordinadores $coordinador)
    {
        $centros          = CentroUniversitario::orderBy('centro_universitario')->get();
        $posgrados        = Posgrados::orderBy('nombre_posgrado')->get();
        $generos          = Genero::orderBy('genero')->get();
        $nivelesEstudios  = NivelesEstudios::orderBy('nivel_estudios')->get();

        return view('administrador.coordinadores.edit', compact(
            'coordinador','centros','posgrados','generos','nivelesEstudios'
        ));
    }

    /**
     * Actualizar -> redirect con mensaje.
     */
    public function update(Request $request, Coordinadores $coordinador)
    {
        $validated = $request->validate([
            'codigo'                  => ['required','string','max:50', Rule::unique('pfp_coordinadores','codigo')->ignore($coordinador->id)],
            'nombre_coordinador'      => ['required','string','max:255'],
            'centro_universitario_id' => ['required','exists:pfp_centros_universitarios,id'],
            'posgrado_id'             => ['required','exists:pfp_posgrados,id'],
            'genero_id'               => ['required','exists:pfp_generos,id'],
            'nivel_estudios_id'       => ['required','exists:pfp_niveles_estudios,id'],
            'fecha_nacimiento'        => ['required','date','before:today'],
            'correo_institucional'    => ['required','email','max:255', Rule::unique('pfp_coordinadores','correo_institucional')->ignore($coordinador->id)],
            'correo_alternativo'      => ['nullable','email','max:255'],
            'telefono'                => ['nullable','string','max:20'],
            'extension'               => ['nullable','string','max:10'],
            'celular'                 => ['nullable','string','max:20'],
        ]);

        // Mantener user_id del registro (no editable)
        $data = $validated + ['user_id' => $coordinador->user_id];

        $coordinador->update($data);

        return redirect()
            ->route('admin.coordinadores.index')
            ->with('warning', 'Coordinador actualizado correctamente.');
    }

    /**
     * Eliminar -> redirect con mensaje.
     */
    public function destroy(Coordinadores $coordinador)
    {
        $coordinador->delete();

        return redirect()
            ->route('admin.coordinadores.index')
            ->with('danger', 'Coordinador eliminado correctamente.');
    }
}
