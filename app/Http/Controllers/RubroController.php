<?php

namespace App\Http\Controllers;

use App\Models\Rubro;
use App\Models\RubroCategoria;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class RubroController extends Controller
{
    public function index(Request $request)
    {
        $q   = trim((string) $request->get('q', ''));
        $cat = $request->get('categoria_id');

        $rubros = Rubro::with('categoria')
            ->search($q)
            ->categoria($cat)
            ->ordenPor('concepto','asc')
            ->paginate(10)
            ->withQueryString();

        $categorias     = RubroCategoria::orderBy('categoria')->get(['id','categoria']);
        $categoriasMap  = RubroCategoria::orderBy('categoria')->pluck('categoria','id')->toArray();

        // Renderiza vistas en carpeta "administrador"
        return view('administrador.rubros.index', compact('rubros','categorias','categoriasMap','q','cat'));
    }

    public function create()
    {
        $categorias = RubroCategoria::orderBy('categoria')->get(['id','categoria']);
        return view('administrador.rubros.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'rubro'        => ['required','string','max:50','unique:pfp_rubros,rubro'],
            'concepto'     => ['required','string','max:255'],
            'categoria_id' => ['nullable','integer','exists:pfp_rubros_categorias,id'],
        ]);

        $rubro = Rubro::create($data);

        return $request->wantsJson()
            ? response()->json(['ok' => true, 'rubro' => $rubro], 201)
            : redirect()->route('admin.rubros.index')->with('success', 'Rubro creado correctamente.');
    }

    public function show(Rubro $rubro)
    {
        $rubro->load('categoria:id,categoria');
        return view('administrador.rubros.show', compact('rubro'));
    }

    public function edit(Rubro $rubro)
    {
        $categorias = RubroCategoria::orderBy('categoria')->get(['id','categoria']);
        return view('administrador.rubros.edit', compact('rubro','categorias'));
    }

    public function update(Request $request, Rubro $rubro)
    {
        $data = $request->validate([
            'rubro'        => ['required','string','max:50','unique:pfp_rubros,rubro,'.$rubro->id],
            'concepto'     => ['required','string','max:255'],
            'categoria_id' => ['nullable','integer','exists:pfp_rubros_categorias,id'],
        ]);

        $rubro->update($data);

        return $request->wantsJson()
            ? response()->json(['ok' => true, 'rubro' => $rubro])
            : redirect()->route('admin.rubros.index')->with('warning', 'Rubro actualizado correctamente.');
    }

    public function destroy(Rubro $rubro)
    {
        try {
            $rubro->delete();

            return request()->wantsJson()
                ? response()->json(['ok' => true])
                : redirect()->route('admin.rubros.index')->with('danger', 'Rubro eliminado correctamente.');
        } catch (QueryException $e) {
            $msg = 'No se puede eliminar el rubro porque está siendo utilizado en otros registros.';
            return request()->wantsJson()
                ? response()->json(['ok' => false, 'message' => $msg], 409)
                : back()->with('danger', $msg);
        }
    }
}
