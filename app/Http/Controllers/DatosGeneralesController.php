<?php

namespace App\Http\Controllers;

use App\Models\DatosGenerales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DatosGeneralesController extends Controller
{
    /** Redirige a edit si ya existe registro del usuario; si no, a create. */
    public function index()
    {
        $row = DatosGenerales::where('user_id', Auth::id())->first();

        return $row
            ? redirect()->route('usuario.datos-generales.edit', $row->id)
            : redirect()->route('usuario.datos-generales.create');
    }

    /**
     * Formulario de creación con catálogos y PRE-FILL desde catálogos Admin
     * Redirige a edición si ya existe registro del usuario.
     */
    public function create()
    {
        $existe = DatosGenerales::where('user_id', Auth::id())->first();
        if ($existe) {
            return redirect()->route('usuario.datos-generales.edit', $existe->id);
        }

        // Catálogos (incluye POSGRADOS)
        [$centros, $niveles, $orientaciones, $modalidades, $generos, $posgrados] = $this->catalogos();

        // Precarga desde pfp_posgrados y pfp_coordinadores
        $prefill = $this->prefillDesdeCatalogos();

        return view('usuario.datos-generales.create', compact(
            'centros', 'niveles', 'orientaciones', 'modalidades', 'generos', 'posgrados', 'prefill'
        ));
    }

    /** Guarda el registro con validación. */
    public function store(Request $request)
    {
        // Evitar duplicado por usuario
        if (DatosGenerales::where('user_id', Auth::id())->exists()) {
            $row = DatosGenerales::where('user_id', Auth::id())->first();
            return redirect()->route('usuario.datos-generales.edit', $row->id)
                ->with('info', 'Ya existe un registro, se abrió la edición.');
        }

        $data = $this->validatedData($request);
        $data['user_id'] = Auth::id();

        $row = DatosGenerales::create($data);

        return redirect()->route('usuario.datos-generales.edit', $row->id)
            ->with('success', 'Datos guardados correctamente.');
    }

    /** Formulario de edición con catálogos y PRE-FILL (solo para mostrar, no sobrescribe). */
    public function edit($id)
    {
        $row = DatosGenerales::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        [$centros, $niveles, $orientaciones, $modalidades, $generos, $posgrados] = $this->catalogos();
        $prefill = $this->prefillDesdeCatalogos($row);

        return view('usuario.datos-generales.edit', compact(
            'row', 'centros', 'niveles', 'orientaciones', 'modalidades', 'generos', 'posgrados', 'prefill'
        ));
    }

    /** Actualiza el registro. */
    public function update(Request $request, $id)
    {
        $row = DatosGenerales::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $data = $this->validatedData($request);
        $row->update($data);

        return back()->with('success', 'Datos actualizados correctamente.');
    }

    /** Reglas de validación. */
    protected function validatedData(Request $request): array
    {
        return $request->validate([
            // Foráneas obligatorias
            'centro_universitario_id'    => ['required', 'integer', 'exists:pfp_centros_universitarios,id'],
            'posgrado_id'                => ['required', 'integer', 'exists:pfp_posgrados,id'],
            'nivel_academico_id'         => ['required', 'integer', 'exists:pfp_niveles_academicos,id'],
            'orientacion_id'             => ['required', 'integer', 'exists:pfp_orientaciones,id'],
            'modalidad_id'               => ['required', 'integer', 'exists:pfp_modalidades,id'],

            // Coordinador
            'codigo'                     => ['nullable', 'string', 'max:50'],
            'clave_snp'                  => ['nullable', 'string', 'max:50'],
            'nombre_coordinador'         => ['nullable', 'string', 'max:255'],
            'correo_institucional'       => ['nullable', 'email',  'max:255'],
            'correo_alternativo'         => ['nullable', 'email',  'max:255'],
            'telefono'                   => ['nullable', 'string', 'max:50'],
            'extension'                  => ['nullable', 'string', 'max:50'],
            'celular'                    => ['nullable', 'string', 'max:50'],

            // Asistente
            'nombre_asistente'           => ['nullable', 'string', 'max:255'],
            'correo_asistente'           => ['nullable', 'email',  'max:255'],
            'telefono_asistente'         => ['nullable', 'string', 'max:50'],
            'extension_asistente'        => ['nullable', 'string', 'max:50'],
            'celular_asistente'          => ['nullable', 'string', 'max:50'],

            // Nuevos
            'fecha_nacimiento_asistente' => ['nullable', 'date'],
            'genero_id'                  => ['nullable', 'integer', 'exists:pfp_generos,id'],
        ]);
    }

    /** Catálogos para selects. */
    protected function catalogos(): array
    {
        $centros = DB::table('pfp_centros_universitarios')
            ->orderBy('centro_universitario')
            ->pluck('centro_universitario', 'id')
            ->toArray();

        $niveles = DB::table('pfp_niveles_academicos')
            ->orderBy('nivel_academico')
            ->pluck('nivel_academico', 'id')
            ->toArray();

        $orientaciones = DB::table('pfp_orientaciones')
            ->orderBy('orientacion')
            ->pluck('orientacion', 'id')
            ->toArray();

        $modalidades = DB::table('pfp_modalidades')
            ->orderBy('modalidad')
            ->pluck('modalidad', 'id')
            ->toArray();

        $generos = DB::table('pfp_generos')
            ->orderBy('genero')
            ->pluck('genero', 'id')
            ->toArray();

        $posgrados = DB::table('pfp_posgrados')
            ->orderBy('nombre_posgrado')
            ->pluck('nombre_posgrado', 'id')
            ->toArray();

        return [$centros, $niveles, $orientaciones, $modalidades, $generos, $posgrados];
    }

    /** Prefill desde catálogos */
    protected function prefillDesdeCatalogos(DatosGenerales $row = null): \stdClass
    {
        // … aquí tu lógica ya estaba correcta, no la modifiqué …
        // solo asegúrate de que devuelva los IDs reales
        // (ya que ahora son obligatorios en la validación)
        $user = Auth::user();

        $p = (object)[
            'centro_universitario_id' => null,
            'posgrado_id'             => null,
            'nivel_academico_id'      => null,
            'orientacion_id'          => null,
            'modalidad_id'            => null,
            'clave_snp'               => null,
            'codigo'                  => null,
            'nombre_coordinador'      => null,
            'correo_institucional'    => null,
            'correo_alternativo'      => null,
            'telefono'                => null,
            'extension'               => null,
            'celular'                 => null,
            'nombre_asistente'        => null,
            'correo_asistente'        => null,
            'telefono_asistente'      => null,
            'extension_asistente'     => null,
            'celular_asistente'       => null,
            'fecha_nacimiento_asistente' => null,
            'genero_id'               => null,
        ];

        // ... resto de tu código prefill ...
        return $p;
    }
}
