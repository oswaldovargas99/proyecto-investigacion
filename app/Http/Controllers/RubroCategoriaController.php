<?php

namespace App\Http\Controllers;

use App\Models\RubroCategoria;
use Illuminate\Http\Request;

class RubroCategoriaController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->get('q', ''));

        $categorias = RubroCategoria::query()
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($qq) use ($q) {
                    $qq->where('categoria', 'like', "%{$q}%")
                       ->orWhere('descripcion', 'like', "%{$q}%");
                });
            })
            ->latest('id')
            ->paginate(10)
            ->withQueryString();

        return view('administrador.rubros-categorias.index', compact('categorias', 'q'));
    }

    public function create()
    {
        $categoria = new RubroCategoria();
        return view('administrador.rubros-categorias.create', compact('categoria'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'categoria'   => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
        ]);

        RubroCategoria::create($data);

        return redirect()
            ->route('admin.rubros-categorias.index')
            ->with('success', 'Categoría creada correctamente.');
    }

    public function show(RubroCategoria $categoria)   // <-- nombre alineado
    {
        return view('administrador.rubros-categorias.show', compact('categoria'));
    }

    public function edit(RubroCategoria $categoria)   // <-- nombre alineado
    {
        return view('administrador.rubros-categorias.edit', compact('categoria'));
    }

    public function update(Request $request, RubroCategoria $categoria) // <-- nombre alineado
    {
        $data = $request->validate([
            'categoria'   => ['required', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string'],
        ]);

        $categoria->update($data);

        return redirect()
            ->route('admin.rubros-categorias.index')
            ->with('success', 'Categoría actualizada correctamente.');
    }

    public function destroy(RubroCategoria $categoria) // <-- nombre alineado
    {
        if (method_exists($categoria, 'rubros') && $categoria->rubros()->exists()) {
            return back()->with('danger', 'No se puede eliminar: existen rubros asociados a esta categoría.');
        }

        $categoria->delete();

        return redirect()
            ->route('admin.rubros-categorias.index')
            ->with('danger', 'Categoría eliminada.');
    }
}
